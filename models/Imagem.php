<?php

class Imagem 
{
    public function moverParaPasta($imagem) {
        $pasta = "./views/Img/ImgUsuario/";
        $extensaoImagem = strtolower (pathinfo($imagem['name'], PATHINFO_EXTENSION));

        // Trocar o nome da Imagem e colocar um nome unico
        $novoNomeDaImagem = uniqid() . '.' . $extensaoImagem;

        $caminhoCompleto = $pasta . $novoNomeDaImagem;

        // Mover a imagem para a pasta de destino (Views, Img, ImgUsuario)
        if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
            $caminhoImg = "." . $pasta . $novoNomeDaImagem;
            return $caminhoImg; 
        } else {
            return false; 
        }
    }

    public function validarImagem($imagem) {
        $statusDaValidacao = "aceito";
        $extensaoImagem = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    
        if (!in_array($extensaoImagem, ['jpg', 'png'])) {
            return "Tipo de arquivo não aceito, apenas imagens em jpg e png são aceitas.";
        }
    
        if (preg_match("/[_\/\-]/", $imagem['name'])) {
            return "O nome da imagem não pode conter caracteres especiais como '_', '/' ou '-'.";
        }
    
        return $statusDaValidacao;
    }

    public function excluirImagem($caminho) 
    {
        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }
}
?>