<div id="flash-messages-container" v-if="!handled_flash_messages">
    @foreach (['success', 'error', 'warning', 'info'] as $flashType)
        @if(isset(${$flashType}))
            <span class="{{$flashType}}">{{ ${$flashType} }}</span>
        @endif
    @endforeach
</div>
