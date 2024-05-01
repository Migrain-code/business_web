<section id="breadcrumbs" class="my-5 py-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Blog Yazıları
                        </li>
                        @if(request()->routeIs('blogs.category'))
                            <li class="breadcrumb-item active" aria-current="page">
                              {{$blogCategories->first()->getName()}}
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
