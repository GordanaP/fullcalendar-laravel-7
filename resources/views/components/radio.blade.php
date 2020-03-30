<div>
    @foreach ($radio->inputs as $radio_value => $attributes)
        <div class="form-check">
            <input class="form-check-input" type="radio"
            name="{{ $radio->name }}"
            id="{{ $attributes['id'] }}"
            value="{{ $radio_value }}"
            {{ checked($radio_value, $radio->checked) }} />

            <label class="form-check-label" for="{{ $attributes['id'] }}">
                {{ $attributes['label'] }}
            </label>
        </div>
    @endforeach
</div>