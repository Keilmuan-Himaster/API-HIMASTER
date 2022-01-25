<script>
   $("body").on("submit", "#formItemImage", function (event) {
      event.preventDefault()
      Swal.fire({
         type: 'warning',
    text: 'Please wait.',
    showCancelButton: false,
    confirmButtonText: "ok",
    allowOutsideClick: false,
    allowEscapeKey: false
      })
      Swal.showLoading()

      let content = id;
      if (typeof content === "undefined") {
         alert('no image for changed');
         location.reload();
      }
      let dataKu = new FormData(this)
      dataKu.append('content', id)

      $.ajax({
         type: "POST",
         enctype: "multipart/form-data",
         url: "{{ route('backend.post.editimage')  }}",
         headers: {
            'X-CSRF-TOKEN': "{{ csrf_token()  }}"
         },
         data: dataKu,
         processData: false,
         contentType: false,
         cache: false,
         xhr: function () {
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function (e) {
               // For uploads

            };
            return xhr;
         },

         success: function (response) {
            // console.log(response)

            // $(".childEl").empty()

            Swal.fire({
               position: 'top-end',
               icon: 'success',
               title: response.message,
               showConfirmButton: false,
               timer: 1500
            })
            getImage(window.imageID)
            // setTimeout(function () {
            //    location.reload();
            // }, 2500);
         },
         error: function (xhr, status, error) {
            $(".childEl").empty()
            swallFire('error', JSON.parse(xhr.responseText))
         }
      })
   })

   $("body").on("submit", "#formAddItemImages", function (event) {
      event.preventDefault()
      Swal.fire({
         type: 'warning',
    text: 'Please wait.',
    showCancelButton: false,
    confirmButtonText: "ok",
    allowOutsideClick: false,
    allowEscapeKey: false
      })
      Swal.showLoading()
      // console.log("masuk")
      let dataKu = new FormData(this)
      dataKu.append('content', window.imageID)


      // console.log("data : "+dataKu)

      $.ajax({
         type: "POST",
         enctype: "multipart/form-data",
         url: "{{ route('backend.post.addimage')  }}",
         headers: {
            'X-CSRF-TOKEN': "{{ csrf_token()  }}"
         },
         data: dataKu,
         processData: false,
         contentType: false,
         cache: false,


         success: function (response) {
            $(".childEl").empty()

            $('#imgAdd').val('')

            Swal.fire({
               position: 'top-end',
               icon: 'success',
               title: 'Your Image has been saved',
               showConfirmButton: false,
               timer: 1500
            })
            getImage(window.imageID)
         },
         error: function (xhr, status, error) {
            $(".childEl").empty()
            swallFire('error', JSON.parse(xhr.responseText))
         }
      })
   })

   function getImage(id) {
      $.get("{{ url('/admin/post/content/getimage')  }}" + "/" + id, function (data) {
         // console.log('masuk')
         
         $('.table-item-image .tbody').empty();
         $.each(data, function (i, item) {
            console.log(item.link);
            $('.table-item-image .tbody').append(`
                            <tr>
                                <td>${i+1}</td>
                                <td><img src="/storage/${item.link}" style="max-height:100px"></td>
                                <td>
                                    <span class="input_hidden"></span>
                                    <input id="image" type="file" class="form-control image" name="image[]" data-id="${item.id}"/>
                                </td>
                                <td><button type="button" data-id="${item.id}" class="btn btn-xs btn-danger delItemImage">Hapus</button></td>
                            </tr>
                        `);
         });
      })
   }

   $("#btnAddImage").on("click", function () {
      // console.log('masuuk')
      $("#modalItemImages").modal('show')


      window.imageID = id
      getImage(window.imageID)
   })
   $("body").on("click", ".delItemImage", function (e) {
      e.preventDefault()
      Swal.fire({
         type: 'warning',
    text: 'Please wait.',
    showCancelButton: false,
    confirmButtonText: "ok",
    allowOutsideClick: false,
    allowEscapeKey: false
      })
      Swal.showLoading()
      let img = $(this).data("id")
      // console.log("masuk" + id)

      Swal.fire({
         title: 'Are you sure?',
         text: "You won't be able to revert this!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
         // console.log(result.value)

         if (result.value) {

            $.post("/admin/post/content/deleteimage" + "/" + img, {
                  '_method': "DELETE",
                  "_token": "{{ csrf_token()  }}"
               })
               .done(function (response) {
                  Swal.fire({
                     position: 'top-end',
                     icon: 'success',
                     title: 'Your Image has been deleted',
                     showConfirmButton: false,
                     timer: 1500
                  })
                  getImage(window.imageID);
               })
               .fail(function (error) {
                  swallFire("error", error)
               })
         }
      })
   })

   function swallFire(type, message) {
      Swal.fire({
         position: 'center',
         text: message,
         type: type,
         showConfirmButton: false,
         timer: 1500
      })
   }

</script>
