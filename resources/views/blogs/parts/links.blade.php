<ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
    @foreach($blogCategories as $blogCategorie)
        <li class="nav-item" role="presentation">
            <button
                class="nav-link @if($loop->index == 0) active @endif"
                id="pills-1-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-{{$blogCategorie->id}}"
                type="button"
                role="tab"
                aria-controls="pills-{{$blogCategorie->id}}"
                aria-selected="true"
            >
                {{$blogCategorie->getName()}}
            </button>
        </li>

    @endforeach

</ul>
