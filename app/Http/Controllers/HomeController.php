<?php

namespace App\Http\Controllers;

use App\Models\Content;

class HomeController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
   public function index()
   {
      $data['title'] = "DASHBOARD";
      $data['contents'] = Content::all();
      $data['publish'] = Content::where('status', true)->get();
      $data['draft'] = Content::where('status', false)->get();
      return view('backend.dashboard', $data);
   }
}
