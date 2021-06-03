@extends('admindesk.layouts.master')
@section('title','Import Demo')
@section('body')    

  @component('components.box',['border' => 'with-border'])

    @slot('header')
        Import Demo 
    @endslot

    @slot('boxBody')
        <div class="row">

            <div class="col-md-12">
                <div class="callout callout-danger">
                    <i class="fa fa-info-circle"></i> Important Note:

                    <ul>
                        <li>
                            {{__("ON Click of import data your existing data like products,brands will remove except users,settings.")}}
                        </li>

                        <li>
                            {{__("ON Click of reset data will reset your site (which you see after fresh install).")}}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-offset-4 col-md-2">
            <form action="{{ url('/admindesk/import/import-demo') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-success">
                            {{__("One Click Demo Import")}}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <form action="{{ url('/admindesk/reset-demo') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-warning">
                            {{__("Reset Demo")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endslot
      
  @endcomponent

@endsection