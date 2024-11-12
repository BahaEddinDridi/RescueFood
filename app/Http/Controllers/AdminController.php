<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    $notifications = auth()->user()->notifications()->where('type', 'new_registration')->get();
    
    return view('admin.dashboard', compact('notifications'));
}

    public function showAdminNotifications()
    {
        $notifications = auth()->user()->notifications;
        
        return view('admin.dashboard', compact('notifications'));
    }
}
