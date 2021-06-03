<button class="btn btn-sm btn-success" data-toggle="modal" type="button" data-target="#editModal{{ $id }}">
  <i class="fa fa-pencil"></i> Edit
</button>
@if($currencyextract['default_currency'] != 1)
<button class="btn btn-sm btn-danger" data-toggle="modal" type="button" data-target="#deleteModal{{ $id }}">
  <i class="fa fa-trash-o"></i> Delete
</button>
@endif
<div id="editModal{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-md">
      <div class="modal-header">
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="my-modal-title">Edit Currency {{ $code }}</h4>

      </div>
      <div class="modal-body">
        <form action="{{ route('multiCurrency.update',$code) }}" method="POST">
          @csrf

          @method('PUT')

          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label>Currency Code: <span class="text-danger">*</span></label>
                <input readonly placeholder="eg. USD" value="{{ $code }}" required class="form-control width100"
                  type="text" name="code">
              </div>
            </div>


            <div class="col-md-12">
              <br>
              <div class="form-group">
                <label>Additional Charge:</label>
                <input placeholder="eg. 0.50" min="0" step="0.01" value="{{ $currencyextract['add_amount'] }}"
                  class="form-control width100" type="number" name="add_amount">
              </div>
            </div>

            <div class="col-md-12">
              <br>
              <div class="form-group">
                <label>Currency Position: <span class="text-danger">*</span></label>
                <br>
                 <select name="position" id="position" class="form-control">
                    <option value="">Please select currency position</option>
                    <option {{ $currencyextract['position'] == 'l' ? "selected" : "" }} value="l">Left side currency icon</option>
                    <option {{ $currencyextract['position'] == 'r' ? "selected" : "" }} value="r">Right side currency icon</option>
                    <option {{ $currencyextract['position'] == 'ls' ? "selected" : "" }} value="ls">Left side with space currency icon</option>
                    <option {{ $currencyextract['position'] == 'rs' ? "selected" : "" }} value="rs">Right side with space currency icon</option>
                 </select>
              </div>
            </div>

            <div class="col-md-12">
              <br>
              <div class="form-group">
                <label>Currency Symbol: <span class="text-danger">*</span></label>
                <br>
                <div class="input-group iconpicker-container">
                  <input placeholder="Please select currency symbol" data-placement="bottomRight"
                    class="form-control width100 showcur icp icp-auto iconpicker-element iconpicker-input"
                    name="currency_symbol" value="{{ $currencyextract['currency_symbol'] }}" type="text">
                  <span class="input-group-addon"><i class="far fa-grin-tongue-squint"></i></span>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <br>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-md">
                  <i class="fa fa-save"></i> {{ __('Update') }}
                </button>
              </div>
            </div>



          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div id="deleteModal{{ $id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete currency <b>{{ $code }}</b>? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
         <form method="post" action="{{route('multiCurrency.destroy',$currencyextract['id'])}}" class="pull-right">
           @method('delete')
           @csrf
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.showcur').iconpicker({

    icons: ['fa fa-inr', 'fa fa-eur', 'fa fa-bitcoin', 'fa fa-btc', 'fa fa-cny', 'fa fa-dollar', 'fa fa-gg-circle',
      'fa fa-gg', 'fa fa-rub', 'fa fa-ils', 'fa fa-try', 'fa fa-krw', 'fa fa-gbp', 'fa fa-zar', 'fa fa-rs',
      'fa fa-pula', 'fa fa-aud', 'fa fa-egy', 'fa fa-taka', 'fa fa-mal', 'fa fa-rub', 'fa fa-brl', 'fa fa-idr',
      'fa fa-zwl', 'fa fa-ngr', 'fa fa-eutho', 'fa fa-sgd','fa fa-dzd'
    ],
    selectedCustomClass: 'label label-success',
    mustAccept: true,
    placement: 'right',
    hideOnSelect: true,
  });
</script>