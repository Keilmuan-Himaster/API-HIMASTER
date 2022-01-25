@extends('layouts.backend')

@section('title','Anggota')

@push('css')
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')  }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css')  }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css')  }}" rel="stylesheet" type="text/css" />
<!-- Multi Item Selection examples -->
<link href="{{ asset('assets/plugins/datatables/select.bootstrap4.min.css')  }}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="{{ asset('assets/css/bootstrap.min.css')  }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/icons.css')  }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/style.css')  }}" rel="stylesheet" type="text/css" />


<script src="{{ asset('assets/js/modernizr.min.js')  }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush

@push('style')
<style>
.mtop-100{
   margin-top:150px !important;
}
</style>
@endpush

@section('content')
<div class="row">

   <div class="col-12">

      <div class="card-box table-responsive">
         <div class="row ml-1">
            <div class="col-2">
               <label for="">Tahun Kepengurusan : </label>
            </div>
            <div class="col-10">
               <div class="form-group">

                  <select id="year" class="form-control show-tick year">

                     @foreach($year as $item)
                        <option value="{{ $item->year }}">
                           {{ $item->year }}</option>
                     @endforeach
                     <option hidden>--Choose Month---</option>


                  </select>
               </div>

            </div>
         </div>
         <table id="datatable" class="table table-bordered  m-t-30">
            <thead>
               <tr>
                  <th width="10%">No</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Prodi</th>
                  <th>Angkatan</th>
                  <th>Bidang</th>
                  <th>Jabatan</th>

                  <th width="30%">Alamat</th>
                  <th width="10%">Foto</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>

            </tbody>
         </table>
      </div>
   </div>
   @include('backend.about.member._form')
</div>
@endsection

@push('js')

<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')  }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')  }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js')  }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert/sweetalert2.min.js')  }}"></script>
<script src="{{ asset('assets/pages/jquery.sweet-alert.init.js')  }}"></script>
{{-- sweat allert  --}}

<!-- Responsive examples -->
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js')  }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js')  }}"></script>

<!-- Selection table -->
<script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js')  }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


@endpush

@push('script')

@include('backend.crud.js')
<script>
   function clearSession(){
                sessionStorage.removeItem('year');

            }
   clearSession()
   let dataTable = $('#datatable').DataTable({
      dom: 'lBfrtip',
      buttons: [{
         className: 'btn btn-success btn-sm mr-2',
         text: 'Create',
         action: function (e, dt, node, config) {
            createItem();
         }
      }, {
         className: 'btn btn-warning btn-sm mr-2',
         text: 'Reload',
         action: function (e, dt, node, config) {
            reloadDatatable();
            Toast.fire({
               icon: 'success',
               title: 'Reload'
            })
         }
      }],

      responsive: true,
      processing: true,
      serverSide: true,
      searching: true,
      pageLength: 5,
      lengthMenu: [
         [5, 10, 15, -1],
         [5, 10, 15, "All"]
      ],
      ajax: {
         url: child_url,
         type: 'GET',
         data: function (d) {

                        d.year = sessionStorage.year;
                    },
                    "_token": "{{ csrf_token() }}",
      },
      columns: [{
            data: 'DT_RowIndex',
            orderable: false
         },
         {
            data: 'name',
            orderable: true
         },
         {
            data: 'nim',
            orderable: true
         },
         {
            data: 'majors',
            orderable: true
         },
         {
            data: 'year',
            orderable: true
         },

         {
            data: 'struc',
            orderable: true
         },
         {
            data: 'grade',
            orderable: true
         },
         {
            data: 'address',
            orderable: true
         },
         {
            data: 'image',
            orderable: true
         },
         {
            data: 'action',
            name: '#',
            orderable: false
         },
      ]
   });



</script>

<script>


            $('#year').on('change', function (e) {
                console.log(this.value);
                sessionStorage.setItem('year', this.value);
                dataTable.draw();
                e.preventDefault();
            });
   function createItem() {
      setForm('create', 'POST', 'Tambah Anggota', true)

   }

   function editItem(id) {
      setForm('update', 'PUT', 'Ubah Anggota', true)
      editData(id)
      // Toast.fire({
      //          icon: 'success',
      //          title: 'Create successfully'
      // })
   }

   function deleteItem(id) {
      deleteConfirm(id)

   }

</script>

<script>

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

   /** set data untuk edit**/
   function setData(result) {

      $('input[name=id]').val(result.id);
      $('input[name=name]').val(result.name);
      $('#address').val(result.address);
      $('input[name=year]').val(result.year);
      $('input[name=majors]').val(result.majors);
      $('input[name=nim]').val(result.nim);
      $("#structure option").filter(function () {

         return $.trim($(this).val()) == result.structure_id
      }).prop('selected', true);
      $('.struc').selectpicker('refresh')
      $("#grade option").filter(function () {

         return $.trim($(this).val()) == capitalize(result.grade)
      }).prop('selected', true);
      $('.grade').selectpicker('refresh');



      // $('input[name=cost]').val(result.cost);

      // $("#typeID option").filter(function () {
      //    return $.trim($(this).val()) == result.type_id
      // }).prop('selected', true);
      // $('#typeID').selectpicker('refresh');

   }


   /** reload dataTable Setelah mengubah data**/
   function reloadDatatable() {
      dataTable.ajax.reload();
   }



</script>

@endpush
