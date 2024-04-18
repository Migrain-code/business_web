
@foreach($proparties as $propartie)
    <a
        href="#"
        class="item tab @if($loop->index == 0) active @endif"
        data-aos="zoom-in"
        data-aos-delay="100"
        data-tab="tab{{$propartie->id}}"
    >
        <div class="icon">
            <img src="{{image($propartie->icon)}}" alt="" />
        </div>
        <span>{{$propartie->name}}</span>
    </a>

@endforeach
