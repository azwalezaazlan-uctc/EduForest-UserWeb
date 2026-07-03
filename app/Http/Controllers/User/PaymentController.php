<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct(private readonly SupabaseStorageService $storageService)
    {
    }

    
    private function resolvePackageName($packageId): string
    {
        $map = [1 => 'PACKAGE A', 2 => 'PACKAGE B', 3 => 'PACKAGE C'];
        return $map[intval($packageId)] ?? ('PACKAGE ' . $packageId);
    }

    
    public function showPayment($reference_number)
{
    $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();

    if (!$booking) {
        abort(404, 'Maklumat tempahan tidak ditemui.');
    }

    $package = DB::table('packages')->where('id', $booking->package_id)->first();

    $packageName = $package->name ?? $package->package_name ?? $this->resolvePackageName($booking->package_id);

    return view('payment.instruction', compact('booking', 'package', 'packageName'));
}

    
    public function submitReceipt(Request $request, $reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404, 'Maklumat tempahan tidak ditemui.');

        $receiptUrl = 'pending_upload_local';

        
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');

            
            $fileContent = file_get_contents($file->getRealPath());
            $mimeType    = $file->getClientMimeType();
            $ext         = $file->getClientOriginalExtension();

            
            $fileName = $booking->reference_number . '_receipt_' . time() . '.' . $ext;

            $uploadResult = $this->storageService->upload(
                'payment-receipts',
                $fileName,
                $fileContent,
                $mimeType
            );

            if ($uploadResult['ok']) {
                $receiptUrl = $uploadResult['public_url'];
            }
        }
        

        
        DB::table('payments')->insert([
            'booking_id'  => $booking->id,
            'receipt_url' => $receiptUrl,
            'status'      => 'pending',
            'created_at'  => now(),
        ]);

        
        
            
            

        return redirect()
    ->route('payment.instruction', $reference_number)
    ->with('payment_success', true);
    }

    
    public function showStatus($reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404, 'Maklumat tempahan tidak ditemui.');

        $packageName = $this->resolvePackageName($booking->package_id);

        
        $payment = DB::table('payments')
            ->where('booking_id', $booking->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $isApproved = $payment && strtolower($payment->status ?? '') === 'approved';

        return view('payment.status', compact('booking', 'packageName', 'payment', 'isApproved'));
    }

    
    public function downloadInvoice($reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404);

        $payment = DB::table('payments')
            ->where('booking_id', $booking->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$payment || strtolower($payment->status ?? '') !== 'approved') {
            abort(403, 'Invoice belum diluluskan oleh admin.');
        }

        $packageName = $this->resolvePackageName($booking->package_id);

        return view('payment.invoice', compact('booking', 'packageName', 'payment'));
    }
}
