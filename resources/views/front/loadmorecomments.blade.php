@foreach($comments as $comment)
<div class="mt-2 media border border-default p-2">
    <img src="{{ Avatar::create($comment->name)->toGravatar() }}" class="align-self-center mr-3" alt="{{ $comment->name }}">
    <div class="media-body">
      <small class="float-right">{{ $comment->created_at->diffForHumans() }}</small>
      <h5 class="mt-0">{{ $comment->name }}</h5>
      <p class="mb-0">
        {!! $comment->comment !!}
      </p>
    </div>
</div>
@endforeach

<p></p>
    <div align="center" class="remove-row">
        <button data-proid="{{ $proid }}" data-id="{{ $comment->id }}"
        class="btn-more btn btn-info btn-sm">{{ __('staticwords.LoadMore') }}</button>
    </div>
<p></p>