<aside class="ps-4">
    <div class="widgetBox mb-5">
        <div class="widgetTitle">Daha fazlasını keşfedin</div>
        <div class="discoverLinks">
            @foreach($blogCategories as $category)
                <a href="{{route('blogs.category', $category->getSlug())}}">{{$category->getName()}}</a>
            @endforeach
        </div>
    </div>

</aside>
