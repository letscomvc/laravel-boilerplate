@if ( isset($breadcrumb) )
    <breadcrumb header="{{ $breadcrumb['title'] ?? null }}">
        @foreach ($breadcrumb['links'] ?? [] as $link)
            <breadcrumb-item
                    href='{{ $link['url'] ?? '#'}}'
                    {{ $loop->last ? 'active' : '' }} >
                {{ $link['title'] ?? '' }}
            </breadcrumb-item>
        @endforeach
    </breadcrumb>
@else
    @yield('breadcrumb')
@endif
