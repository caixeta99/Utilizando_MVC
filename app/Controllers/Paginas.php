<?php

class Paginas extends Controller {

    public function index(){
        $dados = [
            'tituloPagina' => 'Página Inicial'
        ];

        $this->view('paginas/home', $dados);

        if (Sessao::estarlogado()) :
            URL::redirecionar('posts/');
        endif;


    }

    
    

    public function sobre(){
        $dados = [
            'tituloPagina' => APP_NOME
        ];

        $this->view('paginas/sobre', $dados);
    }

    
    public function erro(){
        $dados = [
            'tituloPagina' => 'Erro - Pagina nao encontrada'
        ];

        $this->view('paginas/erro', $dados);
    }
    
}