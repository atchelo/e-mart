@extends("admindesk/layouts.master")
@section('title','Custom Style and Javascript | ')
@section("body")

  <div class="box">
    <div class="box-header with-border">
      <div class="box-title">
        Custom Css and JS
      </div>
    </div>

    <div class="box-body">
      <div class="admin-form-main-block mrg-t-40">
        <h4 class="admin-form-text">Custom Style Settings</h4>
        <div class="form-group{{ $errors->has('css') ? ' has-error' : '' }}">
        <form action="{{ route('css.store') }}" method="POST">
          {{ csrf_field() }}
         <div class="form-group">
            <label for="css">Custom CSS:</label>
              <small class="text-danger">{{ $errors->first('css','CSS Cannot be blank !') }}</small>
            <textarea placeholder="a {
              color:red;
            }"  id="he" class="form-control" name="css" rows="10" cols="30">@if(isset($css)) {{ $css }} @endif</textarea>
         </div>
        
        <div class="form-group">
           <input @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif  value="ADD Css" class="btn btn-md btn-primary">
        </div>
        </form>
        </div>
        <br>
        <div class="form-group{{ $errors->has('js') ? ' has-error' : '' }}">
        <form action="{{ route('js.store') }}" method="POST">
          {{ csrf_field() }}
        <label for="js">Custom JS:</label>
        <small class="text-danger">{{ $errors->first('js','Javascript Cannot be blank !') }}</small>
        <textarea required placeholder="$(document).ready(function{
          //code
      });" class="form-control" name="js" rows="10" cols="30">@if(isset($js)) {{ $js }} @endif</textarea>
      </div>
       
        <input @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This operation is disabled in demo !" @endif value="ADD JS" class="btn btn-md btn-primary">
        </form>
        
      </div>
    </div>
  </div>
@endsection
