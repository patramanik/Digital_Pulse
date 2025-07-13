<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function services()
    {
        return view('landing.services');
    }

    public function ourwork()
    {
        return view('landing.our-work');
    }

    public function career()
    {
        return view('landing.career');
    }


    public function seo()
    {
        return view('landing.seo');
    }

    public function socialmedia()
    {
        return view('landing.social-media');
    }

    public function pragent()
    {
        return view('landing.pr-agent');
    }


    public function influencer()
    {
        return view('landing.influencer');
    }

    public function contact()
    {
        return view('landing.contact');
    }




}
