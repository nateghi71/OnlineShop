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
        <li class="px-4 py-2">
            <a href="#coupon-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> کوپن ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="coupon-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.coupons.index')}}">کوپن ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.coupons.create')}}"> ایجاد کوپن</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#user-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> کاربران <span> + </span></a>
            <ul class="collapse list-unstyled" id="user-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.users.index')}}">کاربران</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.users.create')}}"> ایجاد کاربر</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#permission-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> دسترسی ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="permission-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.permissions.index')}}">دسترسی ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.permissions.create')}}"> ایجاد دسترسی</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#role-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> نقش ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="role-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.roles.index')}}">نقش ها</a> </li>
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.roles.create')}}"> ایجاد نقش</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#comment-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between"> کامنت ها <span> + </span></a>
            <ul class="collapse list-unstyled" id="comment-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.comments.index')}}">کامنت ها</a> </li>
            </ul>
        </li>
        <hr>
        <li class="px-4 py-2">
            <a href="#rate-menu" data-bs-toggle="collapse" class="text-decoration-none text-primary d-flex justify-content-between">امتیازات <span> + </span></a>
            <ul class="collapse list-unstyled" id="rate-menu">
                <li class="mt-3 ps-3"><a class="text-decoration-none text-secondary" href="{{ route('admin.rates.index')}}">امتیازات</a> </li>
            </ul>
        </li>
    </ul>
</aside>



