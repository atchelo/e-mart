@extends('front.layout.master') 
@section('title',"$page->name | ")
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="keywords" content="{{ isset($seoset) ? $seoset->metadata_key : '' }}">
<meta property="og:title" content="{{ $page->name }} | {{ isset($seoset) ? $seoset->project_name : config('app.name') }}" />
<meta property="og:description" content="{{substr(strip_tags($page->des), 0, 100)}}{{strlen(strip_tags( $page->des))>100 ? '...' : ""}}" />
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:image" content="{{ url('images/genral/'.$front_logo) }}" />
<meta name="twitter:description" content="{{substr(strip_tags($page->des), 0, 100)}}{{strlen(strip_tags( $page->des))>100 ? '...' : ""}}" />
<meta name="twitter:site" content="{{ url()->current() }}" />
<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebPage","description":"{{substr(strip_tags($page->des), 0, 100)}}{{strlen(strip_tags( $page->des))>100 ? '...' : ""}}","image":"{{ url('images/genral/'.$front_logo) }}"}</script>
@endsection
@section('body')

<div class="container-fluid">
	@if(isset($page))
		<div class="row">
			<div class="terms-conditions-page width100">
				<div class="wow terms-conditions"> 
					<h1 class="text-dark">{{ $page->name }}</h1>
						<hr> 
					{!!  $page->des  !!} 
				</div>
			</div>
		</div>
	@endif
</div>

@endsection