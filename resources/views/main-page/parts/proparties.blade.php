@if($mainPagePartitions->count() > 0)
    <section class="home-properties">
        <div class="container">
            @foreach($mainPagePartitions as $mainPagePartition)
                <!-- İtem Start -->
                <div class="row properties-item">
                    <div class="col-lg-6">
                        <div class="image" data-aos="zoom-in-left">
                            <img src="{{image($mainPagePartition->image)}}" alt=""/>
                            <div class="shape-1"></div>
                            <div class="shape-2"></div>
                            <div class="shape-3"></div>
                            <div class="shape-4"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content" data-aos="zoom-in-right">
                            <h3>{{$mainPagePartition->getName()}}</h3>
                            <p>
                                {{$mainPagePartition->getValue()}}
                            </p>
                            {{--
                                <ul>
                                <li>
                                    <img
                                        src="/front/assets/images/business/tick-square.svg"
                                        alt=""
                                    />
                                    Müşteri memnuniyetini artırın
                                </li>
                                <li>
                                    <img
                                        src="/front/assets/images/business/tick-square.svg"
                                        alt=""
                                    />
                                    Müşteri verilerini güvenle saklayın
                                </li>
                            </ul>
                            --}}
                            <a href="{{$mainPagePartition->link}}" target="_blank"> {{$mainPagePartition->getButtonText()}} </a>
                        </div>
                    </div>
                </div>
                <!-- İtem End -->
            @endforeach
        </div>
    </section>
@endif
