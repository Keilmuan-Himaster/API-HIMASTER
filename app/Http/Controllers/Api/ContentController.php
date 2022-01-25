<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Content;
use Spatie\QueryBuilder\QueryBuilder;

class ContentController extends Controller
{
   public function index(Request $request)
   {
      $page_size = $request->input('page_size'); // User input
      $query = Content::latest();
      $content = QueryBuilder::for($query)
         ->allowedFilters('title')
         ->paginate($page_size);
      ContentResource::collection($content);
      return response()->json(
         [
            "data" => $content,
            "status" => 201
         ]
      );
   }

   public function indexByCategory($slug)
   {
      $data = Category::where('slug', $slug)->first();

      if ($data == null) {
         return response()->json(
            [
               "status" => 404
            ]
         );
      }
      $query = Content::where('category_id', $data->id);
      $content = QueryBuilder::for($query)
         ->paginate(5);
      ContentResource::collection($content);
      return response()->json(
         [
            "data" => $content,
            "status" => 201
         ]
      );
   }

   public function indexCategory()
   {
      $query = Category::latest();
      $category = QueryBuilder::for($query)->get();
      return response()->json(
         [
            "data" => $category,
            "status" => 201
         ]
      );
   }

   public function show($slug)
   {
      $query = Content::where('slug', $slug);
      $content = QueryBuilder::for($query)
         ->firstOrFail();
         $content = new ContentResource($content);
      return response()->json(
         [
            "data" => $content,
            "status" => 201
         ]
      );
   }
}
