@extends('backend.crud.modal')
@section('input-form')
<div class="form-group">
   <div class="form-line">
      <label for="title">Judul</label>
      <input type="text" name="title" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="structure_id">Divisi</label>
      <select name="structure_id" id="structure" data-live-search="true" class="form-control types selectpicker " required>
         <option value="" hidden>-- Select Category --</option>
         @foreach($structure as $item)
         <option value="{{ $item->id  }}">{{ $item->name  }}</option>
         @endforeach
      </select>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="image">Gambar</label>
      <input type="file" multiple name="image" class="form-control" required>
   </div>
</div>
@endsection
