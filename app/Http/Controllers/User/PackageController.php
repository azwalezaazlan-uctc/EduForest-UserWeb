<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $categoryInput = $request->query('category', 'upsi');

        switch ($categoryInput) {
            case 'gov':
                $priceColumn = 'price_gov';
                $categoryTitle = 'Government Agency';
                $currency = 'RM';
                break;

            case 'public':
                $priceColumn = 'price_public';
                $categoryTitle = 'Public Participant';
                $currency = 'RM';
                break;

            case 'international':
                $priceColumn = 'price_international';
                $categoryTitle = 'International Participant';
                $currency = 'USD';
                break;

            case 'upsi':
            default:
                $priceColumn = 'price_upsi';
                $categoryTitle = 'UPSI Community';
                $currency = 'RM';
                break;
        }

        $packages = DB::table('packages')->orderBy('id')->get();

        return view('user.packages', compact(
            'packages',
            'priceColumn',
            'categoryInput',
            'categoryTitle',
            'currency'
        ));
    }
}