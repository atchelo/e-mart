@extends("admindesk.layouts.master")
@section('title',"Maintenance Mode |")
@section("body")
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Maintenance Mode
            </div>
        </div>

        <div class="box-body">
            <form action="{{ route('get.m.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Allowed IP's: </label>
                    <br>
                    <select required class="form-control allowed_ips" name="allowed_ips[]" multiple="multiple" id="allowed_ips">
                        @if(isset($data->allowed_ips))
                            @foreach ($data->allowed_ips as $ip)
                                <option {{ $ip ? "selected" : "" }} value="{{ $ip }}">{{ $ip }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('allowed_ips')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <br>
                    <small class="help-block text-muted">
                        <i class="fa fa-question-circle"></i> <b>Your IP is: <span class="text-dark">{{ Request::ip() }}</span></b>
                    </small>
                    {{-- <input data-role="tagsinput" placeholder="enter allowed ip and seprate it by comma" type="text" class="form-control" name="allowed_ips"> --}}
                </div>

                <div class="form-group">
                    <label>Maintenance mode message <span class="text-danger">*</span></label>
                    <textarea class="editor form-control" name="message" id="message" cols="30" rows="10">@if($data) {!! $data->message !!} @else {{ old('message') }} @endif</textarea>
                    @error('message')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Enable Maintenance mode:</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="status" {{ isset($data) && $data->status == 1 ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                    <br>
                    <small><i class="fa fa-question-circle"></i> Turn On the toggle to enable Maintenance mode</small>
                </div>

                <div class="form-group">
                   <button type="submit" class="btn btn-md btn-primary">
                       <i class="fa fa-save"></i> {{ __('Save') }}
                   </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $('.allowed_ips').select2({
            placeholder: 'Enter IP',
            tags: true,
            tokenSeparators: [',', ' ']
        });
    </script>
@endsection