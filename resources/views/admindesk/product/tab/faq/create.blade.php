@extends('admindesk/layouts.master')
 @section('body')
    <div class="box">
        <div class="box-header">
            <h3>Product Faq</h3>
        </div>
        <div class="box-body">
            
    <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#lis" aria-controls="home" role="tab" data-toggle="tab">Faq</a></li>
    
  
  </ul>
   
        
    <div class="tab-content">
        

        <div role="tabpanel" class="tab-pane fade in active" id="lis">
            <div class="col-md-8">
               @include('admindesk/product/tab.faq.add_faq')
            </div>      
        </div>
    
    </div>


        </div>
    </div>
  <!-- Nav tabs -->
@endsection
