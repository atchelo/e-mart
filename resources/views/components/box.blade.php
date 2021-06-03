<div class="box {{ $boxType ?? '' }}">
    @if(isset($header))
        <div class="box-header {{ $border ?? '' }}">
            {{ $header ?? '' }}

            
                <div class="pull-right">
                    {{ $rightbar ?? '' }}
                </div>
            
        </div>
    @endif

    <div class="box-body">
        {{ $boxBody ?? '' }}
    </div>
    
    @if(isset($boxfooter))
        <div class="box-footer">
            {{ $boxfooter ?? '' }}
        </div>
    @endif
</div>