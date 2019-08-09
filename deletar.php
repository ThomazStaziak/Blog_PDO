<?php
    require 'req/validaSessao.php';
    require 'req/validaUrl.php';

    if ($_POST) {
        require 'req/conexao.php';

        $consulta = $conexao->prepare("DELETE FROM noticias WHERE id = :id");
        $deletou = $consulta->execute([
            ':id' => $_POST["id_noticia"]
        ]);

        if ($deletou) {
            header("Location: painel_admin.php");
        }

        $conexao = null;
    }

    try {
        require 'req/conexao.php';

        $consulta = $conexao->prepare("SELECT * FROM noticias WHERE id = :id");
        $consulta->execute([
            ':id' => $_GET["id"]
        ]);
        
        $noticia = $consulta->fetch(PDO::FETCH_ASSOC);
        
        $conexao = null;
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }

    include 'layouts/head.php';
    include 'layouts/header_admin.php';
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 90vh">
    <div class="col-8 border rounded p-4" style="background-color: #f8f8f8">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tituloInput">Titulo</label>
                <input readonly id="tituloInput" type="text" name="titulo" class="form-control" value="<?= $noticia["titulo"] ?>">
            </div>
            <div class="form-group">
                <label for="descricaoInput">Descriçāo</label>
                <textarea readonly name="descricao" id="descricaoInput" cols="30" rows="10" class="form-control"><?= $noticia["descricao"] ?></textarea>
            </div>
            <div class="form-group">
                <select name="categoria" id="categoriaInput" class="form-control">
                    <option disabled selected>Escolha uma categoria</option>
                    <option disabled  <?php if($noticia["categoria"] == "Moda") { echo 'selected'; } ?> value="Moda">Moda</option>
                    <option disabled <?php if($noticia["categoria"] == "Lazer") { echo 'selected'; } ?> value="Lazer">Lazer</option>
                    <option disabled <?php if($noticia["categoria"] == "Saúde") { echo 'selected'; } ?> value="Saúde">Saúde</option>
                    <option disabled <?php if($noticia["categoria"] == "Esporte") { echo 'selected'; } ?> value="Esporte">Esporte</option>
                </select>
            </div>

            <input type="hidden" name="id_noticia" value="<?= $noticia["id"] ?>">
            <div class="row d-flex justify-content-around">
                <a href="painel_admin.php" class="col-4 mt-2 btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-danger col-7 mt-2">Deletar</button>
            </div>
        </form>
    </div>
</div>

<?php include 'layouts/footer.php' ?>