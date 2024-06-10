@extends('adminlte::page')

@section('title', 'QAKit - Projetos')
@section('plugins.Select2', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">QAra</h1>
        <div class="text-right col-md-4">

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="alert alert-default-warning">
                        <i class="fas fa-robot"></i>
                        Seja bem-vindo(a) a QAra! Aqui você pode utilizar a IA do QAKit para gerar casos de testes baseado
                        em um documento com os requisitos do projeto.
                    </div>
                    <form action="{{ route('caso-teste.qara.gerar-texto') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="alert alert-primary">
                                        <i class="fas fa-robot"></i>
                                        Primeiro selecione a aplicação, pois será com base nela que serão gerados os casos de teste.
                                    </div>
                                    <x-adminlte-select2
                                        name="idAplicacao"
                                        class="col-md-12"
                                        label="Aplicação"
                                        onchange="window.location.href = this.value != '' ? '{{ route('caso-teste.qara.index') }}?idAplicacao=' + this.value : '{{ route('caso-teste.qara.index') }}'"
                                    >
                                        <option value="">Selecione uma aplicação</option>
                                        @foreach($aplicacoes as $aplicacao)
                                            <option {{ $aplicacao->id == $idAplicacao ? 'selected':'' }} value="{{ $aplicacao->id }}">{{ $aplicacao->nome }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            @if($idAplicacao)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="alert alert-primary">
                                            <i class="fas fa-robot"></i>
                                            Agora selecione o projeto, caso não deseje informar deixe em branco.
                                        </div>

                                        <x-adminlte-select2
                                            name="idProjeto"
                                            class="col-md-12"
                                            label="Projeto"
                                        >
                                            <option value="">Selecione um projeto</option>
                                            @foreach($projetos as $projeto)
                                                <option {{ $projeto->id == $idProjeto ? 'selected':'' }} value="{{ $projeto->id }}">{{ $projeto->nome }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="alert alert-primary">
                                        <i class="fas fa-robot"></i>
                                        Agora informe os requisitos para o qual quer criar os casos de testes.
                                    </div>

                                    <x-adminlte-textarea name="requisitos" label="Requisitos" rows="15"></x-adminlte-textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg w-100">Gerar Casos de Teste</button>
                                </div>
                            </div>
                        @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
