<?php
require("../_config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Editar Departamento</title>
</head>

<?php
$departamento = false;
$error = false;

if (!$_GET || !isset($_GET["id"])) {
    header('Location: index.php?message=Id do departamento não informado!!');
    die();
}

$departamentoId = $_GET["id"];

try {
    $query = "SELECT * FROM departamentos WHERE id=$departamentoId";
    $result = $conn->query($query);
    $departamento = $result->fetch_assoc();
    $result->close();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!$departamento || $error) {
    header('Location: index.php?message=Erro ao recuperar dados do departamento!!');
    die();
}

$upadeError = false;
$updateResult = false;
if ($_POST) {
    try {
        $nome = $_POST["nome"];
        $responsabilidade = $_POST["responsabilidade"];

        $query = "UPDATE departamentos SET nome='$nome', responsabilidade='$responsabilidade'
        WHERE id=$departamentoId";
        $updateResult = $conn->query($query);

        if ($updateResult) {
            header('Location: index.php?message=Departamento alterado com sucesso!!');
            die();
        }
    } catch (Exception $e) {
        $upadeError = $e->getMessage();
    }
}

$conn->close();

?>

<body>

    <?php
        readFile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">

        <?php if ($_POST && (!$updateResult || $upadeError)) : ?>
            <p>
                Erro ao alterar o departamento.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar departamento</h1>
            </div>
        </div>

        <form action="" method="post">

             <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" value="<?=$departamento["nome"]?>" id="nome" name="nome" placeholder="Nome do departamento">
            </div>

            <div class="mb-3">
                <label for="responsabilidade" class="form-label">Responsabilidade</label>
                <textarea type="text" class="form-control" id="responsabilidade" name="responsabilidade"><?=$departamento["responsabilidade"] ?></textarea>
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>