<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buster;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BusterController extends Controller
{
    public function index(){
      $query = Buster::query();
      $buster = QueryBuilder::for($query)
         ->allowedFilters('name')
         ->get();

      return response()->json(
         [
            "data" =>  $buster,
            "status" => 201
         ]
      );
    }
}
