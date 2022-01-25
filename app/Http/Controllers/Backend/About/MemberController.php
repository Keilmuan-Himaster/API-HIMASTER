<?php

namespace App\Http\Controllers\Backend\About;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Member;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      $lastyear = Structure::latest()->get();
      if ($request->ajax()) {
         if ($request->year != null) {
            $year = intval($request->year);

            $members = Member::where('priod', $year)->get();
         } else {
            $latestyear = Structure::orderBy('year', 'desc')->first();
            $members = Member::where('priod', $latestyear->year)->get();
         }

         return DataTables::of($members)
            ->addColumn('image', function ($member) {
               if (count($member->files) > 0) {
                  return '
            <img height="200px" src="' . asset('storage/' . $member->files->first()->link) . '">
                     ';
               } else {
                  return '';
               }
            })
            ->addColumn('struc', function ($member) {
               return $member->structure->name;
            })


            ->addColumn('action', function ($member) {
               return '

                          <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $member->id . ')"><i class="fa fa-trash"></i></span></a>
                          <a class="btn btn-info btn-sm" onclick="editItem(' . $member->id . ')"><i class="fa fa-pencil"></i></span></a>
                          ';
            })

            ->removeColumn('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'image'])
            ->make(true);
      }
      $data['title'] = "ANGGOTA";
      $latestyear = Structure::orderBy('year', 'desc')->first();
      $data['structure'] = Structure::orderBy('year', 'desc')->get();


      $data['year'] = Structure::all()->unique('year')->sortByDesc('year');

      return view('backend.about.member.index', $data);
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
      $member = new Member();
      $member->name = $request->name;
      $member->nim = $request->nim;
      $member->year = $request->year;
      $member->address = $request->address;
      $member->grade = $request->grade;
      $member->majors = $request->majors;
      $member->priod = Structure::find($request->structure_id)->year;
      $member->structure_id = $request->structure_id;

      $member->save();
      if ($request->file('image')) {
         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['image'])->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
         })->encode('png', 100);
         $namePath = "members";
         $path = $namePath . "/" . $name_picture;

         Storage::put("public/" . $path, $picture);
         // dd(Storage::exists($content->images));
      }
      if ($path != null) {
         $member->files()->create(['link' => $path, 'type' => 'image']);
      }
      //   dd($content->files);
      return $member;
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
   public function edit($id)
   {
      $member = Member::where('id', $id)->first();

      return $member;
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Member $member)
   {
      $path = null;

      $member->name = $request->name;
      $member->nim = $request->nim;
      $member->year = $request->year;
      $member->address = $request->address;
      $member->grade = $request->grade;
      $member->majors = $request->majors;
      $member->priod = Structure::find($request->structure_id)->year;
      $member->structure_id = $request->structure_id;
      $member->save();

      if ($request->file('image')) {
         if (count($member->files) > 0) {
            if (Storage::exists("public/" . $member->files->first()->link)) {
               Storage::delete("public/" . $member->files->first()->link);
               $member->files->first()->delete();
            }
         }




         $name_picture = Str::random(6) . '.png';
         $picture = Image::make($request['image'])->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
         })->encode('png', 100);
         $namePath = "members";
         $path = $namePath . "/" . $name_picture;




         Storage::put("public/" . $path, $picture);

         $member->files()->create(['link' => $path, 'type' => 'image']);
         // dd($member->files);
         // dd(Storage::exists($content->images));
      }



      return $member;
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Member $member)
   {

      if (count($member->files) > 0) {
         $id = $member->files->first()->id;


         $img = File::find($id);

         if (Storage::exists("public/" . $img->link)) {
            Storage::delete("public/" . $img->link);
            $img->delete();
         }
      }


      $member->delete();
      return response()->json(['message', 'deleted success']);
   }
}
