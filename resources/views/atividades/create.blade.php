@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2>Criar Nova Atividade</h2>
        <form action="{{ route('atividades.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Atividade</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração (minutos)</label>
                <input type="number" class="form-control" id="duracao" name="duracao" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>            
            <a href="{{ route('atividades.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection