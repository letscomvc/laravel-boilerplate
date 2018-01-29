@if ($errors->has($field))
    <span class="error-block">
        <span>{{ $errors->first($field) }}</span>
    </span>
@endif
