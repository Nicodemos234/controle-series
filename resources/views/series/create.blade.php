@extends('layout')

@section('cabecalho')
    Adicionar Série
@endsection

@section('conteudo')
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" class="nome" name="nome" id="nome">
        </div>
        <button class="btn btn-primary">Adicionar</button>
    </form>
@endsection
