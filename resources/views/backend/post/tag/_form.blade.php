@extends('backend.crud.modal')
@section('input-form')
<div class="form-group">
   <div class="form-line">
      <label for="name">Nama Tag</label>
      <input type="text" name="name" class="form-control" minlength="5" required>
   </div>
</div>
@endsection
