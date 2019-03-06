<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cracha;

class CrachaController extends Controller
{
    /**
     * Método onde é criado o crachá de acordo com as opções do usuário
     */
    public function createCracha(Request $request){

        //validação para conferir se os tipos dos arquivos são compativeís
        //também é conferido se o tamanho da fonte do texto é válido
        $request->validate([

            ('template') => 'required|mimes:jpeg,png',
            'tamanho' => 'integer|min:1',
            ('logo') => 'mimetypes:image/gif',

        ]);

        //Separar os dados da tabela e retirar o cabecalho
        $dados = explode("\n", $request->tabela);

        $cabecalho = explode("\t", $dados[0]);

        unset($dados[0]);

        //Separar as tags
        $tags = explode(",", $request->tags);

        /**
         * conferir se as tags batem com o cabecalho da tabela, é testada uma opr uma, caso
         * alguma tag não exista no cabecalho então é retornada para a página inicial com a mensagem de erro
         */
        $posicoes = [];
        foreach ($tags as $tag ) {
            if (!$this->validarTag($cabecalho, $tag, $posicoes)){
                return redirect('/')->with('warning', 'A tag ' . $tag . ' não existe na tabela');
            }
        }

        /**
         * Aqui os crachás são gerados, um por um, por participante, eles são salvos no servidor para serem depois convertidos em pdf.
         * Se novos crachás forem adicionados posteriormente, os antigos são sobreescritos.
         * Por fim, o caminho dos crachás são armazenados num array para depois serem convertidos em PDF.
         */
        $i = 0;
        $crachas = [];
        foreach ($dados as $participante ) {
            $cracha = new Cracha($request->template, $request->logo, $request->posLogo);
            $cracha->addInfo($participante, $posicoes, $request->negrito, $request->italico, $request->tamanho, $request->posTexto);
            $nome = ('cracha' . $i);
            $cracha->salvar($nome);
            $i++;
            array_push($crachas, public_path().'/cracha/' . $nome);
        }

        //Os crachas são enviados para um view que será convertida em PDF e depois é baixada no computador
        $pdf = \PDF::loadView('index.cracha', compact('crachas'));

        return $pdf->download('cracha.pdf');

    }

    /**
     * Função para validar a tag. Se a tag estiver no cabeçalho, então sua posição é registrada 
     * para ser usada posteriormente
     */
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
