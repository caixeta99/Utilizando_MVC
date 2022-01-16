<?php

class Posts extends Controller
{


    public function __construct()
    {
        if (!Sessao::estarlogado()) :
            URL::redirecionar('usuarios/login');
        endif;

        $this->postModel = $this->model('post');
        $this->usuarioModel = $this->model('Usuario');
    }


    public function index()
    {

        $dados = [
            'posts' => $this->postModel->lerPosts()
        ];
        $this->view('posts/index', $dados);
    }

    public function cadastrar()
    {

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $dados = [
                'titulo' => trim($formulario['titulo']),
                'texto' => trim($formulario['texto']),
                'titulo_erro' => '',
                'texto_erro' => '',
                'usuario_id' => $_SESSION['usuario_id'],
            ];



            if (in_array("", $formulario)) :

                if (empty($formulario['titulo'])) :
                    $dados['titulo_erro'] = 'Preencha o campo titulo';
                endif;

                if (empty($formulario['texto'])) :
                    $dados['texto_erro'] = 'Preencha o campo texto';
                endif;

            else :



                if ($this->postModel->armazenar($dados)) :
                    Sessao::mensagem('post', ' post cadastrado com sucesso');
                    URL::redirecionar('posts');
                else :
                    die("Erro ao armazenar o post no db no banco de dados");
                endif;

            endif;
        else :
            $dados = [
                'titulo' => '',
                'texto' => '',
                'titulo_erro' => '',
                'texto_erro' => '',
                'usuario_id' => $_SESSION['usuario_id'],
            ];

        endif;


        $this->view('posts/cadastrar', $dados);
    }

    public function editar($id)
    {

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $dados = [
                'id' => $id,
                'titulo' => trim($formulario['texto']),
                'texto' => trim($formulario['texto']),
                'titulo_erro' => '',
                'texto_erro' => '',

            ];



            if (in_array("", $formulario)) :

                if (empty($formulario['titulo'])) :
                    $dados['titulo_erro'] = 'Preencha o campo titulo';
                endif;

                if (empty($formulario['texto'])) :
                    $dados['texto_erro'] = 'Preencha o campo texto';
                endif;

            else :



                if ($this->postModel->atualizar($dados)) :
                    Sessao::mensagem('post', ' post Atualizado com sucesso');
                    URL::redirecionar('posts');
                else :
                    die("Erro ao atualizar o post no db no banco de dados");
                endif;

            endif;
        else :
            $post = $this->postModel->lerPostPorId($id);

            if ($post->usuario_id != $_SESSION['usuario_id']) :
                Sessao::mensagem('post', ' Voce nao tem altorização para editar esse  post', 'alert-danger');
                URL::redirecionar('posts');
            endif;


            $dados = [
                'id' => $post->id,
                'titulo' => $post->titulo,
                'texto' => $post->texto,
                'titulo_erro' => '',
                'texto_erro' => '',

            ];

        endif;


        $this->view('posts/editar', $dados);
    }

    public function ver($id)
    {
        $post = $this->postModel->lerPostPorId($id);

        if($post == null):
            Url::redirecionar('paginas/erro');
        endif;
       
        $usuario = $this->usuarioModel->lerUsuarioPorId($post->usuario_id);
        $dados = [
            'post' => $post,
            'usuario' => $usuario
        ];

        $this->view('posts/ver', $dados);
    }

    public function deletar($id)
    {


        if (!$this->checarAutorizacao($id)) :

            $id = filter_var($id, FILTER_VALIDATE_INT);

            $metodo = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

            if ($id && $metodo == 'POST') :

                if($this->postModel->destruir($id)):
                    Sessao::mensagem('post', ' Post deletado com sucesso', );
                    URL::redirecionar('posts');

                else:
                    Sessao::mensagem('post', ' Voce nao tem altorização para editar esse  post', 'alert-danger');
                    URL::redirecionar('posts');
                endif;

            
            endif;

            


        else :

            Sessao::mensagem('post', ' Voce nao tem altorização para editar esse  post', 'alert-danger');
            URL::redirecionar('posts');

        endif;

     
    }

    private function checarAutorizacao($id)
    {
        $post = $this->postModel->lerPostPorId($id);

        if ($post->usuario_id != $_SESSION['usuario_id']) :
            return true;
        else :
            return false;

        endif;
    }
}
