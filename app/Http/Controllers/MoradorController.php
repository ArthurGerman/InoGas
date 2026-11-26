<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Contas de morador. Só o responsável cria, edita, redefine o acesso, desativa e reativa
 * os moradores que ele mesmo criou. Desativar nunca apaga a conta (para manter o histórico).
 */
class MoradorController extends Controller
{
    private function meuId(): int
    {
        return (int) session('usuario_id');
    }

    /** Garante que o morador pertence ao responsável logado. */
    private function meu(Usuario $morador): void
    {
        abort_unless($morador->papel === 'morador' && (int) $morador->responsavel_id === $this->meuId(), 404);
    }

    /** Senha temporária legível (sem letras e números que se confundem, como 0/O e 1/l/I). */
    private function senhaTemporaria(): string
    {
        $alfabeto = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $senha = '';

        for ($i = 0; $i < 10; $i++) {
            $senha .= $alfabeto[random_int(0, strlen($alfabeto) - 1)];
        }

        return $senha;
    }

    /** Devolve os ids recebidos, desde que todos sejam locais do responsável; senão null. */
    private function locaisValidos(array $ids): ?array
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));

        $meus = Local::where('responsavel_id', $this->meuId())->whereIn('id', $ids)->pluck('id')->all();

        return count($meus) === count($ids) ? $ids : null;
    }

    public function criar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'locais' => 'nullable|array',
            'locais.*' => 'integer',
        ]);

        $locais = $this->locaisValidos($dados['locais'] ?? []);

        if ($locais === null) {
            return response()->json(['erro' => 'Escolha só locais que são seus.'], 422);
        }

        $senha = $this->senhaTemporaria();

        $morador = DB::transaction(function () use ($dados, $locais, $senha) {
            $novo = new Usuario([
                'name' => $dados['name'],
                'email' => $dados['email'],
                'password' => Hash::make($senha),
            ]);
            $novo->papel = 'morador';
            $novo->responsavel_id = $this->meuId();
            $novo->ativo = true;
            $novo->precisa_trocar_senha = true;
            $novo->save();
            $novo->locais()->sync($locais);

            return $novo;
        });

        return response()->json([
            'mensagem' => 'Conta de morador criada.',
            'id' => $morador->id,
            'senha_temporaria' => $senha,
        ]);
    }

    public function atualizar(Request $request, Usuario $morador): JsonResponse
    {
        $this->meu($morador);

        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($morador->id)],
            'locais' => 'nullable|array',
            'locais.*' => 'integer',
        ]);

        $locais = $this->locaisValidos($dados['locais'] ?? []);

        if ($locais === null) {
            return response()->json(['erro' => 'Escolha só locais que são seus.'], 422);
        }

        DB::transaction(function () use ($morador, $dados, $locais) {
            $morador->update(['name' => $dados['name'], 'email' => $dados['email']]);
            $morador->locais()->sync($locais);
        });

        return response()->json(['mensagem' => 'Morador salvo.']);
    }

    /** Gera uma senha temporária nova. A senha antiga deixa de valer e o morador precisa trocá-la ao entrar. */
    public function redefinirAcesso(Usuario $morador): JsonResponse
    {
        $this->meu($morador);

        $senha = $this->senhaTemporaria();
        $morador->password = Hash::make($senha);
        $morador->precisa_trocar_senha = true;
        $morador->save();

        return response()->json([
            'mensagem' => 'Acesso redefinido.',
            'senha_temporaria' => $senha,
        ]);
    }

    public function ativo(Request $request, Usuario $morador): JsonResponse
    {
        $this->meu($morador);

        $dados = $request->validate(['ativo' => 'required|boolean']);
        $morador->ativo = (bool) $dados['ativo'];
        $morador->save();

        return response()->json(['mensagem' => $morador->ativo ? 'Morador reativado.' : 'Morador desativado.']);
    }
}
