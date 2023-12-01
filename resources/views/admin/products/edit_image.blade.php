@extends('layouts.admin')

@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('script')
    <script type="module">

        $('#delete_image button').on('click' , {url:"{{route("admin.products.delete_image")}}"} , changeImages)
        $('#set_primary button').on('click' , {url:"{{route("admin.products.set_primary")}}"} , changeImages)
        $('#update_primary #update_image').on('change' , {url:"{{route("admin.products.update_primary")}}"} , changeImages)
        $('#form_add_image #add_image').on('change' , {url:"{{route("admin.products.add_image")}}"} , changeImages)

        function changeImages(e){
            e.preventDefault();
            let formData = new FormData(this.form)
            $.ajax({
                method:"post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:e.data.url,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache:false,
                success:function (response){
                    let addedImages = '';
                    $('#show-images').children().remove();
                    response.images.forEach(function (image){
                        addedImages += (image.is_primary === 1) ? addNewPrimaryImageToPage(image.image , image.id , image.product_id)
                            : addNewImageToPage(image.image , image.id , image.product_id);
                    });
                    $('#show-images').append(addedImages);
                    $('#delete_image button').on('click' , {url:"{{route("admin.products.delete_image")}}"} , changeImages)
                    $('#set_primary button').on('click' , {url:"{{route("admin.products.set_primary")}}"} , changeImages)
                    $('#update_primary #update_image').on('change' , {url:"{{route("admin.products.update_primary")}}"} , changeImages)
                },
                error:function (xhr, ajaxOptions, thrownError){
                    console.log("error: " + xhr.status)
                },
            })
        }

        function addNewImageToPage(image_name , image_id , product_id)
        {
            let html = '<div class="col-md-3">'+
                            '<div class="card mb-3">'+
                                '<img class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH'))}}' + '/' + image_name +'">'+
                                '<div class="card-body text-center">'+
                                    '<form action="{{route("admin.products.delete_image")}}" method="post" id="delete_image">'+
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                        '<input type="hidden" name="image_id" value="' + image_id + '">'+
                                        '<input type="hidden" name="product_id" value="' + product_id + '">'+
                                        '<button class="btn btn-danger btn-sm mb-2 w-100"  type="button" ">حذف</button>'+
                                    '</form>'+
                                    '<form action="#" method="post" id="set_primary">'+
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                        '<input type="hidden" name="image_id" value="' + image_id +'">'+
                                        '<input type="hidden" name="product_id" value="' + product_id +'">'+
                                        '<button class="btn btn-primary btn-sm mb-2 w-100" type="button">انتخاب به عنوان تصویر اصلی</button>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            return html;
        }
        function addNewPrimaryImageToPage(image_name , image_id , product_id)
        {
            let html = '<div class="col-md-12">'+
                            '<div class="card mb-3">'+
                                '<img class="card-img-top" src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH'))}}' + '/' + image_name +'">'+
                                '<div class="card-body text-center">'+
                                    '<form action="{{route("admin.products.update_primary")}}" method="post" enctype="multipart/form-data" id="update_primary">'+
                                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                        '<input type="hidden" name="image_id" value="' + image_id + '">'+
                                        '<input type="hidden" name="product_id" value="' + product_id + '">'+
                                        '<input type="file" name="update_image" id="update_image" class="d-none" />'+
                                        '<button type="button" class="btn btn-primary btn-sm mb-2" onclick="$(\'#update_image\').click();">اپدیت</button>'+
                                    '</form>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            return html;
        }
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش عکس های محصول </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.index')}}">
            نمایش محصولات
        </a>
    </div>
    <div class="row m-4">
        <form action="{{route("admin.products.add_image")}}" id="form_add_image" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="file" name="add_image" id="add_image" class="d-none" />
            <button type="button" onclick="$('#add_image').click();" class="btn btn-success w-100">
                اضافه کردن عکس
            </button>
        </form>
    </div>

    <div class="mx-5 row" id="show-images">
    @foreach ($product->images as $image)
            <div class="{{$image->is_primary === 1 ? "col-md-12" : "col-md-3"}}">
                <div class="card mb-3">
                    <img class="card-img-top" src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                         alt="{{ $product->name }}">
                    <div class="card-body text-center">
                        @if($image->is_primary === 1)
                            <form action="" method="post" enctype="multipart/form-data" id="update_primary">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="file" name="update_image" id="update_image" class="d-none" />
                                <button type="button" onclick="$('#update_image').click();" class="btn btn-primary btn-sm mb-2">اپدیت</button>
                            </form>
                        @elseif($image->is_primary === 0)
                            <form action="{{route("admin.products.delete_image")}}" method="post" id="delete_image">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-danger btn-sm mb-2 w-100" type="button">حذف</button>
                            </form>
                            <form action="" method="post"  id="set_primary">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-primary btn-sm mb-2 w-100" type="button">انتخاب به عنوان تصویر اصلی</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
