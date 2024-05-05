@foreach($monthlyPackages as $package)
    <div class="col-lg-4 col-md-6" data-aos="zoom-in">
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

            <a href="{{route('business.home')}}">30 Gün Ücretsiz Deneyin</a>
        </div>
    </div>
@endforeach

