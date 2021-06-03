@extends("admindesk/layouts.master")
@section('title',"Edit Static Word Translations for $findlang->name |")
@section("body")
	<div class="box">
		<div class="box-header with-border">
			<a title="Cancel and go back" href="{{ route('site.lang') }}" class="btn btn-md btn-default">
				<i class="fa fa-reply"></i>
			</a>
			<div class="box-title">Static Word Translations for Language: {{ $findlang->name }}</div>
		</div>

		<div class="box-body">
				
			<div class="callout callout-info">
				<i class="fa fa-info-circle"></i> Update Each Translation Carefully and look for comma (,) also if adding new words else it will cause major errors.
			</div>

			<form action="{{ route('static.trans.update',$findlang->lang_code) }}" method="POST">
				@csrf
				<textarea name="transfile" class="form-control" cols="100" rows="20">{{ $file }}</textarea>
			

		</div>
		<div class="box-footer">
			<button @if(env("DEMO_LOCK") == 0) type="submit" title="This operation is disabled in demo !" @endif class="btn btn-primary btn-md btn-flat">
				<i class="fa fa-save"></i> Save Changes
			</button>

			<a title="Cancel and go back" href="{{ route('site.lang') }}" class="btn btn-md btn-flat btn-default">
			 <i class="fa fa-reply"></i> Cancel
			</a>
		</div>
		</form>
	</div>
@endsection