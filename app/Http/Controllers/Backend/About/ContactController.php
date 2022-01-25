<?php

namespace App\Http\Controllers\Backend\About;

use App\Models\File;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Intervention\Image\Facades\Image;

class ContactController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $contacts = Contact::latest()->get();
         return DataTables::of($contacts)
            ->addColumn('action', function ($contact) {
               return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $contact->id . ')"><i class="fa fa-trash"></i></span></a>
                           <a class="btn btn-info btn-sm" onclick="editItem(' . $contact->id . ')"><i class="fa fa-pencil"></i></span></a>
                           ';
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
      }
      $data['title'] = "CONTACT";
      return view('backend.about.contact.index', $data);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $path = null;
      $contact = new Contact();
      $contact->alamat = $request->alamat;
      $contact->no_hp = $request->no_hp;
      $contact->email = $request->email;
      $contact->lokasi = $request->lokasi;
      $contact->instagram = $request->instagram;
      $contact->facebook = $request->facebook;
      $contact->youtube = $request->youtube;
      $contact->save();
      return $contact;
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Contact  $contact
    * @return \Illuminate\Http\Response
    */
   public function show(Contact $contact)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Contact  $contact
    * @return \Illuminate\Http\Response
    */
   public function edit(Contact $contact)
   {


      return $contact;
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Contact  $contact
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Contact $contact)
   {

      $contact->update($request->all());
      $contact->save();
      return $contact;
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Contact  $contact
    * @return \Illuminate\Http\Response
    */
   public function destroy(Contact $contact)
   {
      if (count($contact->files) > 0) {
         $id = $contact->files->first()->id;
         $img = File::find($id);
         if (Storage::exists("public/" . $img->link)) {
            Storage::delete("public/" . $img->link);
            $img->delete();
         }
      }
      $contact->delete();
      return response()->json(['message', 'deleted success']);
   }
}
