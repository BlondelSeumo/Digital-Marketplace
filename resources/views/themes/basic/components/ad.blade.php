@if ($code)
    @if ($alias != 'head_code')
        <div class="w-100 m-auto">
            <div {{ $attributes }}>
                <center>{!! $code !!}</center>
            </div>
        </div>
    @else
        {!! $code !!}
    @endif
@endif
