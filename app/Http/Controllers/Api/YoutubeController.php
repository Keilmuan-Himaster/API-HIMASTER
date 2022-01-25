<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function index(){
       return response()->json(
         [
         'data' => [
               ['title' => 'Pengenalan Mahasiswa 2020',
               'link' => 'https://www.youtube.com/embed/LnB6wIlYE90'
            ],
               ['title' => 'Persamaan Differensial',
               'link' => 'https://www.youtube.com/embed/6tBc7QiWCNw'
            ],
         ],
         'status' => 201
         ]
       );
    }
}
