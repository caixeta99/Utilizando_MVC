<div class="container my-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?URL?>/posts">Posts</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $dados['post']->titulo ?></li>
        </ol>
    </nav>


    <div class="card text-center">
        <div class="card-header">
            <?= $dados['post']->titulo ?>

        </div>
        <div class="card-body ">
            <p class="card-text"><?= $dados['post']->texto ?></p>
        </div>
        <div class="card-footer text-muted">
            <small>
                Escrito por: <?= $dados['usuario']->nome ?> Em: <?= Checa::data($dados['post']->criado_em) ?>
            </small>
        </div>

        <?php if ($dados['post']->usuario_id == $_SESSION['usuario_id']) : ?>
            <ul class="list-inline">
                <li class="list-inline-item"> <a href="<?= URL . '/posts/editar/' . $dados['post']->id ?>" class="btn btn-sm btn-primary">Editar</a></li>
                <li class="list-inline-item"> 
                    <form method="POST" action="<?= URL . '/posts/deletar/' . $dados['post']->id ?>">
                        <input type="submit" class="btn btn-sm btn-danger" value="deletar">
                    </form>
                </li>
          
            </ul>


        <?php endif ?>


    </div>
</div>

</div>