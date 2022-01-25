<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MemberController extends Controller
{
   public function index($year)
   {
      $query = Member::where('priod', $year);
      $member = QueryBuilder::for($query)
         ->allowedFilters('name', 'year')
         ->get();
      $get = MemberResource::collection($member);
      return response()->json(
         [
            "data" => $get,
            "status" => 201
         ]
      );
   }
   public function onDivisi($year, $divisi)
   {
      $data = Structure::where('year', $year)->where('name', $divisi)->pluck('id');
      $query = Member::whereIn('structure_id', $data);
      $member = QueryBuilder::for($query)
         ->allowedFilters('name', 'year')
         ->paginate(5);
      $get = MemberResource::collection($member);
      return response()->json(
         [
            "data" => $get,
            "status" => 201
         ]
      );
   }
}
