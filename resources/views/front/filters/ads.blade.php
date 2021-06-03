@if(isset($isad))
            <div class="adbox">
                <div class="home-banner outer-top-n outer-bottom-xs">
                    @if($isad->adsensecode != '')
                      @php
                        echo html_entity_decode($isad->adsensecode);
                      @endphp
                    @else
                        @if($isad->show_btn == '1')
                           <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                           <h4 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h4>
                           <center><a href="
                           @if($isad->linkby == 'category')
                            {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                           @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product->subvariants)
                            {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                           @elseif($isad->linkby == 'url')
                            {{ $isad->url }}
                           @endif" style="color:{{ $isad->btn_txt_color }};background: {{ $isad->btn_bg_color }}" class="btn buy-button">{{ $isad->btn_text }}</a></center>
                           <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-fluid">
                           @elseif($isad->show_btn == 0 && $isad->top_heading != '')
                           <a href="
                            @if($isad->linkby == 'category')
                              {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                            @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product->subvariants)
                              {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                            @elseif($isad->linkby == 'url')
                              {{ $isad->url }}
                            @endif
                          ">
                            <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                            <h4 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h4>
                            <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-fluid">
                          </a>
                        @else
                          <a href="
                          @if($isad->linkby == 'category')
                            {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                          @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product->subvariants)
                            {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                          @elseif($isad->linkby == 'url')
                            {{ $isad->url }}
                          @endif
                          ">
                            <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-fluid">
                          </a>
                        @endif
                    @endif
                </div>
            </div>

@endif