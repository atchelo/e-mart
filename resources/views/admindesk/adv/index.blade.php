@extends("admindesk.layouts.master")
@section('title','All Advertisement |')
@section("body")
  <div class="box">
      <div class="box-header with-border">

          <div class="box-title">
            List All Advertisements
          </div>

          <a title="Create new ad" href="{{ route('adv.create') }}" class="pull-right btn btn-md btn-primary">
              <i class="fa fa-plus-circle"></i> Create New Ad
          </a>
      </div>

      <div class="box-body">
          <table id="adTable" class="width100 table table-bordered table-striped">
            <thead>

              <th>
                #
              </th>
              <th>
                Layout
              </th> 
              <th>
                  Position
              </th>
              <th>
                Status
              </th>
              <th>
                Action
              </th>
            </thead>

            <tbody>
              
            </tbody>
         </table>
      </div>
  </div>
@endsection
@section('custom-script')
 <script>var advindexurl = "<?=route('adv.index')?>"</script>
 <script src="{{ url('js/layoutadvertise.js') }}"></script>
@endsection
