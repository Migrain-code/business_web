@foreach($monthlyPackages as $package)
    <div class="col-4" data-aos="zoom-in">
        <div class="package-item">
            <div class="icon">
                <img src="{{image($package->icon)}}" style="width: 40px" alt="" />
            </div>
            <div class="package-info">
                <h4>{{$package->name}}</h4>
                <span>{{$package->price ==  0 ? "Ücretsiz" : formatPrice($package->price)}}</span>
            </div>

            <ul>
                @foreach($package->proparties as $propartie)
                    <li>{{$propartie->list->name}}</li>
                @endforeach
            </ul>

            <a href="{{route('business.register')}}">Ömür Boyu Ücretsiz Deneyin</a>
        </div>
    </div>
@endforeach

