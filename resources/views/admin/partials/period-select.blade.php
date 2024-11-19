@php
    $dates = generateMonthRangeFromDate($date);
@endphp
<div class="period-select">
    <div class="period-select-icon">
        <i class="fa fa-calendar-alt"></i>
    </div>
    <select id="period-select" class="form-select radius w-auto">
        @foreach ($dates as $date)
            <option value="{{ url()->current() . '?period=' . $date['key'] }}" @selected(request('period') == $date['key'])>
                {{ $date['value'] }}
            </option>
        @endforeach
    </select>
</div>
