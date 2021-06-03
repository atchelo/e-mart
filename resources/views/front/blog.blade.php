@extends("front/layout.master")
@section('title',"$value->heading | ")
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="keywords" content="{{ isset($seoset) ? $seoset->metadata_key : '' }}">
<meta property="og:title" content="{{ $value->heading }} | {{ isset($seoset) ? $seoset->project_name : config('app.name') }}" />
<meta property="og:description" content="{{substr(strip_tags($value->post), 0, 100)}}{{strlen(strip_tags( $value->post))>100 ? '...' : ""}}" />
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ url('images/blog/'.$value->image) }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:image" content="{{ url('images/blog/'.$value->image) }}" />
<meta name="twitter:description" content="{{substr(strip_tags($value->post), 0, 100)}}{{strlen(strip_tags( $value->post))>100 ? '...' : ""}}" />
<meta name="twitter:site" content="{{ url()->current() }}" />
<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebPage","description":"{{substr(strip_tags($value->post), 0, 100)}}{{strlen(strip_tags( $value->post))>100 ? '...' : ""}}","image":"{{ url('images/blog/'.$value->image) }}"}</script>
@endsection
@section("body")
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
   <div class="container-fluid">
      <div class="breadcrumb-inner">
         <ul class="list-inline list-unstyled">
            <li><a href="{{ url('/') }}">{{ __('staticwords.Home') }}</a></li>
            <li class=''><a href="{{ route('front.blog.index') }}">{{ __('staticwords.Blog') }}</a></li>
            <li class='active'>{{ $value->heading }}</li>
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
            <div class="col-12 col-sm-9 col-md-12 col-lg-9 rht-col">
               <div class="blog-post wow fadeInUp">
                  <img class="img-responsive" title="{{ $value->heading }}" src="{{ url('images/blog/'.$value->image) }}" alt="blog_image">
                  <h1>{{ $value->heading }}</h1>
                  <span class="author">{{ $value->user }}</span>
                  <span class="review">{{ $value->comments->count() }} {{ __('staticwords.Comments') }}</span> | 
                  <span class="date-time">{{ date('d/m/Y | h:i A',strtotime($value->created_at)) }} </span> | 
                  <span class="views"><i class="fa fa-eye"></i> {{ views($value)->unique()->count() }} </span> | 
                  <span class=""><i class="fa fa-clock-o" aria-hidden="true"></i> {{ read_time($value->des ) }}</span>
                  {!! $value->des !!}
                   @php
                      echo Share::currentPage(null,[],'<div class="row">', '</div>')
                      ->facebook()
                      ->twitter()
                      ->telegram()
                      ->whatsapp();
                     @endphp
               </div>
               <div class="blog-post-author-details wow fadeInUp">
                  <div class="row">
                     <div class="col-md-2 ">
                        <img class="img-circle img-responsive" title="{{ $value->user }}" src="{{ Avatar::create($value->user)->toBase64() }}" alt="user_image" />
                     </div>
                     <div class="col-md-10 blog-post-dtl">
                        <h4>{{ $value->user }}</h4>
                       
                        <span class="author-job">{{ $value->post }}</span>
                        <p>{{ $value->about }}</p>
                     </div>
                  </div>
               </div>
               <div class="blog-review wow fadeInUp">
                  <div id="blogComments" class="row">
                     @if(count($value->comments)>0)
                      <div class="col-md-12">
                        <h3 class="title-review-comments"><i class="fa fa-comments-o" aria-hidden="true"></i> {{ $value->comments->count() }} {{ __('staticwords.Comments') }}</h3>
                     </div>
                      @foreach($value->comments->sortByDesc('id')->take(5) as $comment)
                           
                        @if($comment->status == 1)
                           <div class="col-md-2 col-sm-2 col-xs-12">
                              <img width="70px" title="{{ $comment->name }}" src="{{ Avatar::create($comment->name)->toBase64() }}" alt="user_image" class="img-rounded img-responsive">
                           </div>

                           <div class="col-md-10 col-sm-10 col-xs-10 blog-comments outer-bottom-xs">
                              <div class="blog-comments inner-bottom-xs">
                                 <h4>{{ $comment->name }}</h4>
                                 <span class="review-action pull-right">
                                    {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                 </span>
                                 {!! $comment->comment !!}
                              </div>
                              
                           </div>
                        @endif
                     
                      @endforeach
                     @if(count($value->comments)>5)
                        <div class="post-load-more col-md-12" id="remove-row">
                           <button type="button" data-postid="{{ $value->id }}" data-id="{{ $comment->id }}" id="btn-more" class="btn btn-upper btn-primary">{{ __('Load more') }}...</button>
                        </div>
                     @endif
                     @else
                     <div class="col-md-12">
                        <h4>
                           <i class="fa fa-comments-o" aria-hidden="true"></i> {{ __('staticwords.nocomment') }}
                        </h4>
                     </div>
                     @endif
                    
                  </div>   
               </div>
               <div class="blog-write-comment outer-bottom-xs outer-top-xs">
                  <div class="row">
                     <div class="col-md-12">
                        <h4>{{ __('staticwords.LeaveAComment') }}</h4>

                         <form class="register-form" role="form" action="{{ route('blog.comment.store',$value->id) }}" method="POST">
                           @csrf
                           
                           <div class="form-group">
                              <label class="info-title" for="exampleInputName">{{ __('Your Name') }} <span>*</span></label>
                              <input required="" type="text" class="form-control unicase-form-control text-input" name="name">
                           </div>
                        
                     
                           <div class="form-group">
                              <label class="info-title" for="exampleInputEmail1">{{ __('Email Address') }} <span>*</span></label>
                              <input required="" type="email" class="form-control unicase-form-control text-input" name="email">
                           </div>
                        
                    
                           <div class="form-group">
                              <label class="info-title" for="exampleInputComments">{{ __('Your Comments') }} <span>*</span></label>
                              <textarea required="" id="commentpanel" rows="5" cols="30" class="form-control unicase-form-control" id="exampleInputComments" name="comment"></textarea>
                           </div>
                        
                     
                       
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">
                           {{ __('Submit Comment') }}
                        </button>
                     </form>
                    
                     
                       
                     </div>
                  </div>
               </div>
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
                  <div class="sidebar-widget outer-bottom-xs wow fadeInUp">
                     <h3 class="section-title">{{ __('staticwords.Youmayalsolike') }}</h3>
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#popular" data-toggle="tab">{{ __('staticwords.Popularposts') }}</a></li>
                        <li><a href="#recent" data-toggle="tab">{{ __('staticwords.Recentposts') }}</a></li>
                     </ul>
                     <div class="tab-content" class="padding-left0">
                        <div class="tab-pane active m-t-20" id="popular">
                           @if(count($popularpost)>0)
                              @foreach($popularpost as $post)
                                 <div class="blog-post inner-bottom-30 " >
                                    <img class="img-responsive" src="{{ url('images/blog/'.$post->image) }}" alt="blog_image" title="{{ $post->heading }}">
                                    <h4><a href="{{ route('front.blog.show',$post->slug) }}">{{ $post->heading }}</a></h4>
                                    <span class="review">{{ $post->comments->count() }} Comments</span>
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
                          	$blogs = App\Blog::where('id','!=',$value->id)->where('status','=','1')->orderBy('id','DESC')->take(5)->get();
                          @endphp

                          	 @if(count($blogs)>0)

	                          @foreach($blogs as $blog)
	                          	<div class="blog-post inner-bottom-30" >
		                              <img class="img-responsive" src="{{ url('images/blog/'.$blog->image) }}" alt="blog_image" title="{{ $blog->heading }}">
		                              <h4><a href="{{ route('front.blog.show',$blog->slug) }}">{{ $blog->heading }}</a></h4>
		                              <span class="review">{{ $blog->comments->count() }} {{ __('staticwords.Comments') }}</span>
		                              <span class="date-time">{{ date('d/m/Y', strtotime($blog->created_at)) }}</span>
		                              <span title="Total Views" class="views"><i class="fa fa-eye"></i> {{ views($blog)->unique()->count() }}</span>
		                              <p>{{substr(strip_tags($blog->des), 0, 50)}}{{strlen(strip_tags($blog->des))>50 ? '...' : ""}}</p>
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
  var loadmorecommenturl = {!! json_encode( url("load/more/posts/comment") ) !!};
  var blogpost = {!! json_encode( url('blog/post/') ) !!};
</script>
<script src="{{ url('js/blog.js') }}"></script>
@endsection