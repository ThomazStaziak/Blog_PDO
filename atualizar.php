<?php
    require 'req/validaSessao.php';
    require 'req/validaUrl.php';

    if ($_POST) {
        try {
            require 'req/conexao.php';
            
            if (empty($_FILES["imagem"]["name"])) {
                $url_imagem = 'img/blog/default.jpg';
            } else if ($_FILES["imagem"]["error"] === 0) {
                $nomeArquivo = $_FILES["imagem"]["name"];
                $nomeTemp = $_FILES["imagem"]["tmp_name"];
                $url_imagem = "img/blog/" . $nomeArquivo;
        
                move_uploaded_file($nomeTemp, "./" . $url_imagem);
            }

            $consulta = $conexao->prepare("UPDATE noticias SET titulo = :titulo, descricao = :descricao, categoria = :categoria, url_imagem = :url_imagem, data_criacao = :data_criacao");
            $atualizou = $consulta->execute([
                ':titulo' => $_POST["titulo"],
                ':descricao' => $_POST["descricao"],
                ':categoria' => $_POST["categoria"],
                ':url_imagem' => $url_imagem,
                ':data_criacao' => date('Y-m-d'),
            ]);
            
            $conexao = null;
    
            if ($atualizou) {
                header("Location: painel_admin.php");
            } 
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
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
                <input id="tituloInput" type="text" name="titulo" class="form-control" value="<?= $noticia["titulo"] ?>">
            </div>
            <div class="form-group">
                <label for="descricaoInput">Descriçāo</label>
                <textarea name="descricao" id="descricaoInput" cols="30" rows="10" class="form-control"><?= $noticia["descricao"] ?></textarea>
            </div>
            <div class="form-group">
                <select name="categoria" id="categoriaInput" class="form-control">
                    <option disabled selected>Escolha uma categoria</option>
                    <option <?php if($noticia["categoria"] == "Moda") { echo 'selected'; } ?> value="Moda">Moda</option>
                    <option <?php if($noticia["categoria"] == "Lazer") { echo 'selected'; } ?> value="Lazer">Lazer</option>
                    <option <?php if($noticia["categoria"] == "Saúde") { echo 'selected'; } ?> value="Saúde">Saúde</option>
                    <option <?php if($noticia["categoria"] == "Esporte") { echo 'selected'; } ?> value="Esporte">Esporte</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="imagemInput" class="btn btn-secondary col-12">Imagem de capa</label>
                <input type="file" name="imagem" id="imagemInput" class="d-none">
            </div>

            <input type="hidden" name="id_escritor" value="<?= $_SESSION["usuario"]["id"] ?>">
            <button type="submit" class="btn btn-warning col-12 mt-2">Editar</button>
        </form>
    </div>
</div>

<?php include 'layouts/footer.php' ?>