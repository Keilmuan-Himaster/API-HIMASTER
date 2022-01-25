<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\File;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Img;
use Str;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {

      if ($request->ajax()) {
         $contents = Content::latest()->get();
         return DataTables::of($contents)
            ->addColumn('category', function ($item) {
               return $item->category->name;
            })
            ->addColumn('tag', function ($item) {
               $name = "";
               $tag = $item->tags->map(function ($data) {
                  return $data->name;
               });
               if (count($tag) > 0) {
                  for ($i = 0; $i < count($tag); $i++) {
                     $name = $name . $tag[$i] . ", ";
                  }
               } else {
                  $name = "-";
               }

               return $name;
            })
            ->addColumn('action', function ($content) {
               return '

                             <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $content->id . ')"><i class="fa fa-trash"></i></span></a>
                             <a class="btn btn-info btn-sm" onclick="editItem(' . $content->id . ')"><i class="fa fa-pencil"></i></span></a>
                             ';
            })
            ->addColumn('status', function ($content) {
               if ($content->status == true) {
                  return '
                           <p class="btn btn-success btn-trans btn-sm" >Published</span></a>
                        ';
               } else {
                  return '
                     <p class="btn btn-warning btn-trans btn-sm" >Draft</span></a>
                        ';
               }
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
      }
      $data['title'] = "CONTENT";

      return view('backend.post.content.index', $data);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $data['title'] = "CONTENT > CREATE";
      $data['tags'] = Tag::all();
      $data['categories'] = Category::all();
      return view('backend.post.content.create', $data);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //   dd($request->all());
      $path = null;
      if ($request->id != 0) {
         $content = Content::find($request->id);
         $content->tags()->detach();
         $content->update($request->except('image', 'tag'));
         $content->tags()->attach($request->tag);
         $content->slug = Str::of($request->title)->slug('-');
         $content->created_at = Carbon::now();
         $content->save();
         return redirect(route('backend.post.content.index'))->with([
            'type' => 'success',
            'toast' => 'Content successfully Published',
         ]);
      }
      DB::transaction(function () use ($request) {

         $slug = Str::slug($request->title, '-');

         $request->request->add([
            'slug' => $slug,
         ]);
         $item = Content::create($request->except('image', 'tag'));
         $item->tags()->attach($request->tag);
      });

      return redirect(route('backend.post.content.index'))->with([
         'type' => 'success',
         'toast' => 'Content successfully Created',
      ]);
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
   public function edit(Content $content)
   {
      //   dd("masuk")
      $data['title'] = "CONTENT > EDIT";
      $data['content'] = $content;
      $data['categories'] = Category::all();
      $data['tags'] = Tag::all();
      return view('backend.post.content.edit', $data);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      $path = null;

      if ($id == 0) {
         $slug = Str::slug($request->title, '-') . time();

         $request->request->add([
            'slug' => $slug,
         ]);

         $item = Content::create($request->except('image', 'tag'));
         $item->tags()->attach($request->tag);
      } else {
         $content = Content::find($id);
         $content->tags()->detach();
         $content->update($request->except('image', 'tag'));
         $content->slug = Str::of($request->title)->slug('-');
         $content->tags()->attach($request->tag);
         $content->save();
         $item = $content;
      }

      //   dd($request->title);
      return response()->json([
         $item,
      ]);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Content $content)
   {
      $content->tags()->detach();
      foreach ($content->files as $key => $image) {
         // dd($image->link);
         if (Storage::exists("public/" . $image->link)) {
            Storage::delete("public/" . $image->link);
            $image->delete();
         }
      }

      $content->delete();

      return response()->json(['message', 'deleted success']);
   }
   public function getImage($id)
   {
      $file = File::where('fileable_id', $id)->where('fileable_type', 'App\Models\Content')->get();
      return response()->json($file, 200);
   }

   public function editImage(Request $request)
   {
      $content = Content::find($request->content);
      //   dd($content->images);
      $path = null;
      if ($request->file('image')) {
         foreach ($request->file('image') as $key => $image) {
            $img = $content->files[$key];
            //  dd($img);

            $name_picture = Str::random(6) . '.png';
            $picture = Img::make($image)->resize(null, 1000, function ($constraint) {
               $constraint->aspectRatio();
               $constraint->upsize();
            })->encode('png', 100);
            if (Storage::exists("public/" . $img->link)) {
               Storage::delete("public/" . $img->link);
               $img->delete();
            }
            $namePath = strtolower(Category::find($content->category_id)->name);
            $path = $namePath . "/" . $name_picture;

            Storage::put("public/" . $path, $picture);
            // dd(Storage::exists($content->images));

            if ($path != null) {
               $content->files()->create(['link' => $path, 'type' => 'image']);
            }
            //  dd($content->images);
         }
      } else {
         $data['message'] = "No Image Changed";
         return response()->json($data);
      }

      $data['message'] = "Image Has Been Changed";
      //   $data['part_id'] = $gambar_part->part_id;
      return response()->json($data, 200);
   }

   public function addImage(Request $request)
   {

      $content = Content::find($request->content);
      //   dd($request->content);
      $path = null;

      if ($request->file('image')) {
         $name_picture = Str::random(6) . '.png';
         $picture = Img::make($request['image'])->resize(null, 1000, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
         })->encode('png', 100);
         $namePath = strtolower(Category::find($content->category_id)->name);
         $path = $namePath . "/" . $name_picture;

         Storage::put("public/" . $path, $picture);
         // dd(Storage::exists($content->images));
      }
      if ($path != null) {
         $content->files()->create(['link' => $path, 'type' => 'image']);
      }
      //   dd($content->files);

      return response()->json(200);
   }

   public function deleteImage($id)
   {
      if ($id != "") {
         $img = File::find($id);
         if ($img->link != null) {
            if (Storage::exists("public/" . $img->link)) {
               Storage::delete("public/" . $img->link);
               $img->delete();
            }
         }
         return response()->json('success', 200);
      }
      return "gagal";
   }
}
