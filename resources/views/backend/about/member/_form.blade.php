@extends('backend.crud.modal')
@section('input-form')
<div class="form-group">
   <div class="form-line">
      <label for="name">Nama</label>
      <input type="text" name="name" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="name">NIM</label>
      <input type="text" name="nim" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="name">Prodi</label>
      <input type="text" name="majors" class="form-control" required>
   </div>
</div>
<div class="form-group">
   <label>Bidang</label>
   <select name="structure_id" id="structure" data-live-search="true" class="form-control struc selectpicker " required>

      <option value="" hidden>-- Pilih Bidang --</option>

      @foreach($structure as $item)
         <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->year }}</option>
      @endforeach
   </select>
</div>
<div class="form-group">
   <label>Jabatan</label>
   <select name="grade" id="grade" class="form-control grade selectpicker" required>

      <option value="" hidden>-- Select Status --</option>
      <option value="Koordinator">Koordinator</option>
      <option value="Staf">Staf</option>

      {{-- @foreach($categories as $item)
      <option value="{{ $item->id }}">{{ $item->name }}</option>
      @endforeach--}}
   </select>
</div>

<div class="form-group">
   <div class="form-line">
      <label for="number">Angkatan</label>
      <input type="number" name="year" class="form-control">
   </div>
</div>

<div class="form-group">
   <div class="form-line">
      <label for="number">Alamat</label>
      <textarea id="address" name="address" class="form-control"></textarea>
   </div>
</div>
<div class="form-group">
   <div class="form-line">
      <label for="number">Foto</label>
      <input type="file" name="image" class="form-control">
   </div>
</div>

{{-- <div class="form-group">
   <label for="type">Pilih Salah Satu</label>
   <select class="form-control show-tick" name="type_id" id="typeID" required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
@foreach($type as $item)
      <option value="{!! $item->id !!}">{!! $item->name !!}</option>
@endforeach
   </select>
</div> --}}

@endsection
