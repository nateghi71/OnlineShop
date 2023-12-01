<aside class="js-fullHeight bg-light border-end">

    <h3 class="p-3 mb-3 bg-primary"><a href="#" class="text-decoration-none text-white"> داشبورد</a></h3>

    <ul class="list-unstyled pb-2 m-0">
        <li class="px-4 py-2">
            <a href="#attribute-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> ویژگی ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="attribute-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.attributes.index')}}">ویژگی ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.attributes.create')}}"> ایجاد ویژگی</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#category-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> دسته بندی ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="category-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.categories.index')}}">دسته بندی ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.categories.create')}}"> ایجاد دسته بندی</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#tag-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> تگ ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="tag-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.tags.index')}}">تگ ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.tags.create')}}"> ایجاد تگ</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#product-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> محصول ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="product-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.products.index')}}">محصول ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.products.create')}}"> ایجاد محصول</a> </li>
            </ul>
        </li>
        <hr>
    </ul>
</aside>



