<div id="flash-messages-container" v-if="!handled_flash_messages">
    @foreach (['success', 'error', 'warning', 'info'] as $flashType)
        @if(session()->has($flashType))
            @foreach(session($flashType) as $message)
                <span class="{{ $flashType }}">{{ $message }}</span>
            @endforeach
        @endif
    @endforeach
</div>
