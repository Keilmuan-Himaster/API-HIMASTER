@extends('layouts.backend')

@section('title','Dashboard')

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
         <table id="datatable" class="table table-bordered  m-t-30">
            <thead>
               <tr>
                  <th width="10%">No</th>
                  <th>Name</th>
                  <th width="30%">Action</th>
               </tr>
            </thead>
            <tbody>

            </tbody>
         </table>
      </div>
   </div>
   @include('backend.post.tag._form')
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

@endpush

@push('script')

@include('backend.crud.js')
<script>
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
            data: 'action',
            name: '#',
            orderable: false
         },
      ]
   });

</script>

<script>
   function createItem() {
      setForm('create', 'POST', 'Create Tag', true)

   }

   function editItem(id) {
      setForm('update', 'PUT', 'Edit Tag', true)
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
   /** set data untuk edit**/
   function setData(result) {

      $('input[name=id]').val(result.id);
      $('input[name=name]').val(result.name);
      // $('input[name=stock]').val(result.stock);
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
