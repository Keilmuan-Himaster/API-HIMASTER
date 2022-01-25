@extends('backend.crud.modal')
@section('input-form')
    <div class="form-group">
        <div class="form-line">
            <label for="number">Judul</label>
            <input type="text" name="title" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="number">Deskripsi</label>
            <input type="text" name="description" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="number">Image</label>
            <input type="file" name="file" class="form-control" required>
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
