<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cracha;

class CrachaController extends Controller
{
    public function createCracha(Request $request){

        $request->validate([

            ('template') => 'required|mimes:jpeg,png',
            'tamanho' => 'integer|min:1',
            ('logo') => 'mimetypes:image/gif',

        ]);

        $dados = explode("\n", $request->tabela);

        $cabecalho = explode("\t", $dados[0]);

        unset($dados[0]);

        $tags = explode(",", $request->tags);

        $posicoes = [];
        foreach ($tags as $tag ) {
            if (!$this->validarTag($cabecalho, $tag, $posicoes)){
                return redirect('/')->with('warning', 'A tag ' . $tag . ' não existe na tabela');
            }
        }

        $i = 0;
        $crachas = [];
        foreach ($dados as $participante ) {
            $cracha = new Cracha($request->template, $request->logo, $participante, $posicoes, $request->negrito, $request->italico, $request->tamanho);
            $nome = ('cracha' . $i);
            $cracha->salvar($nome);
            $i++;
            array_push($crachas, public_path().'/cracha/' . $nome);
        }

        $pdf = \PDF::loadView('index.cracha', compact('crachas'));

        return $pdf->download('cracha.pdf');

    }

    public function validarTag($cabecalho, $tag, &$posicoes) {
        $res = false;
        $tag = trim(mb_strtolower($tag));
        $i = 0;
        foreach ($cabecalho as $nome ) {
            if (trim(mb_strtolower($nome)) == $tag){
                $res = true;
                array_push($posicoes, $i);
                break;
            }
            $i++;
        }
        return $res;
    }
}
