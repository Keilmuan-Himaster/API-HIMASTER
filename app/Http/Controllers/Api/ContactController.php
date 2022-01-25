<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ContactController extends Controller
{
   public function index()
   {
      $query = Contact::query();
      $contact = QueryBuilder::for($query)
         ->allowedFilters('name')
         ->get();

      return response()->json(
         [
            "data" =>  ContactResource::collection($contact),
            "status" => 201
         ]
      );
   }
}
