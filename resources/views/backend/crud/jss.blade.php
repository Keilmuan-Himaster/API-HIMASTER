<script>
   const child_url = "{!! request()->url() !!}";

   function setForm(saved, method, title) {
      save_method = saved;
      $('input[name=_method]').val(method);
      $('#modalForm form')[0].reset();
      $(':input[name=id]').val('');
      $('#modalFormTitle').text(title);
      $('#modalForm').modal('show');
   }

   function editData(id) {
      $.ajax({
         url: child_url + "/" + id + "/edit",
         type: "GET",
         dataType: "json",
         success: function (result) {
            // console.log(result);
            setData(result);
         },
         error: function (result) {
            console.log(result);
         }
      })
   }

   function setUrl() {
      var id = $('#id').val();
      if (save_method == "create") url = child_url;
      else url = child_url + '/' + id;

      return url;
   }

   /** ambil data error**/
   function getError(errors) {
      $.each(errors, function (index, value) {
         value.filter(function (obj) {
            return error = obj;
         });
         toastr.error(error, 'Error', {
            closeButton: true,
            progressBar: true,
         });
      });
   }

   /** save data onsubmit**/
   $(function () {
      $('#modalForm form').on('submit', function (e) {
         if (!e.isDefaultPrevented()) {
            saveAjax(setUrl());
            return false;
         }
      });
   });

   function saveAjax(url) {
      
      $.ajax({
         url: url,
         type: "post",
         cache: false,
         dataType: 'json',
         data: new FormData($('#modalForm form')[0]),
         contentType: false,
         processData: false,
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function (result) {
            $('#modalForm').modal('hide');
            reloadDatatable();

            Toast.fire({
               icon: 'success',
               title: 'successfully'
            })
            // toastr.success('Berhasil Disimpan', 'Success');
         },
         error: function (result) {
            $('#modalForm').modal('hide');

            if (result.responseJSON) {
               getError(result.responseJSON.errors);
            } else {
               console.log(result);
            }
         },
      })
   }

   /** konfirmasi hapus data **/
   function deleteConfirm(id) {

      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
         },
         buttonsStyling: true,
      })

      swalWithBootstrapButtons.fire({
         title: 'Are You Sure ?',
         text: "You will delete this data!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes, Delete!',
         cancelButtonText: 'No, Quit!',
         reverseButtons: true
      }).then((result) => {
         if (result.value) {
            deleteData(id);
            swalWithBootstrapButtons.fire(
               'Deleted!',
               'Data Has Been Deleted',
               'success'
            )
         } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
         ) {
            swalWithBootstrapButtons.fire(
               'Cancel',
               'Process Has Been Canceled',
               'error'
            )
         }
      })
   }

   /** hapus data dari database **/
   function deleteData(id) {
      var url = child_url + '/' + id;
      $.ajax({
         url: url,
         type: "DELETE",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function (result) {
            reloadDatatable();
            Toast.fire({
               icon: 'success',
               title: 'Delete successfully'
            })
            // toastr.success('Berhasil Dihapus', 'Success');
         },
         error: function (errors) {
            getError(errors.responseJSON.errors);
         }
      });
   }

</script>
