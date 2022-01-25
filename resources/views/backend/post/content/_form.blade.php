@extends('backend.crud.modal')
@section('input-form')
<div class="form-group">
   <div class="form-line">
      <label for="name">Nama Produk</label>
      <input type="text" name="name" class="form-control" minlength="5" required>
   </div>
</div>

{{-- <div class="form-group">
    <div class="form-line">
        <label for="number">Gambar Produk</label>
        <input type="text" name="name" class="form-control">
    </div>
</div> --}}

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
