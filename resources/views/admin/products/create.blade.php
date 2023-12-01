@extends('layouts.admin')

@section('script')
    <script type="module">
        $(function (){

            // jalaliDatepicker.startWatch();

            $('#tagSelect').select2({
                placeholder: "تگ های موردنظر را انتخاب کنید",
            });
            $('#attribute_normal').select2({
                placeholder: "ویژگی های موردنظر را انتخاب کنید",
            });
            $('#attribute_variation').select2({
                placeholder: "ویژگی های موردنظر را انتخاب کنید",
                maximumSelectionLength: 2
            });
            ClassicEditor.create( document.querySelector( '#description' ) ).catch( error => {
                console.error( error );
            } );

            $('#attribute_normal').change(function (){
                $('#attr_nor').children().remove();
                $(this).find(':selected').each(function (){
                    let option = $(this);
                    if (option.length) {
                        let selText = option.text();
                        let selValue = option.val();
                        let div = $("<div>" , {
                            class:'col-md-6 mb-3',
                        });
                        let label = $("<label>" , {
                            class:'form-label',
                            for:'attr-'+selValue,
                            text:selText
                        });
                        let input = $("<input>",{
                            type:"text",
                            name:`attribute_ids[${selValue}]`,
                            id:'attr-'+selValue,
                            class:"form-control",
                        })

                        div.append(label);
                        div.append(input);
                        $('#attr_nor').append(div)
                    }
                })
            });

            $('#attr_var_header').hide();
            $('#attr_var_btn').hide();

            $('#attribute_variation').change(function (){
                $('#attr_var_header').hide();
                $('#attr_var_btn').hide();
                $('#attr_var').children().remove();
                $('#def-var').children().remove();
                $('#attr_var_btn').find('#variation_btn').attr('disabled' , false);

                $(this).find(':selected').each(function (){
                    let option = $(this);
                    if (option.length) {
                        $('#attr_var_header').show();
                        $('#attr_var_btn').show();
                        let selText = option.text();
                        let selValue = option.val();
                        let div = $("<div>" , {
                            class:'row',
                        });
                        let div2 = $("<div>" , {
                            class:'col-md-4 mb-3',
                        });
                        let div3 = $("<div>" , {
                            class:'col-md-8 mb-3',
                        });

                        let label = $("<label>" , {
                            class:'form-label text-center',
                            for:'attr-var-'+selValue,
                            id:'attr-var-label-'+selValue,
                            text:selText
                        });
                        let input = $("<input>",{
                            type:"text",
                            id:'attr-var-'+selValue,
                            class:"form-control",
                        })
                        div.append(div2);
                        div.append(div3);
                        div2.append(label);
                        div3.append(input);
                        $('#attr_var').append(div)
                    }
                })
            });

            $('#variation_btn').on('click' , ClickVariationBtn);

            $('#add_attr_var_btn').hide();
            function ClickVariationBtn(event){
                event.preventDefault();
                $('#def-var').children().remove();
                $('#attr_var_btn').find('#variation_btn').attr('disabled' , true);
                let selectedOptions = [];
                $('#attribute_variation').find(':selected').each(function (){
                    let option = $(this);
                    if (option.length) {
                        selectedOptions.push(option.val());
                    }
                });
                let wrapper = $("<div>" , {
                    id:'wrapper',
                    class:'row',
                })
                $('#def-var').append(wrapper);

                let variationStates = [];

                selectedOptions.forEach(function (option){
                    $('#attr_var').find('input#attr-var-' + option).attr('disabled' , true);

                    let text = $('#attr_var').find('label#attr-var-label-' + option).text();
                    let values = $('#attr_var').find('input#attr-var-' + option).val().split(',');
                    let myValues = [];
                    while (values.length){
                        let val = values.pop();
                        myValues.push({value:val , attributeName:text , attributeId:option});
                    }
                    myValues.forEach(function (item){
                        let input = $("<input>" , {
                            type:'hidden',
                            name:`attribute_options[${item.attributeId}][]`,
                            value:item.value
                        });
                        $(wrapper).append(input);
                    })

                    variationStates.push(myValues)
                })

                let variations = cartesian(variationStates);
                variations.forEach(function (variation){
                    let subject = '';

                    let div = $("<div>" , {
                        class:'row',
                    });

                    variation.forEach(function (item){
                        subject += item.attributeName +' : ' +item.value + ' , '
                        let input = $("<input>" , {
                            type:'hidden',
                            name:`variations[${item.attributeId}][]`,
                            value:item.value
                        });
                        $(div).append(input);
                    })
                    let p = $("<p>" , {
                        class:'bg-info py-3 rounded',
                        text:subject
                    });

                    wrapper.append('<hr />');
                    $(div).append(p);
                    $(div).append(CreateElement(4,'sku','skus[code][]'));
                    $(div).append(CreateElement(4,'قیمت','skus[price][]'));
                    $(div).append(CreateElement(4,'تعداد','skus[quantity][]'));
                    $(div).append(CreateElement(4,'قیمت حراج','skus[sale_price][]'));
                    $(div).append(CreateElement(4,'تاریخ شروع حراج','skus[date_on_sale_from][]',true));
                    $(div).append(CreateElement(4,'تاریخ پایان حراج','skus[date_on_sale_to][]',true));
                    wrapper.append(div);
                })

            }
        });

        function cartesian(...args) {
            let variations = args.pop();
            let result = [], max = variations.length-1;
            function helper(arr, i) {
                for (let j=0; j<variations[i].length; j++) {
                    let a = arr.slice(0); // clone arr
                    a.push({value:variations[i][j].value , attributeName:variations[i][j].attributeName , attributeId:variations[i][j].attributeId});
                    if (i==max)
                        result.push(a);
                    else
                        helper(a, i+1);
                }
            }
            helper([], 0);
            return result;
        }

        function CreateElement(size , myLabel , name , val = ''){
            let div = $("<div>" , {
                class:'col-md-' + size + ' mb-3',
            });
            let label = $("<label>" , {
                class:'form-label',
                for:name,
                text:myLabel,
            });
            let input = $("<input>",{
                type:"text",
                name:name,
                id:name,
                value:val,
                class:"form-control",
            })

            div.append(label)
            div.append(input)
            return div;
        }
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ایجاد محصول </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.index')}}">
            نمایش محصول ها
        </a>
    </div>

    @if(session()->has('errorDatabase'))
        <div class="alert alert-danger">{{ session('errorDatabase') }}</div>
    @endif
    <div class="mt-5 d-flex justify-content-center">
        <form action="{{route('admin.products.store')}}" method="post"  enctype="multipart/form-data" class="w-75">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">نام</label>
                    <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control" data-jdp/>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="is_active">وضعیت</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" selected>فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                    @error('is_active')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="tagSelect">تگ</label>
                    <select id="tagSelect" name="tag_ids[]" class="form-select" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    @error('tag_ids')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="category_id">دسته بندی</label>
                    <select class="form-select" name="category_id" id="category_id">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">توضیحات</label>
                    <textarea name="description" id="description" class="form-control" ></textarea>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 my-4">
                <hr class="text-primary">
                <p class="text-primary">تصاویر محصول : </p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="primary_image"> انتخاب تصویر اصلی </label>
                    <input type="file" name="primary_image" id="primary_image" value="{{old('primary_image')}}" class="form-control">
                    @error('primary_image')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="images"> انتخاب تصاویر </label>
                    <input type="file" id="images" name="images[]" value="{{old('images[]')}}" class="form-control" multiple>
                    @error('images[]')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 my-4">
                <hr class="text-primary">
                <p class="text-primary">ویژگی ها :</p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="attribute_normal">ویژگی ها</label>
                    <select class="form-select" id="attribute_normal" multiple>
                        @foreach($attributes as $attribute)
                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="attribute_variation">ویژگی های متغییر</label>
                    <select class="form-select" id="attribute_variation" multiple>
                        @foreach($attributes as $attribute)
                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="attr_nor" class="row"></div>

            <div id="attr_var_header" class="col-md-12 my-4">
                <hr class="text-primary">
                <p class="text-primary">ویژگی های متغیر :</p>
            </div>

            <div id="attr_var"></div>

            <div id="attr_var_btn" class="row">
                <button id="variation_btn" type="button" class="w-100 btn btn-primary mb-4">اعمال</button>
            </div>

            <div id="def-var" class="row"></div>

            <div class="col-md-12 my-4">
                <hr class="text-primary">
                <p class="text-primary">هزینه ارسال :</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount">قیمت ارسال</label>
                    <input type="text" name="delivery_amount" value="{{old('delivery_amount')}}" id="delivery_amount" class="form-control" />
                    @error('delivery_amount')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount_per_product">قیمت ارسال برای هر محصول اضافه</label>
                    <input type="text" name="delivery_amount_per_product" value="{{old('delivery_amount_per_product')}}" id="delivery_amount_per_product" class="form-control" />
                    @error('delivery_amount_per_product')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ارسال</button>
        </form>
    </div>

@endsection
