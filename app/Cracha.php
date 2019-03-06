<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cracha extends Model
{

    private $template;
    private $logo;

    function __construct($template, $logo, $posLogo) {
        $this->addTemplate($template);
        $this->addLogo($logo, $posLogo);
    }

    //Método para salvar o crachá no servidor
    public function salvar($nome) {

        imagejpeg( $this->template, public_path().'/cracha/' . $nome, 80 );

    }

    //Cria a imagem de template e redimensiona ela para um tamanho padrão
    private function addTemplate($template) {

        $extension = $template->extension();

        if ($extension == 'png'){

            $this->template = imagecreatefrompng($template);

        }else {

            $this->template = imagecreatefromjpeg($template);

        }

        $altura = 525;
        $largura = 375;

        $largura_original = imagesx($this->template);
			
        $altura_original = imagesy($this->template);
        
        /**
         * Aqui é feito o redimensiaonamento da imagem sem perder a sua resolução.
         */
        $nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
        
        $nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
        
        $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
        
        imagecopyresampled($imagem_redimensionada, $this->template, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
        
        $this->template = $imagem_redimensionada;

    }

    /**
     * Adicionar a logo no template, caso não exista logo então não é feito nada
     * Caso exista, a logo é redimensionada para um tamanho pre-determinado, gerando um fundo preto que é removido,
     * depois ela é inserida no template de acordo com a posição que o usuário definiu
     */
    private function addLogo($logo, $posLogo) {

        if ($logo == NULL){
            return;
        }

        $extension = $logo->extension();

        if ($extension == 'png'){

            $this->logo = imagecreatefrompng($logo);

        }else if ($extension == 'gif') {

            $this->logo = imagecreatefromgif($logo);

        }
        else {

            $this->logo = imagecreatefromjpeg($logo);

        }

        $altura = 112.5;
        $largura = 112.5;

        $largura_original = imagesx($this->logo);
			
        $altura_original = imagesy($this->logo);
                
        $nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
        
        $nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
        
        $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
        imagecopyresampled($imagem_redimensionada, $this->logo, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
        $this->logo = $imagem_redimensionada;

        $planoFundo = imagecolorallocate($this->logo, 0,0,0);

        \imagecolortransparent($this->logo, $planoFundo);

        $largura_logo = imagesx($this->logo);

        $altura_logo = imagesy($this->logo);
        
        $pos = explode(",", $posLogo);

        $x_logo = $this->definirPosicao($largura_logo, $pos[0], imagesx($this->template));

        $y_logo = $this->definirPosicao($altura_logo, $pos[1], imagesy($this->template));

        imagecopymerge($this->template, $this->logo, $x_logo, $y_logo, 0, 0, $largura_logo, $altura_logo, 100);

    }

    /**
     * Definir a posição x/y de acordo com o que for escolhido pelo usuário
     */
    private function definirPosicao($medida, $percentural, $medidaTemplate){
        $res;
        if ($percentural < 0.5){
            $res = $percentural;
        }else if ($percentural > 0.5){
            $res = ( $medidaTemplate * $percentural ) - $medida;
        }else {
            $res =( $medidaTemplate * $percentural ) - ( $medida / 2 );
        }
        return $res;
    }

    /**
     * Inserir as informações do Participante no crachá, as opções de formatação selecionadas pelo usuário são aplicadas
     * e o sistema coloca os textos um abaixo do outro no crachá, de acordo com a posição que o usuário definiu
     */
    public function addInfo ($informacoes, $tags, $negrito, $italico, $tamanho, $posTexto) {

        $posY = $posTexto;
        $colunas = explode("\t", $informacoes);

        foreach ($tags as $i ) {
            
            $nome = urldecode( $colunas[$i] );
            $nome = $colunas[$i];

            $y = imagesy($this->template) * $posY;

            $posY += 0.1;

            $x = imagesx($this->template) * 0.10;

            //De acordo com a escolha, a fonte é escolhida
            if ($negrito AND $italico){
                $fonte = public_path().'/font/arial-negrito-italic.ttf';
            }else if ($negrito){
                $fonte = public_path().'/font/arial-bold.ttf';
            }else if ($italico){
                $fonte = public_path().'/font/arial-italic.ttf';
            }else {
                $fonte = public_path().'/font/arial.ttf';
            }

            $cor = imagecolorallocate( $this->template, 0, 0, 0 );

            imagettftext($this->template, $tamanho, 0, $x,$y,$cor,$fonte,$nome);

        }

    }

}
