<div id="flash-messages-container" v-show="false" v-if="!handledFlashMessages">
    @foreach (['success', 'error', 'warning', 'info'] as $flashType)
        @if(session()->has($flashType))
            @foreach(session($flashType) as $message)
                <span class="{{ $flashType }}">{{ $message }}</span>
            @endforeach
        @endif
    @endforeach
</div>
