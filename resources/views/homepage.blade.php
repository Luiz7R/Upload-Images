<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Images Handler</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>    
</head>

<body style="background-color: #056349;">

    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-princ">
                <h3 class="text-center text-title">Upload Images with Laravel</h3>
            </div>
            <div class="col-md-9 col-12 col-upl">
                <div class="mb-3">
                     <div class="col-8 col-md-8 cf-up">
                        <div class="frm-img"> 
                            <form action="{{ route('upImage') }}" method="POST" class="form-horizontal" id="upload-image" enctype="multipart/form-data" >
                                @csrf
                                @method('POST') 
                                <label for="formFile" class="form-label fi-lb text-center"><h5>Choose a File</h5></label>
                                <input class="form-control" type="file" name="images[]" multiple id="image">
                                <button type="submit" class="btn btn-success up-btn">Send Image</button>                            
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif 
                        </div>                        
                     </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                {{-- <img src="" class="rounded me-2" alt="..."> --}}
                <strong class="me-auto">System </strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-white">
                Image Deleted Sucessfully.
            </div>
        </div>
    </div>

    <div id="carouselExampleControls" class="carousel slide col-md-8" data-bs-ride="carousel">
        <div class="modal" id="modalDelImg"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header" style="background-color: #06916b;">
                            <h5 class="modal-title text-white" id="titleModalDeleteImg">Delete Image</h5> 
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>       
                        </div>  
                        <div class="modal-body" style="">
                            Are you sure you want to delete the image?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="btnImageDelete">Delete</button>
                        </div>                           
                    </div>    
              </div>  
        </div>

        <div class="carousel-inner">     
            @foreach ( $images as $i => $image )
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }} " data-bs-interval="2000">                
                    <button class="btn btn-sm btn-danger delBtn" data-bs-toggle="modal" data-bs-target="#modalDelImg" data-img="{{ $image['id'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>               
                    </button>                    
                    <img src="{{ asset('storage/images/' . $image['image'] ) }}" width="680" height="551" class="d-block w-100" alt="">
                </div> 
            @endforeach
        </div> 
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</body>
</html>


<script>


  $(document).on('click', '.delBtn', function() {

        var idImg = $(this).data("img")

        $('#btnImageDelete').unbind().click(function() {
             $.ajax({
                 type: 'ajax',
                 method: 'post',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 async: false,
                 url: "{{ url('deleteImage') }}/" + idImg,
                 dataType: 'json',
                 success: function()
                 {
                     $('#modalDelImg').modal('hide');
                     $('.toast').toast('show');
                     location.reload();
                 },
                 error: function()
                 {
                     console.error("Request has failed, contact the support team");
                 }
             })  
        });


  });  
    //  var idImg = $(this).data("img")

    //  var toastImg = document.getElementById("toastImg0");

    //  var toast = new bootstrap.Toast(toastLiveExample)

    //  console.log(toast)

</script>

<style>
    .d 
    {
        width: 5%;
    }

    .delBtn
    {
        position: absolute;
        top: 5px;
        right: 50px;
    }

    .carousel
    {
        margin-left: 15%;
        margin-top: 2%;
        margin-bottom: 2%;
        position: relative;
    }

   .col-princ 
   {
       border-radius: 7px;
       margin-top: 10px;
       min-height: 70px; 
   } 
   .text-title 
   {
       margin-top: 15px;
       color: white;
   }

   .col-upl 
   {
       border-radius: 7px;
       margin-left: 9%;
       margin-top: 10px;
       background-color: #668191;
       min-height: 175px;
   }

   .cf-up
   {
        padding-left: 120px;
        margin-left: 9%;
   }

   .fi-lb 
   {
       margin-top: 14px;
       color: white; 
       font-size: 22px;
   }

   .up-btn 
   {
       border-radius: 7px;
       margin-top: 7px; 
   }

   .frm-img
   {
       margin-left: 10%;
   }
</style>

