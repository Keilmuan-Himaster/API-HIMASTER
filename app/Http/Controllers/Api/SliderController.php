<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
   public function index()
   {
      $sliders = Slider::latest()->with('files')->paginate(5);

      return response()->json(
         [
            "mainlink" => url('storage/'),
            "data" => $sliders,

            "status" => 201
         ]
      );
   }
}
