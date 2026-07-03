<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Package;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    
    public function index()
{
    $activities = Activity::all();

    return view('user.dashboard', compact('activities'));
}

    
    public function showPackages($category)
    {
        
        $packages = Package::all();

        
        return view('book-form', compact('packages', 'category'));
    }

    
    public function listAll()
    {
        
        $activities = Activity::all(); 

        return view('user.activities-list', compact('activities'));
    }

    
    public function showDetail($id)
    {
        
        $activity = Activity::findOrFail($id);

        
        if (isset($activity->facilities) && !is_array($activity->facilities)) {
            $activity->facilities = array_map('trim', explode(',', $activity->facilities));
        }

        return view('user.activity-detail', compact('activity'));
    }
}