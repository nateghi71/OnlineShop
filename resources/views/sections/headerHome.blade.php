<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-3">
                    <a class="nav-link active" aria-current="page" href="{{route('home.index')}}">خانه</a>
                </li>
                @foreach(\App\Models\Category::where('parent_id' , 0)->get() as $parentCategory)

                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{$parentCategory->name}}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($parentCategory->children as $cat)
                            <li><a class="dropdown-item" href="{{route('home.product.search.category' , ['category' => $cat->slug])}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

