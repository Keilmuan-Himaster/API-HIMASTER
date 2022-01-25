<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Str;

class SliderController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $sliders = Slider::latest()->get();
         return DataTables::of($sliders)
            ->addColumn('image', function ($slider) {
               return '
             <img height="200px" src="' . asset("storage/" . $slider->files->first()->link) . '">
                      ';
            })
            ->addColumn('action', function ($contact) {
               return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $contact->id . ')"><i class="fa fa-trash"></i></span></a>
                           <a class="btn btn-info btn-sm" onclick="editItem(' . $contact->id . ')"><i class="fa fa-pencil"></i></span></a>
                           ';
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'image'])
            ->make(true);
      }
      $data['title'] = "SLIDER";
      return view('backend.slider.index', $data);
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
      $slider = new Slider();
      $slider->title = $request->title;
      $slider->description = $request->description;
      $slider->save();
      if ($request->file('file')) {
         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['file'])->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
         })->encode('png', 100);
         $namePath = "sliders";
         $path = $namePath . "/" . $name_picture;

         Storage::put("public/" . $path, $picture);
      }
      if ($path != null) {
         $slider->files()->create(['link' => $path, 'type' => 'image']);
      }
      return $slider;
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Slider $slider)
   {
      return $slider;
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Slider $slider)
   {
      $path = null;
      $slider->title = $request->title;
      $slider->description = $request->description;
      $slider->save();

      if ($request->file('file')) {
         if (count($slider->files) > 0) {
            if (Storage::exists("public/" . $slider->files->first()->link)) {
               Storage::delete("public/" . $slider->files->first()->link);
               $slider->files->first()->delete();
            }
         }




         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['file'])->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
         })->encode('png', 100);
         $namePath = "sliders";
         $path = $namePath . "/" . $name_picture;




         Storage::put("public/" . $path, $picture);

         $slider->files()->create(['link' => $path, 'type' => 'image']);
      }



      return $slider;
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Slider $slider)
   {
      if (count($slider->files) > 0) {
         $id = $slider->files->first()->id;
         $img = File::find($id);
         if (Storage::exists("public/" . $img->link)) {
            Storage::delete("public/" . $img->link);
            $img->delete();
         }
      }
      $slider->delete();
      return response()->json(['message', 'deleted success']);
   }
}
