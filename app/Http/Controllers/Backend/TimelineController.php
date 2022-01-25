<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {
         $timelines = Timeline::latest()->get();
         return DataTables::of($timelines)
         ->addColumn('kementrian', function($timeline){
            return $timeline->structure->name;
         })

             ->addColumn('action', function ($timeline) {
                 return '
                          <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $timeline->id . ')"><i class="fa fa-trash"></i></span></a>
                          <a class="btn btn-info btn-sm" onclick="editItem(' . $timeline->id . ')"><i class="fa fa-pencil"></i></span></a>
                          ';
             })
             ->removeColumn('id')
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->make(true);
     }
     $data['title'] = "TIMELINE";
     $date = Carbon::now()->year;
     $data['structure'] = Structure::where('year','>=',$date-1)->get()->sortByDesc('year');

   //   dd($data['structure']);
     return view('backend.timeline.index', $data);
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
        $time = new Timeline();
        $time->name = $request->name;
        $time->description = $request->description;
        $time->date = $request->date;
        $time->structure_id = $request->structure_id;
        $time->save();
        return $time;
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
    public function edit(Timeline $timeline)
    {
        return $timeline;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Timeline $timeline)
    {
      $timeline->update($request->all());
      return $timeline;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
      $timeline->delete();
      return response()->json(['message', 'deleted success']);
    }
}
