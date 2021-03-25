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
    <title>Visualizar Funcionário</title>
</head>

<?php
$funcionario = false;
$error = false;

if (!$_GET || !isset($_GET["registro"])) {
    header('Location: index.php?message=Nº do registro do funcionário não informado!!');
    die();
}

$funcionarioRegistro = $_GET["registro"];

try {
    $query = "SELECT f.*, d.nome as departamento 
        FROM funcionarios f
        INNER JOIN departamentos d on f.departamento_id = d.id
        WHERE f.registro=$funcionarioRegistro";

    $result = $conn->query($query);
    $funcionario = $result->fetch_assoc();
    $result->close();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!$funcionario || $error) {
    header('Location: index.php?message=Erro ao recuperar dados do funcionário!');
    die();
}

$conn->close();

?>

<body>

    <?php
    readFile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">
        <div class="row mb-3">
            <div class="col">
                <h1>Visualizar Funcionário</h1>
            </div>
        </div>

        <div class="mb-3">
            <h3>Nome</h3>
            <p><?= $funcionario["nome"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Departamento</h3>
            <p><?= $funcionario["departamento_id"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Cargo</h3>
            <p><?= $funcionario["cargo"] ?></p>
        </div>

    </section>
</body>

</html>