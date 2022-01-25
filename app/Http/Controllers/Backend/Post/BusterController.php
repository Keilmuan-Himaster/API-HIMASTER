<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Models\Buster;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class BusterController extends Controller
{
    public function index(Request $request){
      if($request->ajax()){
         $buster = Buster::latest()->get();
         return DataTables::of($buster)
         ->addColumn('action', function ($content) {
            return '

                          <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $content->id . ')"><i class="fa fa-trash"></i></span></a>
                          <a class="btn btn-info btn-sm" onclick="editItem(' . $content->id . ')"><i class="fa fa-pencil"></i></span></a>
                          ';
         })
         ->removeColumn('id')
         ->addIndexColumn()
         ->rawColumns(['action'])
         ->make(true);
       }
      $data['title'] = "BUSTER";
       return view('backend.post.buster.index', $data);
    }

    public function store(Request $request){
      $tujuan = "storage/buster/";
      $nama_foto = time().'_'.pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME).'.webp';
      Image::make($request->image)->resize(500, null, function ($constraint) {
         $constraint->aspectRatio();
         })->encode('webp', 80)->save($tujuan.$nama_foto);
        $buster = new Buster();
        $buster->title = $request->title;
        $buster->link = $request->link;
        $buster->image = $tujuan.$nama_foto;
        // dd($buster->slug);
        $buster->save();
        return $buster;
    }

    public function edit(Buster $buster)
    {
        return $buster;
    }

    public function update(Request $request, Buster $buster)
    {
      $tujuan = "storage/buster/";
      $nama_foto = time().'_'.pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME).'.webp';
      Image::make($request->image)->resize(500, null, function ($constraint) {
         $constraint->aspectRatio();
         })->encode('webp', 80)->save($tujuan.$nama_foto);
        $buster->update($request->all());
        $buster->image = $tujuan.$nama_foto;
        $buster->save();
        return $buster;
    }

    public function destroy(Buster $buster)
    {
        $buster->delete();
        return response()->json(['message', 'deleted success']);

    }
}
