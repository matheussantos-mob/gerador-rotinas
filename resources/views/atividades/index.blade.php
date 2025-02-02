@extends('layouts.app')

@section('content')
    <div class="container my-5">
        
        <div class="text-center mb-4">
            <h2 id="relogio"></h2>
        </div>

        <h2>Lista de Atividades</h2>
        <a href="{{ route('atividades.create') }}" class="btn btn-primary mb-3">Nova Atividade</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Duração (minutos)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atividades as $atividade)
                    <tr>
                        <td>{{ $atividade->nome }}</td>
                        <td>{{ $atividade->duracao }}</td>
                        <td>
                            <a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('atividades.destroy', $atividade->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta atividade?')">Excluir</button>
                            </form>
                            <button class="btn btn-sm btn-success btn-timer" data-duracao="{{ $atividade->duracao }}" data-id="{{ $atividade->id }}">Iniciar</button>
                            <span id="contagem-{{ $atividade->id }}" class="ml-2"></span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
    <script>
        function atualizarRelogio() {
            const relogioElemento = document.getElementById('relogio');
            const agora = new Date();

            
            const opcoes = {
                weekday: 'short', // Nome completo do dia da semana
                year: 'numeric', // Ano completo
                month: 'short', // Nome completo do mês
                day: 'numeric', // Dia do mês
                hour: '2-digit', // Hora (2 dígitos)
                minute: '2-digit', // Minuto (2 dígitos)
                second: '2-digit', // Segundo (2 dígitos)
                timeZoneName: 'short' // Nome do fuso horário (abreviado)
            };

           
            relogioElemento.textContent = agora.toLocaleString('pt-BR', opcoes);
        }

        
        setInterval(atualizarRelogio, 1000);

        
        atualizarRelogio();
    </script>

    <script>
        document.querySelectorAll('.btn-timer').forEach(botao => {
            let intervalo = null; // armazena o intervalo do timer
            let tempoRestante = null; //armazena o tempo restante
            let emExecucao = false; //(em execução ou pausado)

            botao.addEventListener('click', function() {
                const duracao = parseInt(this.getAttribute('data-duracao')); // Duração em minutos
                const atividadeId = this.getAttribute('data-id'); // ID da atividade
                const contagemElemento = document.getElementById(`contagem-${atividadeId}`);

                if (!emExecucao) {
                    
                    if (tempoRestante === null) {
                        tempoRestante = duracao * 60; // Converte minutos para segundos (inicia do início)
                    }
                    
                    this.textContent = 'Pausar';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-warning');

                    intervalo = setInterval(() => {
                        const minutos = Math.floor(tempoRestante / 60);
                        const segundos = tempoRestante % 60;


                        contagemElemento.textContent = `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;


                        if (tempoRestante <= 0) {
                            clearInterval(intervalo);
                            contagemElemento.textContent = 'Concluído!';
                            this.textContent = 'Iniciar';
                            this.classList.remove('btn-warning');
                            this.classList.add('btn-success');
                            this.disabled = true; // Desabilita o botão após a conclusão
                            tempoRestante = null; // Reseta o tempo restante
                            emExecucao = false; // Reseta o estado do timer
                        } else {
                            tempoRestante--; // Decrementa o tempo restante
                        }
                    }, 1000); 

                    emExecucao = true; 
                } else {
                    
                    clearInterval(intervalo); //Pausa
                    this.textContent = 'Continuar'; //altera o botão para "Continuar"
                    this.classList.remove('btn-warning');
                    this.classList.add('btn-success');
                    emExecucao = false; //pausado
                }
            });
        });
    </script>
@endsection