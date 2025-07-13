<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Catagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashbordController extends Controller
{
    public function index(){
        return view('dashboard');
    }

}
