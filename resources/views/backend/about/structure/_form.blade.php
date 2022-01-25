@extends('backend.crud.modal')
@section('input-form')
<div class="form-group">
   <div class="form-line">
      <label for="name">Name</label>
      <input type="text" name="name" class="form-control" required>
   </div>
</div>

<div class="form-group">
    <div class="form-line">
        <label for="number">Year</label>
        <input type="number" name="year" class="form-control">
    </div>
</div>
<div class="form-group">
   <div class="form-line">
       <label for="number">Logo</label>
       <input type="file" name="image" class="form-control" >
   </div>
</div>
<div class="form-group">
   <div class="form-line">
       <label for="number">Description</label>
       <textarea id="des" name="description" class="form-control"></textarea>
   </div>
</div>

{{-- <div class="form-group">
   <label for="type">Pilih Salah Satu</label>
   <select class="form-control show-tick" name="type_id" id="typeID" required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($type as $item)
      <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
   </select>
</div> --}}

@endsection
