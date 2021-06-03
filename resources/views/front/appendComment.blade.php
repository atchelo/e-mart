 <div class="row">
        <div class="col-lg-1">
            <div class="author-img">
               <img class="rounded-circle" width="70px" title="{{ $arr['name'] }}" src="{{ Avatar::create($arr['name'])->toBase64() }}"/>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="author-discription">
                <div class="row">
                    <div class="col-md-6">
                        <div class="author-name"><a href="#" title="{{ $arr['name'] }}">{{ $arr['name'] }}</a></div>
                    </div>
                    <div class="col-md-6">
                        <div class="author-date text-right"><a href="#" title="{{ \Carbon\Carbon::parse($arr['date'])->diffForHumans() }}">{{ \Carbon\Carbon::parse($arr['date'])->diffForHumans() }}</a></div>
                    </div>
                </div>
                <p>{!! $arr['msg'] !!}</p>
                
            </div>
        </div>
</div>
<br>