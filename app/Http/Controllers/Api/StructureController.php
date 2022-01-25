<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StructureResource;
use App\Models\Structure;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class StructureController extends Controller
{
   public function index($year)
   {
      $query = Structure::where('year', $year);
      $structure = QueryBuilder::for($query)
         ->allowedFilters('name', 'year')
         ->get();
      return response()->json(
         [
            "data" => StructureResource::collection($structure),
            "status" => 201
         ]
      );
   }
}
