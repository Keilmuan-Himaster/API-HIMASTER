@extends('layouts.backend')

@section('title','Create Article')

@push('css')
{{-- <link rel="stylesheet" type="text/css" href="styles.css">  --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />  --}}
{{-- <link href="{{asset('txteditor/css/froala_editor.pkgd.min.css')  }}" rel="stylesheet" type="text/css" /> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush

@push('style')

@endpush

@section('content')
<div class="row">
   <div class="col-12">


      <form id="form" role="form" method="POST" action="{{ route('backend.post.content.store')  }}">
         {{-- <form id="form" action="" method="POST">  --}}

         @method('POST')
         @csrf
         <div class="row">
            <div class="col-md-9">
               <div class="card-box">
                  <div class="form-group">
                     <div class="row">

                        <div class="col-9">


                           <div id="onstatus"><label>Title</label>&nbsp;&nbsp; @if ( $content->status == true) {!! "<h6 id='head' class='btn btn-success btn-trans btn-sm text-warning'>Published</h6>"!!}@else{!! "<h6 id='head' class='btn btn-warning btn-trans btn-sm text-warning'>Saved On Draft</h6>"!!} @endif</div>


                           <input type="text" class="form-control" name='title' placeholder="Enter Title" value="{{ $content->title  }}" required>

                        </div>
                        <div class="col-3" id="button">

                           <button id="getBody" type="submit" class="btn btn-success btn-trans btn-lg fa fa-paper-plane m-t-30"></button>
                           <a id="draft" class="btn btn-warning btn-trans btn-lg fa fa-file m-t-30"></a>
                           <a onclick=deleteConfirm() class='btn btn-danger btn-trans btn-lg fa fa-trash m-t-30'></a>

                        </div>
                     </div>

                  </div>
                  <div id="toolbar-container"></div>
                  <!-- This container will become the editable. -->
                  <div id="editor" style="height: 300px; background-color: rgb(235, 235, 235);">
                     {!! $content->body !!}

                     {{-- <textarea name="" id="" cols="30" rows="10"></textarea>  --}}
                  </div>
                  <input id="content" type="hidden" name="body" value="{{ $content->body  }}">
                  <input id="status" type="hidden" name="status" value="{{ $content->status  }}">
                  <input id="id" type="hidden" name="id" value="{{ $content->id  }}">

               </div>
            </div>

            <div class="col-md-3">
               <div class="card-box">
                  <div class="form-group">
                     <label>Category</label>
                     <select name="category_id" id="category" data-live-search="true" class="form-control types selectpicker " required>

                        <option value="" hidden>-- Select Category --</option>

                        @foreach($categories as $item)

                        <option value="{{ $item->id  }}" @if ($item->id == $content->category_id ) selected
                           @endif>{{ $item->name  }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Tag</label>
                     <select name="tag[]" id="select" data-live-search="true" class="form-control types selectpicker " multiple>

                        <option value="" hidden>-- Select Tag --</option>

                        @foreach($tags as $item)
                        <option value="{{ $item->id  }}" @foreach ($content->tags as $tag)
                           @if ($item->id == $tag->id ) selected
                           @endif
                           @endforeach

                           >{{ $item->name  }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="card-box">
                  <div class="form-group">
                     <label>Add Image</label>
                     <p class="col-12  text txt-success" style="font-size: 10px !important;">

                        *The first image will be the cover
                     </p>

                     <div class="row" id="btnAddImage">
                        <a class="btn btn-primary col-12 fa fa-plus"></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>




      </form>
      <div class="modal fade" id="modalItemImages" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">

                  <h4 class="modal-title">Image Management</h4>

               </div>
               <div class="modal-body">
                  <form id="formItemImage">
                     <table class="table table-bordered table-item-image">
                        <th>#</th>
                        <th>Image</th>
                        <th>Change Image</th>
                        <th>Action</th>

                        <tbody class="tbody">

                        </tbody>
                     </table>
                     <button type="submit" class="btn btn-primary btn-block saveChange">Save Change</button>
                  </form>

                  <hr />



                  <div class="progress-bar">
                     <span class="progress-bar-fill" style="width: 0%;"></span>
                  </div>


                  <h5>Add Image</h5>
                  <form id="formAddItemImages">
                     <div class="parentEl">
                        <div class="row cpEl" style="margin-top:5px">

                           <div class="col-md-12">
                              <input id="imgAdd" type="file" name="image" class="form-control form-control-sm">
                           </div>
                        </div>
                     </div>
                     <div class="childEl"></div>
                     <div class="row" style="margin-top:5px">
                        <div class="col-md-12">
                           <button type="submit" class="btn btn-block btn-sm btn-primary saveImage">Add Image</button>
                        </div>
                     </div>
                  </form>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>

   </div>
</div>
@endsection

@push('js')
{{-- <link href="{{asset('texteditor/css/froala_editor.pkgd.min.css')  }}" rel="stylesheet" type="text/css" /> --}}
{{-- <script src="{{ asset('txteditor/build/ckeditor.js')  }}"></script> --}}
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/decoupled-document/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

@endpush

@push('script')
{{-- @include('backend.crud.js')  --}}
<script>
   let editor;
   var id = {{
         $content->id
      }};
   DecoupledEditor
      .create(document.querySelector('#editor'), {
         toolbar: {
            items: [
               'heading',
               '|',
               'fontSize',
               'fontFamily',
               '|',
               'bold',
               'italic',
               'underline',
               'strikethrough',
               'highlight',
               '|',
               'alignment',
               '|',
               'numberedList',
               'bulletedList',
               '|',
               'indent',
               'outdent',
               '|',
               'todoList',
               'link',
               'blockQuote',
               'insertTable',
               '|',
               'undo',
               'redo'
            ]
         },
         language: 'id',
         image: {
            toolbar: [
               'imageTextAlternative',
               'imageStyle:full',
               'imageStyle:side'
            ]
         },
         table: {
            contentToolbar: [
               'tableColumn',
               'tableRow',
               'mergeTableCells'
            ]
         },
      })
      .then(newEditor => {
         editor = newEditor
         const toolbarContainer = document.querySelector('#toolbar-container');

         toolbarContainer.appendChild(editor.ui.view.toolbar.element);

      })

      .catch(error => {
         console.error(error);
      });
   $('#getBody').on('click', function () {

      Swal.fire('Please wait')
      Swal.showLoading()
      $('#id').val(id);
      $('input[name=_method]').val("POST");
      $('#content').val(editor.getData());
      $('#status').val(1);
      // console.log($('#content').val());
      // console.log('masuk');
   })




   function readURL(input) {

      if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
   }

   $("#imgInp").change(function () {
      $('#img').append('<img id="blah" style="width: 100%" src="#" alt="your image" />');
      readURL(this);
   });

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


   function setForm(saved, method) {
      save_method = saved;
      $('input[name=_method]').val(method);
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

   $('#draft').on('click', function (e) {
      Swal.fire('Please wait')
      Swal.showLoading()

      $('#content').val(editor.getData());
      $('#status').val(0);
      // console.log(id)
      if ($('input[name=title]').val() == '') {
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Title Not Null!',
         })
         return false;
      }
      if ($('#category').val() == '') {
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Category Not Null!',
         })
         return false;
      }
      if (id == '') {

         // editData(id)
         setForm('update', 'PATCH')
         saveAjax("/admin/post/content/0");
      } else {
         // console.log('masuk');
         setForm('update', 'PATCH')
         $('#id').val(id)
         saveAjax("/admin/post/content/" + id);
      }


   });


   function saveAjax(url) {
      Swal.fire('Please wait')
      Swal.showLoading()

      $.ajax({
         url: url,
         type: "post",
         cache: false,
         dataType: 'json',
         data: new FormData($('#form')[0]),
         contentType: false,
         processData: false,
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function (result) {
            // console.log(result[0].id)
            $('#head').remove()
            $("#onstatus").append("<h6 id='head' class='btn btn-warning btn-trans btn-sm text-warning'>Saved On Draft</h6>")


            id = result[0].id;
            Toast.fire({
               icon: 'success',
               title: 'Saved On Draft'
            })

         },
         error: function (result) {
            if (result.responseJSON) {
               getError(result.responseJSON.errors);
            } else {
               // console.log(d)
               console.log(result);
            }
         },
      })
      console.log(id)
   }

   function deleteData() {
      Swal.fire('Please wait')
      Swal.showLoading()

      var url = '/admin/post/content/' + id;

      $.ajax({
         url: url,
         type: "DELETE",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function (result) {
            window.location = "{{ route('backend.post.content.index')  }}";
            // toastr.success('Berhasil Dihapus', 'Success');
         },
         error: function (errors) {
            getError(errors.responseJSON.errors);
         }
      });
   }

   function deleteConfirm() {

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
            deleteData();
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

</script>
@include('backend.post.content._image')
@endpush
