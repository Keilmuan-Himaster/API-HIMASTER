@extends('backend.crud.modal')
@section('input-form')
    <div class="form-group">
        <div class="form-line">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="no_hp">No Hp</label>
            <input type="number" name="no_hp" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="lokasi">Lokasi</label>
            <input type="link" name="lokasi" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="instagram">instagram</label>
            <input type="link" name="instagram" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="facebook">facebook</label>
            <input type="link" name="facebook" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <div class="form-line">
            <label for="facebook">youtube</label>
            <input type="link" name="youtube" class="form-control" required>
        </div>
    </div>
@endsection
