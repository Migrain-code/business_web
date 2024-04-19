<div class="tab-content" id="pills-tabContent">
    @foreach($blogCategories as $blogCategorie)
        <div
            class="tab-pane fade @if($loop->index == 0) show active @endif"
            id="pills-{{$blogCategorie->id}}"
            role="tabpanel"
            aria-labelledby="pills-home-tab"
            tabindex="0"
        >
            <div class="blogList">
                <div class="row">
                    @foreach($blogCategorie->blogs as $blog)

                    <div class="col-lg-3">

                        <x-blog-component
                            image="{{image($blog->image)}}"
                            link="{{route('blogs.detail', $blog->getSlug())}}"
                            categoryName="{{$blogCategorie->getName()}}"
                            date="{{$blog->created_at->format('d.m.Y')}}"
                            title="{{$blog->getTitle()}}"
                            shortDescription="{{\Illuminate\Support\Str::limit(strip_tags($blog->getDescription()), 100)}}">
                        </x-blog-component>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach



</div>
