<?php

namespace App\Http\Controllers\Backend\About;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Intervention\Image\Facades\Image;
class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


      if ($request->ajax()) {
         if($request->year!= null){
            $year = intval($request->year);
            $structures = Structure::where('year',$year)->get();
         }else{
            $latestyear = Structure::orderBy('year','desc')->first();
            $structures = Structure::where('year',$latestyear->year)->get();

         }

         return DataTables::of($structures)
         ->addColumn('image', function ($structure) {
            if(count($structure->files)>0){
               return '
            <img height="200px" src="'.asset('storage/'.$structure->files->first()->link).'">
                     ';
            }else{
               return'';
            }

        })


             ->addColumn('action', function ($structure) {
                 return '

                          <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $structure->id . ')"><i class="fa fa-trash"></i></span></a>
                          <a class="btn btn-info btn-sm" onclick="editItem(' . $structure->id . ')"><i class="fa fa-pencil"></i></span></a>
                          ';
             })

             ->removeColumn('id')
             ->addIndexColumn()
             ->rawColumns(['action','image'])
             ->make(true);
     }
     $data['title'] = "STRUCTURE";
     $data['year'] = Structure::all()->unique('year')->sortByDesc('year');

     return view('backend.about.structure.index', $data);
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
      $structure = new Structure();
      $path = null;
      $structure->name = $request->name;
      $structure->year =$request->year;
      $structure->description =$request->description;
      $structure->save();
      if ($request->file('image')) {
         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['image'])->resize(null, 300, function ($constraint) {
             $constraint->aspectRatio();
             $constraint->upsize();
         })->encode('png', 100);
         $namePath = "structures";
         $path = $namePath . "/" . $name_picture;

         Storage::put("public/" . $path, $picture);
         // dd(Storage::exists($content->images));
     }
     if ($path != null) {
         $structure->files()->create(['link' => $path, 'type' => 'image']);

     }
     //   dd($content->files);
      return $structure;
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
    public function edit(Structure $structure)
    {
        return $structure;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Structure $structure)
    {
      $path= null;

      $structure->name = $request->name;
      $structure->year = $request->year;
      $structure->description = $request->description;
      $structure->save();

      if ($request->file('image')) {

            if (Storage::exists("public/" . $structure->files->first()->link)) {
               Storage::delete("public/" . $structure->files->first()->link);
               $structure->files->first()->delete();
               }



         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['image'])->resize(null, 300, function ($constraint) {
             $constraint->aspectRatio();
             $constraint->upsize();
         })->encode('png', 100);
         $namePath = "structures";
         $path = $namePath . "/" . $name_picture;




         Storage::put("public/" . $path, $picture);

         $structure->files()->create(['link' => $path, 'type' => 'image']);
         // dd($structure->files);
         // dd(Storage::exists($content->images));
     }



      return $structure;



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Structure $structure)
    {
        $id = $structure->files->first()->id;

        $img = File::find($id);

          if (Storage::exists("public/" . $img->link)) {
              Storage::delete("public/" . $img->link);
              $img->delete();

      }
      $structure->delete();
      return response()->json(['message', 'deleted success']);
    }
}
