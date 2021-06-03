@extends("front.layout.master")
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="keywords" content="{{ isset($seoset) ? $seoset->metadata_key : '' }}">
<meta property="og:title" content="{{ isset($seoset) ? $seoset->project_name : config('app.name') }}" />
<meta property="og:description" content="{{ isset($seoset) ? $seoset->metadata_des : '' }}" />
<meta property="og:type" content="WebPage"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:description" content="{{ isset($seoset) ? $seoset->metadata_des : '' }}" />
<meta name="twitter:site" content="{{ url()->current() }}" />
<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebPage","description":"{{ isset($seoset) ? $seoset->metadata_des : '' }}","image":"{{ url('images/genral/'.$front_logo) }}"}</script>
@endsection
@section("body")
<?php $home_slider = App\Widgetsetting::where('name','slider')->first(); ?>
<div class="body-content outer-top-vs" id="top-banner-and-menu">
   
    <div class="container-fluid">
        <div id="app" class="row no-gutters">
            @if(env('HIDE_SIDEBAR') == 0)
            <div class="h-100 col-12 col-sm-12 col-md-12 col-lg-12  col-xl-2 sidebar left-sidebar">
                <div class="side-content">
                    <sidebar-desktop></sidebar-desktop>
                </div>
            </div>
            @endif
            <!-- Start Main -->
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 {{ env('HIDE_SIDEBAR') == 1 ? 'col-xl-12' : 'col-xl-10' }} right-sidebar">
                <div class="main-content homebanner-holder">
                    
                    <homepage></homepage>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@if(isset($offersettings) && $offersettings->enable_popup == 1)
    @if(Cookie::get('popup') == '')
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="fa fa-times"></span>
              </button>
            </div>
            <div class="row no-gutters">
                <div class="col-md-6 d-flex">
                    <div class="modal-body p-5 img d-flex" style="background-image: url('{{ url("/images/offerpopup/".$offersettings->image) }}');">
                    </div>
                  </div>
                  <div class="col-md-6 d-flex">
                    <div class="modal-body p-5 d-flex align-items-center">
                        <div class="text w-100 text-center py-5">
                            <h2 style="color:{{ $offersettings->heading_color }}" class="mb-0">
                                {{$offersettings->heading}}
                            </h2>
                            <h4 style="color:{{ $offersettings->subheading_color }}" class="mt-2 mb-4">
                                {{ $offersettings->subheading }}
                            </h4>
                            @if($offersettings->description != '')
                            <p style="color: {{ $offersettings->description_text_color }}">
                                {{ $offersettings->description }}
                            </p>
                            @endif
                            @if($offersettings->enable_button == 1)
                                <a style="background: {{ $offersettings->button_color }}" href="{{ $offersettings->button_link }}" class="btn btn-primary d-block py-3">
                                    <span style="color: {{ $offersettings->button_text_color }}">{{ $offersettings->button_text }}</span>
                                </a>
                            @endif

                            <p class="mt-3">
                                <label><input class="offerpop_not_show" type="checkbox" name="do_not_show_me"> {{ __('staticwords.dontshowpopuptext') }}</label>
                            </p>
                        </div>
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div>
    @endif
@endif
@endsection
@section('script')
    <script>
        $('.offerpop_not_show').on('change',function(){

            if($(this).is(":checked")){
                var opt = 1;
            }else{
                var opt = 0;
            }

            $.ajax({
                type : 'GET',
                url  : '{{ route("offer.pop.not.show") }}',
                data : {opt : opt},
                dataType : 'json',
                success : function(response){
                    console.log(response);
                }
            });

        });

        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        if(!isMobile.any() ) { //check if it is not mobile
            $('#exampleModalCenter').modal('show');
        }

        

       
    </script>
@endsection