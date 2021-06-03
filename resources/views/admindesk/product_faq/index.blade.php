@extends("admindesk/layouts.master")

@section("body")
           

@section('data-field')
Faq
@endsection
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Faq</h3>
        
           <div class="panel-heading">
              <a href="{{url('admindesk/products/create')}}" class="btn btn-success owtbtn">+ Add Faq</a>
            </div>       
       </div>
      <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>id</th>
              
              <th>question</th>
              <th>answer</th>
              <th>Action</th>
              
            </tr>
          </thead>
          <tbody>
            <?php $i=1;?>
            @foreach($faqs as $faq)
            <tr>
            <td>{{$i++}}</td>
            <td>{{$faq->question}}</td>
            <td>{{$faq->answer}}</td>
             
            <td>
              <form method="post" action="{{url('admindesk/product_faq/'.$faq->id)}}" class="pull-right">
                  {{csrf_field()}}
                   {{method_field("DELETE")}}
                    <button class="btn btn-danger abc">Delete</button>
              </form>
                
            </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection