@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2>Rotina Diária</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Atividade</th>
                    <th>Duração (minutos)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rotina as $item)
                    <tr>
                        <td>{{ $item['horario'] }}</td>
                        <td>{{ $item['nome'] }}</td>
                        <td>{{ $item['duracao'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('atividades.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
@endsection