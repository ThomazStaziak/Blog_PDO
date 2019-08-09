<?php
    require 'req/validaSessao.php';
    
    try {
        require 'req/conexao.php';

        $consulta = $conexao->query("SELECT id, titulo FROM noticias");

        $noticias = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $conexao = null;
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }

    include 'layouts/head.php';
    include 'layouts/header_admin.php';
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 90vh">
    <ul class="list-group col-8">
        <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #e8e8e8">
            <span>Suas Notícias</span>
            <a href="inserir.php" class="btn btn-success">Adicionar Notícia</a>
        </li>
        <?php foreach($noticias as $noticia) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= $noticia["titulo"] ?></span>
                <div>
                    <a href="atualizar.php?id=<?= $noticia["id"] ?>">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="deletar.php?id=<?= $noticia["id"] ?>" class="d-inline-block ml-3">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


<?php include 'layouts/footer.php' ?>