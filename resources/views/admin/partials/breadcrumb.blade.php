<p class="h3 mb-0 capitalize">@yield('title')</p>
<nav class="mt-2" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-sa-simple mb-0">
        <?php $segments = ''; ?>
        @foreach (request()->segments() as $segment)
            <?php $segments .= '/' . $segment; ?>
            <li class="breadcrumb-item  @if (request()->segment(count(request()->segments())) == $segment) active @endif">
                @php
                    $sg = !is_numeric($segment) ? translate(str_replace(['-', '_'], ' ', $segment)) : $segment;
                @endphp
                @if (request()->segment(count(request()->segments())) != $segment)
                    <a href="{{ url($segments) }}">
                        {{ $sg }}
                    </a>
                @else
                    {{ $sg }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
