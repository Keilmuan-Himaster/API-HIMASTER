<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Structure;
use Spatie\QueryBuilder\QueryBuilder;

class GalleryController extends Controller
{
    public function index(){
      $query = Gallery::query();
      $gallery = QueryBuilder::for($query)
         ->allowedFilters('name')
         ->get();

      return response()->json(
         [
            "data" =>  $gallery,
            "status" => 201
         ]
      );
    }

    public function indexByStructure($name){
      $data = Structure::where('name', $name)->first();

      if ($data == null) {
         return response()->json(
            [
               "status" => 404
            ]
         );
      }
      $query = Gallery::where('structure_id', $data->id);
      $gallery = QueryBuilder::for($query)
         ->allowedFilters('name')
         ->get();

      return response()->json(
         [
            "data" =>  $gallery,
            "status" => 201
         ]
      );
    }
}
