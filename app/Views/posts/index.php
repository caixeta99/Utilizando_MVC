<div class="container py-5">

    <?= Sessao::mensagem('post') ?>
    <div class="card ">
        <div class="card-header">
            postagens
            <div class="float-right">
                <a href="<?= URL ?>/posts/cadastrar" class="btn btn-primary">
                    Escrever
                </a>
            </div>
        </div>
        <div class="card-body ">

            <?php foreach ($dados['posts'] as $post) : ?>

                <div class="card my-5">
                    <h5 class="card-header"><?= $post->titulo ?></h5>
                    <div class="card-body">
    
                        <p class="card-text"><?= $post->texto ?></p>
                        <p class="card-text">criado por <?= $post->nome ?> em <?= Checa::data($post->postDataCadastro)  ?></p>
                        <a href="<?=URL.'/posts/ver/'.$post->postID?>" class="btn btn-primary float-right">Ler mais</a>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</div>