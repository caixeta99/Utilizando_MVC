<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function lerPosts()
    {
        $this->db->query("SELECT * ,
        post.id as postID,
        post.criado_em as postDataCadastro,
        usuarios.id as usuariosID,
        usuarios.criado_em as usuarioDataCadastro FROM post
        INNER JOIN usuarios on 
        post.usuario_id = usuarios.id
        ORDER BY post.id desc
        ");
        return $this->db->resultados();
    }

    public function lerPostPorId($id){

        $this->db->query("SELECT * FROM post WHERE id= :id");
        $this->db->bind("id",$id);
        return $this->db->resultado();
    }

    public function armazenar($dados)
    {
        $this->db->query("INSERT INTO post(usuario_id, titulo, texto) VALUES (:usuario_id, :titulo, :texto)");

        $this->db->bind("usuario_id", $dados['usuario_id']);
        $this->db->bind("titulo", $dados['titulo']);
        $this->db->bind("texto", $dados['texto']);


        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    public function atualizar($dados)
    {
        $this->db->query("UPDATE post SET titulo = :titulo , texto = :texto WHERE id = :id");
        
        $this->db->bind("titulo", $dados['titulo']);
        $this->db->bind("texto", $dados['texto']);
        $this->db->bind("id", $dados['id']);
     



        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    public function destruir($id)
    {
        $this->db->query("DELETE FROM post  WHERE id = :id");
        
        $this->db->bind("id", $id);
      
    
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }



   
}
