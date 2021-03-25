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
    <title>Visualizar Departamento</title>
</head>

<?php
$departamento = false;
$error = false;

if (!$_GET || !$_GET["id"]) {
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
    header('Location: index.php?message=Erro ao recuperar dados desse departamento!!');
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
                <h1>Visualizar Departamento</h1>
            </div>
        </div>

        <div class="mb-3">
            <h3>Nome</h3>
            <p><?= $departamento["nome"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Responsabilidade</h3>
            <p><?= $departamento["responsabilidade"] ?></p>
        </div>

    </section>
</body>

</html>