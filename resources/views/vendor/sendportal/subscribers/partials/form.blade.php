<x-sendportal.text-field name="email" :label="__('Email')" type="email" :value="$subscriber->email ?? null" />
<x-sendportal.text-field name="first_name" :label="__('First Name')" :value="$subscriber->first_name ?? null" />
<x-sendportal.text-field name="last_name" :label="__('Last Name')" :value="$subscriber->last_name ?? null" />
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right font-weight-bold" style="color: #ffffff !important;">
        {{ __('Tags') }}
    </label>
    <div class="col-md-8">
        <div class="d-flex align-items-center justify-content-between p-2 mb-2" style="background: #09090b; border: 1px solid #27272a; border-radius: 6px;">
            <div class="small">
                <i class="fas fa-tags mr-1" style="color: #ffffff;"></i>
                <span class="text-white font-weight-bold">{{ __('Gerenciador de Etiquetas') }}</span>
                <span class="badge badge-secondary ml-1" style="background: #18181b; color: #ffffff; border: 1px solid #27272a;">{{ count($tags) }} {{ __('disponíveis') }}</span>
            </div>
            <div>
                <a href="{{ route('sendportal.tags.index') }}" target="_blank" class="btn btn-xs btn-light mr-1" style="background: #18181b; color: #ffffff; border: 1px solid #3f3f46; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-cog mr-1"></i> {{ __('Gerenciar') }}
                </a>
                <a href="{{ route('sendportal.tags.create') }}" target="_blank" class="btn btn-xs btn-primary" style="background: #ffffff; color: #000000; font-weight: 700; font-size: 0.75rem;">
                    <i class="fas fa-plus mr-1"></i> {{ __('Criar Nova') }}
                </a>
            </div>
        </div>

        <select name="tags[]" id="id-field-tags" class="form-control selectpicker" multiple data-none-selected-text="{{ __('Nenhuma etiqueta selecionada') }}" data-selected-text-format="count > 2" data-live-search="true" data-style="btn-dark" style="background: #000000; color: #ffffff; border: 1px solid #27272a;">
            @foreach($tags as $key => $text)
                <option value="{{ $key }}" {{ in_array($key, array_keys($selectedTags->toArray())) ? 'selected' : '' }}>{{ $text }}</option>
            @endforeach
        </select>
    </div>
</div>

<x-sendportal.checkbox-field name="subscribed" :label="__('Subscribed')" :checked="empty($subscriber->unsubscribed_at)" />

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/css/bootstrap-select.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    </script>
@endpush
