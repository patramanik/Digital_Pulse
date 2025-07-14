<?php

namespace App\Http\Controllers;

use App\Models\work;
use App\Models\career;
use App\Models\services;
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
        $services = services::all();

        return view('landing.services', compact('services'));
    }

    public function ourwork()
    {
        $works = work::all();
        return view('landing.our-work',compact('works'));
    }

    public function career()
    {
        $careers = career::all();
        return view('landing.career',compact('careers'));
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
