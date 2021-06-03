@foreach($comments as $comment)
                           
   @if($comment->status == 1)
      <div class="col-md-2 col-sm-2 wow fadeInUp">
         <img width="70px" title="{{ $comment->name }}" src="{{ Avatar::create($comment->name)->toBase64() }}" alt="user_image" class="img-rounded img-responsive">
      </div>

      <div class="col-md-10 col-sm-10 wow fadeInUp blog-comments outer-bottom-xs">
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

<div class="post-load-more col-md-12" id="remove-row">
   <button type="button" data-postid="{{ $comment->id }}" data-id="{{ $comment->id }}" id="btn-more" class="btn btn-upper btn-primary">
      {{ __('Load more') }}...
   </button>
</div>