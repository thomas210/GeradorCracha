<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cracha extends Model
{

    private $template;
    private $logo;

    function __construct($template, $logo, $informacoes, $tags, $negrito, $italico, $tamanho) {
        $this->addTemplate($template);
        $this->addLogo($logo);
        $this->addInfo($informacoes, $tags, $negrito, $italico, $tamanho);
    }

    public function salvar($nome) {

        imagejpeg( $this->template, public_path().'/cracha/' . $nome, 80 );

    }

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
                
        $nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
        
        $nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
        
        $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
        imagecopyresampled($imagem_redimensionada, $this->template, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
        $this->template = $imagem_redimensionada;

    }

    private function addLogo($logo) {

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

        $x_logo =( imagesx($this->template) / 2 ) - ( $largura_logo / 2 );

        $y_logo = 30;
        
        imagecopymerge($this->template, $this->logo, $x_logo, $y_logo, 0, 0, $largura_logo, $altura_logo, 100);

    }

    private function addInfo ($informacoes, $tags, $negrito, $italico, $tamanho) {

        $posY = 0.4;
        $colunas = explode("\t", $informacoes);

        foreach ($tags as $i ) {
            
            $nome = urldecode( $colunas[$i] );
            $nome = $colunas[$i];
            //dd($nome);

            $y = imagesy($this->template) * $posY;

            $posY += 0.1;

            $x = imagesx($this->template) * 0.10;

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
