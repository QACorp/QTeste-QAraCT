@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QTeste - Empresa | Alterar dados')
@section('content_header')
    <h1 class="m-0 text-dark">Configurações do QAra Caso de teste</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('caso-teste.qara.salvar-configuracao') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                        name="token"
                                        label="Token"
                                        placeholder="Token OPENAPI"
                                        fgroup-class="col-md-12"
                                        value="{{ old('valor',$token) }}"
                                        required
                                    />
                                </div>

                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('home') }}"
                                       class="btn btn-primary ml-1"
                                    ><i class="fas fa-undo"></i> Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-6 border-2 border-left pl-4">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

