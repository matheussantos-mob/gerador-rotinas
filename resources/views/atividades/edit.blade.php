@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2>Editar Atividade</h2>
        <form action="{{ route('atividades.update', $atividade->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Atividade</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $atividade->nome }}" required>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração (minutos)</label>
                <input type="number" class="form-control" id="duracao" name="duracao" value="{{ $atividade->duracao }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('atividades.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection