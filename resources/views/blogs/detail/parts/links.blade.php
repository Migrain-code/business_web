@if(count($heads) > 0)
    <div class="moreContent">
        <a href="javascript:;" class="moreContentLink">İçerikleri Göster</a>
        <div class="moreContentList">
            <div class="row">
                @forelse($heads as $head)
                    <div class="col-lg-4">
                        <a href="#head-{{$loop->index}}">{!! $head !!} </a>
                    </div>
                @empty
                @endforelse


            </div>
        </div>
    </div>
@endif
