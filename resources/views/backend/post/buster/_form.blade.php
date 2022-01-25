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
      <label for="link">Link</label>
      <input type="text" multiple name="link" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="image">Gambar</label>
      <input type="file" multiple name="image" class="form-control" required>
   </div>
</div>

@endsection
