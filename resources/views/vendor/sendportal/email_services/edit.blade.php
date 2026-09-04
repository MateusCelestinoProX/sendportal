@extends('sendportal::layouts.app')

@section('title', 'Resend API')

@section('heading')
    Resend API
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card" style="background: #000000; border: 1px solid #27272a; border-radius: 12px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.7);">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3 px-4" style="background: #09090b; border-bottom: 1px solid #27272a;">
                    <div class="d-flex align-items-center">
                        <span class="mr-3" style="background: #ffffff; color: #000000; width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.15rem;">
                            <i class="fas fa-key"></i>
                        </span>
                        <div>
                            <h5 class="mb-0 font-weight-bold" style="color: #ffffff; letter-spacing: 0.5px; font-size: 1.15rem;">
                                Resend API
                            </h5>
                        </div>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <span class="badge px-3 py-2" style="background: #052e16; color: #4ade80; border: 1px solid #166534; font-size: 0.78rem; font-weight: 700; border-radius: 6px;">
                            ● Provedor Ativo
                        </span>
                    </div>
                </div>

                <div class="card-body p-4" style="background: #000000;">
                    <form action="{{ route('sendportal.email_services.update', $emailService->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')

                        <!-- Nome da Instância / Serviço em Largura Total -->
                        <div class="row mb-4 p-3" style="background: #09090b; border: 1px solid #1f1f23; border-radius: 10px;">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="font-weight-bold mb-2" style="color: #ffffff; font-size: 0.88rem;">
                                    {{ __('Nome da Instância / Serviço') }}
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control" 
                                    value="{{ old('name', $emailService->name) }}" 
                                    style="background: #000000; color: #ffffff; border: 1px solid #27272a; height: 44px; border-radius: 8px; font-size: 0.92rem;" 
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold mb-2" style="color: #ffffff; font-size: 0.88rem;">
                                    {{ __('Provedor de Email') }}
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    value="⚡ {{ $emailServiceType->name }} (Provedor Principal Exclusivo)" 
                                    style="background: #18181b; color: #a1a1aa; border: 1px solid #27272a; height: 44px; border-radius: 8px; font-size: 0.92rem;" 
                                    disabled
                                >
                            </div>
                        </div>

                        <!-- Slots das Chaves de API no Espaço Amplo do Canvas -->
                        <div id="services-fields" class="w-100">
                            @include('sendportal::email_services.options.' . strtolower($emailServiceType->name), ['settings' => $emailService->settings])
                        </div>

                        <!-- Barra Inferior de Ações em Largura Total -->
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid #1f1f23;">
                            <a href="{{ route('sendportal.email_services.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-color: #27272a; color: #a1a1aa; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-arrow-left mr-2"></i>{{ __('Voltar') }}
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold" style="background: #ffffff !important; color: #000000 !important; border: none; border-radius: 8px; font-size: 0.95rem; letter-spacing: 0.5px; box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);">
                                <i class="fas fa-save mr-2"></i>{{ __('Atualizar Chaves de API') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
