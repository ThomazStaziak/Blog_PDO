<?php 
    if ($_POST) {
        try {
            require 'req/conexao.php';

            $consulta = $conexao->prepare("SELECT * FROM escritores WHERE email = :emailPost AND senha = :senhaPost");
            $consulta->execute([
                ':emailPost' => $_POST["email"],
                ':senhaPost' => $_POST["senha"]
            ]);
            
            $escritor = $consulta->fetch(PDO::FETCH_ASSOC);

            $conexao = null;
            
            if (count($escritor) > 0) {
                session_start();
                $_SESSION["usuario"] = $escritor;

                header("Location: inserir.php");
            }
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    include 'layouts/head.php';
    include 'layouts/header.php';
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 90vh">
    <div class="col-8 border rounded p-4" style="background-color: #f8f8f8">
        <form action="" method="POST">
            <div class="form-group">
                <label for="emailInput">Email</label>
                <input id="emailInput" type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="senhaInput">Senha</label>
                <input id="senhaInput" type="password" name="senha" class="form-control">
            </div>
            <button type="submit" class="btn btn-secondary col-12 mt-3">Entrar</button>
        </form>
    </div>
</div>

<?php include 'layouts/footer.php' ?>