<?php

namespace App\Http\Controllers\Backend\Post;

use App\Models\Structure;
use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
class GalleryController extends Controller
{
    public function index(Request $request){
       if($request->ajax()){

         $gallery = Gallery::latest()->get();
         return Datatables::of($gallery)
         ->addColumn('action', function ($content) {
            return '
            <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $content->id . ')"><i class="fa fa-trash"></i></span></a>
            <a class="btn btn-info btn-sm" onclick="editItem(' . $content->id . ')"><i class="fa fa-pencil"></i></span></a>
            ';
         })
         ->addColumn('divisi', function ($content) {
            return $content->structure->name;
         })
         ->removeColumn('id')
         ->addIndexColumn()
         ->rawColumns(['action'])
         ->make(true);
       }
       $data['title'] = 'GALLERY';
       $structure = Structure::all();
       return view('backend.post.gallery.index',$data, compact('structure'));
    }

    public function store(Request $request){
       $tujuan = "storage/gallery/";
      $nama_foto = time().'_'.pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME).'.webp';
      Image::make($request->image)->resize(500, null, function ($constraint) {
         $constraint->aspectRatio();
         })->encode('webp', 80)->save($tujuan.$nama_foto);
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->structure_id = $request->structure_id;
        $gallery->image = $tujuan.$nama_foto;
        // dd($gallery->slug);
        $gallery->save();
        return $gallery;
    }

    public function edit(Gallery $gallery)
    {
        return $gallery;
    }

    public function update(Request $request, Gallery $gallery)
    {
      $tujuan = "storage/members/";
      $nama_foto = time().'_'.pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME).'.webp';
      Image::make($request->image)->resize(500, null, function ($constraint) {
         $constraint->aspectRatio();
         })->encode('webp', 80)->save($tujuan.$nama_foto);
        $gallery->update($request->all());
        $gallery->image = $tujuan.$nama_foto;
        $gallery->save();
        return $gallery;
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json(['message', 'deleted success']);

    }

}
