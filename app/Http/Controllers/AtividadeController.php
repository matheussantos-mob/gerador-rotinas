<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividade; // Importação do model Atividade

class AtividadeController extends Controller
{
    public function index()
    {
        $atividades = Atividade::all();
        return view('atividades.index', compact('atividades'));
    }

    public function create()
    {
        return view('atividades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
        ]);

        Atividade::create($request->all());

        return redirect()->route('atividades.index')->with('success', 'Atividade criada com sucesso!');
    }

    public function gerarRotina()
    {
        // Recupera todas as atividades cadastradas
        $atividades = Atividade::all();

        // Define o horário de início do dia (ex: 07:00)
        $horarioInicio = '07:00';

        // Gera a rotina
        $rotina = $this->organizarRotina($atividades, $horarioInicio);

        return view('rotina.index', compact('rotina'));
    }

    private function organizarRotina($atividades, $horarioInicio)
    {
        $rotina = [];
        $horarioAtual = strtotime($horarioInicio);

        foreach ($atividades as $atividade) {
            // Adiciona a atividade ao cronograma
            $rotina[] = [
                'nome' => $atividade->nome,
                'duracao' => $atividade->duracao,
                'horario' => date('H:i', $horarioAtual),
            ];

            // Avança o horário atual com base na duração da atividade
            $horarioAtual = strtotime("+{$atividade->duracao} minutes", $horarioAtual);
        }

        return $rotina;
    }

        public function edit($id)
    {
        // Recupera a atividade pelo ID
        $atividade = Atividade::findOrFail($id);

        // Retorna a view de edição com os dados da atividade
        return view('atividades.edit', compact('atividade'));
    }

    public function update(Request $request, $id)
    {
        // Valida os dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
        ]);

        // Recupera a atividade pelo ID
        $atividade = Atividade::findOrFail($id);

        // Atualiza os dados da atividade
        $atividade->update($request->all());

        // Redireciona para a lista de atividades com uma mensagem de sucesso
        return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        // Recupera a atividade pelo ID
        $atividade = Atividade::findOrFail($id);

        // Exclui a atividade
        $atividade->delete();

        // Redireciona para a lista de atividades com uma mensagem de sucesso
        return redirect()->route('atividades.index')->with('success', 'Atividade excluída com sucesso!');
    }
}