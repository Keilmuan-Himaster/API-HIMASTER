<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Structure;
use Illuminate\Http\Request;

class AboutController extends Controller
{
   public function about($category)
   {
      if ($category != "visi" & $category != "misi" & $category != "sejarah")
         return response()->json(
            "Not Found",
            404
         );
      $about = Category::where('slug', $category)->firstOrFail()->contents->firstOrFail();
      return response()->json(
         [
            "data" => $about,
            "status" => 201
         ]
      );
   }
   public function vision(){
      return response()->json(
         [
            "data" => ['title'=>'VISI',
                        'description'=>'Menjadikan Himaster sebagai rumah yang berasaskan kekeluargaan untuk membentuk kader yang aspiratif dan inovatif dengan mengembangkan potensi keilmuan sesuai Tri Dharma Perguruan Tinggi yaitu pendidikan dan pengajaran, penelitian, dan pengembangan, serta pengabdian kepada masyarakat.',
                     ],
            "status" => 201
         ]
      );
   }
   public function mission(){
      return response()->json(
         [
            "data" => ['title'=>'MISI',
                        'description'=>'1. Mewadahi aspirasi mahasiswa Rekayasa Sistem Komputer FMIPA Untan.
                        2. Mengadakan kegiatan-kegiatan yang menunjang keilmuan.
                        3. Melaksanakan kaderisasi agar terbentuknya generasi penerus.
                        4. Menjalin hubungan yang baik dengan cara memperluas jaringan dengan civitas akademika dan alumni serta organisasi atau lembaga lain.',],
            "status" => 201
         ]
      );
   }
   public function history(){
      return response()->json(
         [
            "data" => ['title'=>'SEJARAH',
                        'description'=>'Himaster merupakan suatu organisasi kepengurusan Himpunan yang berada di program studi Rekayasa Sistem Komputer yang dimana didalamnya banyak sekali kegiatan-kegiatan serta program kerja selalu berkembang dan membuat Himaster menjadi lebih baik untuk kedepannya.',
                     ],
            "status" => 201
         ]
      );
   }
   public function mengenai(){
      return response()->json(
         [
         "data" => [ 'title' => 'Mengenai',
                     'description'=>'Himaster merupakan suatu organisasi kepengurusan Himpunan yang berada di program studi Rekayasa Sistem Komputer yang dimana didalamnya banyak sekali kegiatan-kegiatan serta program kerja selalu berkembang dan membuat Himaster menjadi lebih baik untuk kedepannya.'
         ],
         "status" => 201
         ]
         );
   }
}
