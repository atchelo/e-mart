@extends('admindesk.layouts.master')
@section('title','Terms Settings | ')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Terms Settings
            </div>
        </div>

        <div class="box-body">
            <div class="nav-tabs-custom">

                <!-- Nav tabs -->
                <ul id="myTabs" class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#userterm" aria-controls="home" role="tab" data-toggle="tab">User term setting</a></li>
                  <li role="presentation"><a href="#sellerterm" aria-controls="profile" role="tab" data-toggle="tab">Seller term setting</a></li>
                </ul>
              
                <!-- Tab panes -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="userterm">
                      <form method="POST" action="{{ route('update.term.setting',$userTerm->key) }}">
                          @csrf

                          <div class="form-group">
                              <label for="title">Title: <span class="text-red">*</span></label>
                              <input required placeholder="enter title" id="title" class="form-control" type="text" name="title" value="@if(old('title')) {{ old('title') }} @elseif(isset($userTerm)){{ $userTerm['title'] }}@endif">

                              @error('title')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label>Description: <span class="text-red">*</span></label>
                              <textarea placeholder="enter content" class="editor" name="description" id="description" cols="30" rows="10">@if(old('content')) {{ old('content') }} @elseif(isset($userTerm)){!! $userTerm['description'] !!}@endif</textarea>

                              @error('description')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="form-group">
                              <button class="btn btn-md btn-primary">
                                <i class="fa fa-save"></i> {{ __('Save') }}
                              </button>
                          </div>
                      </form>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="sellerterm">
                    <form method="POST" action="{{ route('update.term.setting',$sellerTerm->key) }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title: <span class="text-red">*</span></label>
                            <input required placeholder="enter title" id="title" class="form-control" type="text" name="title" value="@if(old('title')) {{ old('title') }} @elseif(isset($sellerTerm)){{ $sellerTerm['title'] }}@endif">

                            @error('title')
                              <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description: <span class="text-red">*</span></label>
                            <textarea placeholder="enter content" class="editor" name="description" id="description" cols="30" rows="10">@if(old('content')) {{ old('content') }} @elseif(isset($sellerTerm)){!! $sellerTerm['description'] !!}@endif</textarea>

                            @error('description')
                              <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-md btn-primary">
                              <i class="fa fa-save"></i> {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                  </div>
                </div>
              
              </div>
        </div>
    </div>
@endsection