<?php
include("../departamentos/departamentoController.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Adicionar Departamento</title>
</head>

<?php
$result = false;
$error = false;

if ($_POST) {
//     try {

        $nome = $_POST["nome"];
        $responsabilidade = $_POST["responsabilidade"];

        $controller = new DepartamentoController();

        $controller->inserir($nome, $responsabilidade);
}
?>

<body>

    <?php
        readFile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">

        <?php if ($_POST && (!$result || $error)) : ?>
            <p>
                Erro ao salvar o novo departamento.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Adicionar departamento</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do departamento">
            </div>

            <div class="mb-3">
                <label for="responsabilidade" class="form-label">Responsabilidade</label>
                <textarea type="text" class="form-control" id="responsabilidade" name="responsabilidade"></textarea>
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>