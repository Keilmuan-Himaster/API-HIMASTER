@extends('layouts.backend')
@section('content')
<style>
   .h{
      background-color:#c8ffc1;
   }
</style>
<div class="row">
   
   <div class="col-xl-3 col-md-6">
      <div class="card-box">
            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>

            </div>

         <h4 class="header-title mt-0 m-b-30">Total Content</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2">

                     <div class="badge badge-success badge-pill pull-left m-t-20">{{ $publish->count()  }} Publish </div>



                    <h2 class="mb-0"> {{ $contents->count() }} </h2>
                    <p class="text-muted m-b-25">Content</p>
                </div>
                <div class="progress progress-bar-success-alt progress-sm mb-0">
                    <div class="progress-bar progress-bar-success" role="progressbar"
                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                         style="width: 100%;">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>
@endsection
