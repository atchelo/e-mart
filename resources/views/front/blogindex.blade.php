@extends('front.layout.master') 
@section('title','All Blogs | ') 
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="keywords" content="All Blogs | {{ isset($seoset) ? $seoset->metadata_key : '' }}">
<meta property="og:title" content="{{ isset($seoset) ? $seoset->project_name : config('app.name') }}" />
<meta property="og:description" content="{{ isset($seoset) ? $seoset->metadata_des : '' }}" />
<meta property="og:type" content="blog"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:description" content="{{ isset($seoset) ? $seoset->metadata_des : '' }}" />
<meta name="twitter:site" content="{{ url()->current() }}" />
<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebPage","description":"{{ isset($seoset) ? $seoset->metadata_des : '' }}","image":"{{ url('images/genral/'.$front_logo) }}"}</script>
@endsection
@section('body')
<div class="breadcrumb">
	<div class="container-fluid">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="{{ url('/') }}">{{ __('staticwords.Home') }}</a></li>
				<li class='active'>{{ __('staticwords.Blog') }}</li>
			</ul>
		</div>
		<!-- /.breadcrumb-inner -->
	</div>
	<!-- /.container -->
</div>
<p></p>
<div class="body-content">
	<div class="container-fluid">
		<div>
			<div class="row blog-page">
				<div class="col-12 col-sm-9 col-md-12 col-lg-9 main-content">
					@foreach($blogs as $post)
					<div class="blog-post wow fadeInUp">
						<a href="{{ route('front.blog.show',$post->slug) }}">
							<img class="img-responsive" src="{{ url('images/blog/'.$post->image) }}" alt="blog_image" title="{{ $post->heading }}">
						</a>
						<h1><a href="{{ route('front.blog.show',$post->slug) }}">{{ $post->heading }}</a></h1> <span class="author">{{ $post->user }}</span> <span class="review">{{ count($post->comments) }} {{ __('staticwords.Comments') }}</span> <span class="date-time">{{ date('d-m-Y h:i A',strtotime($post->created_at)) }}</span>
						<span title="Total Views" class="views"><i class="fa fa-eye"></i> {{ views($post)->unique()->count() }}</span>
						<span class=""><i class="fa fa-clock-o" aria-hidden="true"></i> {{ read_time($post->des ) }}</span>
						<p><p>{{substr(strip_tags($post->des), 0, 400)}}{{strlen(strip_tags( $post->des))>400 ? '...' : ""}}</p></p> <a href="{{ route('front.blog.show',$post->slug) }}" class="btn btn-upper btn-primary read-more">{{ __('staticwords.readmore') }}</a> 
					</div>
					<p></p>
					@endforeach
					<div class="clearfix blog-pagination filters-container wow fadeInUp blog-detail-block">
						<div class="text-right">
							<div class="pagination-container">
								
								{!! $blogs->links() !!}
								
							</div>
							<!-- /.pagination-container -->
						</div>
						<!-- /.text-right -->
					</div>
					<!-- /.filters-container -->
				</div>
				<div class="col-12 col-sm-3 col-md-12 col-lg-3 sidebar">
               <div class="sidebar-module-container">
                  <div class="search-area outer-bottom-small">
                     <form>
                        <div class="control-group">
                           <input placeholder="{{ __('staticwords.Typetosearch') }}" id="blogsearch">
                           <a href="#" class="search-button"></a>   
                        </div>
                     </form>
                  </div>
                  <div class="sidebar-widget outer-bottom-xs wow fadeInUp blog-search">
                     <h3 class="section-title">{{ __('staticwords.Youmayalsolike') }}</h3>
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#popular" data-toggle="tab">{{ __('staticwords.Popularposts') }}</a></li>
                        <li><a href="#recent" data-toggle="tab">{{ __('staticwords.Recentposts') }}</a></li>
                     </ul>
                     <div class="tab-content padding-left0">
                        <div class="tab-pane active m-t-20" id="popular">
                           @if(count($popularpost)>0)
                              @foreach($popularpost as $post)
                                 <div class="blog-post inner-bottom-30 " >
                                    <img class="img-responsive" src="{{ url('images/blog/'.$post->image) }}" alt="blog_image" title="{{ $post->heading }}">
                                    <h4><a href="{{ route('front.blog.show',$post->slug) }}">{{ $post->heading }}</a></h4>
                                    <span class="review">{{ $post->comments->count() }} {{ __('staticwords.Comments') }}</span>
                                    <span class="date-time">{{ date('d/m/Y', strtotime($post->created_at)) }}</span>
                                    <span title="Total Views" class="views"><i class="fa fa-eye"></i> {{ views($post)->unique()->count() }}</span>
                                    <p>{{substr(strip_tags($post->des), 0, 50)}}{{strlen(strip_tags(
                                    $post->des))>50 ? '...' : ""}}</p>
                                 </div>
                              @endforeach
                           @else
                               <div class="blog-post">
                                 <h4>{{ __('staticwords.Nopopularpostfound') }}</h4>
                              </div>
                           @endif
                        </div>
                        <div class="tab-pane m-t-20" id="recent">
                          
                          @php
                          	$blogs = App\Blog::where('status','=','1')->orderBy('id','DESC')->take(5)->get();
                          @endphp

                          	 @if(count($blogs)>0)

	                          @foreach($blogs as $blog)
	                          	<div class="blog-post inner-bottom-30" >
		                              <img class="img-responsive" src="{{ url('images/blog/'.$blog->image) }}" alt="blog_image" title="{{ $blog->heading }}">
		                              <h4><a href="{{ route('front.blog.show',$blog->slug) }}">{{ $blog->heading }}</a></h4>
		                              <span class="review">{{ $blog->comments->count() }} {{ __('staticwords.Comments') }}</span>
		                              <span class="date-time">{{ date('d/m/Y', strtotime($blog->created_at)) }}</span>
		                              <span title="Total Views" class="views"><i class="fa fa-eye"></i> {{ views($blog)->unique()->count() }}</span>
		                              <p>{{substr(strip_tags($blog->des), 0, 50)}}{{strlen(strip_tags(
                						$blog->des))>50 ? '...' : ""}}</p>
	                           	</div>
	                          @endforeach

	                        @else

		                        <div class="blog-post">
		                        	<h4>{{ __('staticwords.Norecentpostfound') }}</h4>
		                        </div>

                          	@endif
                          
                        </div>
                     </div>
                  </div>
                  	
               </div>
            </div>
			</div>
		</div>
	</div>
</div> 
@endsection 
@section('script')
<script>
  var url = {!! json_encode( route("blog.search") ) !!};
</script>
<script src="{{ url('js/blog.js') }}"></script>
@endsection