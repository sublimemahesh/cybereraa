<div>
    <div wire:ignore>
        @if (isset($attributes['multiple']))
            <div id="{{ $attributes['id'] }}-btn-container" class="mb-3">
                <button type="button" class="btn btn-info btn-xs select-all-button">SELECT ALL</button>
                <button type="button" class="btn btn-info btn-xs deselect-all-button">DESELECT ALL</button>
            </div>
        @endif
        <select data-placeholder="{{ __('Select your option') }}" {{ $attributes->merge(['class' => 'single-select-placeholder js-states select2-hidden-accessible']) }}>
            @if (!isset($attributes['multiple']))
                <option></option>
            @endif
            @foreach ($options as $key => $value)
                <option data-value="{{ $key }}" value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@push('scripts')
    <script>
        const el = $('#{{ $attributes['id'] }}')
        const buttonsId = '#{{ $attributes['id'] }}-btn-container'

        const initButtons = function () {
            $(buttonsId + ' .select-all-button').click(function (e) {
                el.val(_.map(el.find('option'), opt => $(opt).attr('value')))
                el.trigger('change')
            })

            $(buttonsId + ' .deselect-all-button').click(function (e) {
                el.val([])
                el.trigger('change')
            })
        }

        const initSelect = function () {
            initButtons()
            let _initEl = $('#{{ $attributes['id'] }}');
            _initEl.select2({
                placeholder: '{{ __('Select your option') }}',
                allowClear: !_initEl.attr('required')
            })
        }

        Livewire.on("{{ $attributes['id'] }}", (options) => {
            console.log('livewire on')
            let el = $('#{{ $attributes['id'] }}')
            $(el).empty()
            for (const key in options) {
                if (options.hasOwnProperty(key)) {
                    $(el).append(`<option value="${key}">${options[key]}</option>`)
                }
            }
        })
        document.addEventListener("DOMContentLoaded", () => {

            initSelect()

            Livewire.hook('message.processed', (message, component) => {
                initSelect()
            });

            el.on('change', function (e) {
                let data = $(this).select2("val")
                if (data === "") {
                    data = null
                }
                @this.
                set('{{ $attributes['wire:model'] }}', data)
            });
        });
    </script>
@endpush
