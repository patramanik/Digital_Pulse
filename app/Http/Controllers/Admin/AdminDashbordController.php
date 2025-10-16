<?php

namespace App\Http\Controllers\Admin;


use App\Models\work;
use App\Models\career;
use App\Models\services;
use App\Models\contactus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashbordController extends Controller
{
    public function index(){
        $contact_count = contactus::count();
        $contacts = contactus::all();
        $work_count = work::count();
        $careers_count = career::count();
        $services_count = services::count();
        return view('admin', compact('contact_count', 'work_count', 'careers_count', 'services_count','contacts'));
    }



}
