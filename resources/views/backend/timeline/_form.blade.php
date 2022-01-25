@extends('backend.crud.modal')
@section('input-form')

{{-- <div class="form-group">
   <div class="form-line">
       <label for="number">Image</label>
       <input type="file" name="file" class="form-control" required>
   </div>
</div> --}}


<div class="form-group">
   <div class="form-line">
      <label for="number">Name</label>
      <input type="text" name="name" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="number">Date</label>
      <div class="input-group">
         <input name="date" type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" autocomplete="off">
         <div class="input-group-append">
            <span class="input-group-text"><i class="ti-calendar"></i></span>
         </div>
      </div>
   </div>

</div>
<div class="form-group">
   <div class="form-line">
      <label for="number">Description</label>
      <textarea id="des" name="description" class="form-control"></textarea>
   </div>
</div>


<div class="form-group">
   <label for="type">Divisi</label>
   <select class="form-control show-tick" name="structure_id" id="structureID" required>
      <option disabled selected value>----Choose----</option>
      @foreach ($structure as $item)
      <option value="{!! $item->id !!}">{!! $item->name." - ".$item->year!!}</option>
      @endforeach
   </select>
</div>

@endsection
