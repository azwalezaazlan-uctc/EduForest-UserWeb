<?php

use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileCompletionController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\RegisteredClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    $bookingDates = DB::table('booking_dates')->get();

    $fullyBookedDates = $bookingDates
        ->where('status', 'fully_booked')
        ->map(fn($d) => \Carbon\Carbon::parse($d->booking_date)->format('Y-m-d'))
        ->values();

    $publicHolidayDates = $bookingDates
        ->where('status', '!=', 'fully_booked')
        ->map(fn($d) => \Carbon\Carbon::parse($d->booking_date)->format('Y-m-d'))
        ->values();

    return view('user.home', compact('fullyBookedDates', 'publicHolidayDates'));
})->name('home');


Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

Route::get('/activities-list', [ActivityController::class, 'listAll'])->name('activities.list');
Route::get('/activity/{id}', [ActivityController::class, 'showDetail'])->name('activity.detail');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [ProfileCompletionController::class, 'showForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileCompletionController::class, 'store'])->name('profile.store');

    Route::get('/dashboard', [ActivityController::class, 'index'])->name('dashboard');

    Route::get('/booking/categories', function () {
    $bookingDates = DB::table('booking_dates')->get();
    $slots = DB::table('slots')->get();
    $packages = DB::table('packages')->orderBy('id')->get();

    return view('booking.categories', compact('bookingDates', 'slots', 'packages'));
})->name('booking.categories');

    Route::get('/booking/category/{category}', [ActivityController::class, 'showPackages'])->name('booking.category');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking-confirmation', [BookingController::class, 'showConfirmation'])->name('booking.confirmation');

    Route::get('/book-form', function (Request $request) {
        $categoryInput = $request->query('category', 'upsi');

        switch ($categoryInput) {
            case 'gov':
                $categoryTitle = 'Government Agency';
                break;
            case 'public':
                $categoryTitle = 'Public Participant';
                break;
            case 'international':
                $categoryTitle = 'International Participant';
                break;
            case 'upsi':
            default:
                $categoryTitle = 'UPSI Student / Staff';
                break;
        }

        return view('user.book-form', compact('categoryTitle', 'categoryInput'));
    })->name('book-form');

    Route::get('/my-bookings', function () {
    $bookings = DB::table('bookings')
        ->where('client_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.MyBookings', compact('bookings'));
})->name('my-bookings');

    Route::get('/payment/{reference_number}', [PaymentController::class, 'showPayment'])->name('payment.instruction');
    Route::post('/payment/{reference_number}/submit', [PaymentController::class, 'submitReceipt'])->name('payment.submit');
    Route::get('/payment/{reference_number}/status', [PaymentController::class, 'showStatus'])->name('payment.status');

    Route::get('/notifications', function () {
        $notifications = DB::table('notifications')->orderBy('created_at', 'desc')->get();
        return view('notifications', compact('notifications'));
    })->name('notifications.index');

    Route::get('/profile', function () {
    $profile = DB::table('profiles')->where('id', Auth::id())->first();

    if (! $profile) {
        return redirect()->route('profile.complete');
    }

    return view('user.profile', compact('profile'));
})->name('profile.show');

Route::get('/profile/edit', function () {
    $profile = DB::table('profiles')->where('id', Auth::id())->first();

    if (! $profile) {
        return redirect()->route('profile.complete');
    }

    return view('user.profile-edit', compact('profile'));
})->name('profile.edit');

    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/maps', function () {
    return view('user.maps');
})->name('maps.index');

Route::get('/contact-us', function () {
    return view('user.contact');
})->name('contact.us');

Route::get('/help-and-support', function () {
    return view('user.support');
})->name('help.support');

Route::get('/emergency', function () {
    return view('user.emergency');
})->name('emergency');

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $admin = DB::table('admins')->where('email', $request->email)->first();

    if (! $admin || ! password_verify($request->password, $admin->password)) {
        return back()->withErrors([
            'email' => 'Invalid admin email or password.',
        ]);
    }

    session([
        'admin_logged_in' => true,
        'admin_id' => $admin->id,
        'admin_email' => $admin->email,
        'admin_name' => $admin->full_name ?? 'Admin',
    ]);

    return redirect()->route('admin.dashboard');
})->name('admin.login.submit');

Route::post('/admin/logout', function (Request $request) {
    $request->session()->forget([
        'admin_logged_in',
        'admin_id',
        'admin_email',
        'admin_name',
    ]);

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
    if (! session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    $totalClients = DB::table('bookings')
        ->distinct('client_email')
        ->count('client_email');

    $pendingBookings = DB::table('bookings')
        ->where('status', 'pending')
        ->count();

    $pendingPayments = DB::table('payments')
        ->where('status', 'pending')
        ->count();

    $blockedDatesCount = DB::table('booking_dates')->count();

    $recentBookings = DB::table('bookings')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalClients', 'pendingBookings', 'pendingPayments',
        'blockedDatesCount', 'recentBookings'
    ));
})->name('dashboard');

    Route::get('/registered-clients', [RegisteredClientController::class, 'index'])->name('clients');

    Route::get('/booking-requests', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking-requests/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{booking}/verify', [AdminPaymentController::class, 'verifyPayment'])->name('payments.verify');

    Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/slots', [SlotController::class, 'store'])->name('slots.store');
    Route::delete('/slots/{id}', [SlotController::class, 'destroy'])->name('slots.destroy');

    Route::get('/account-setting', function () {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $admin = DB::table('admins')->where('id', session('admin_id'))->first();

        return view('admin.account-setting', compact('admin'));
    })->name('account-setting');

    Route::put('/account-setting/password', function (Request $request) {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:8', 'confirmed'],
        ]);

        $admin = DB::table('admins')->where('id', session('admin_id'))->first();

        if (! $admin || ! password_verify($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        DB::table('admins')->where('id', session('admin_id'))->update([
            'password' => password_hash($request->new_password, PASSWORD_BCRYPT),
        ]);

        return back()->with('success', 'Password updated successfully.');
    })->name('account-setting.password');
});