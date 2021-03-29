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
    <title>Editar Funcionário</title>
</head>

<?php
$funcionario = false;
$error = false;

if (!$_GET || !isset($_GET["registro"])) {
    header('Location: index.php?message=Nº de registro do funcionário não informado!!');
    die();
}

$funcionarioRegistro = $_GET["registro"];

try {
    $query = "SELECT * FROM funcionarios WHERE registro=$funcionarioRegistro";
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

$upadeError = false;
$updateResult = false;
if ($_POST) {
    try {

        $nome = $_POST["nome"];
        $cargo = $_POST["cargo"];
        $departamento_id = $_POST["departamento_id"];

        $query = "UPDATE funcionarios SET 
            nome='$nome', 
            cargo='$cargo', 
            departamento_id=$departamento_id
        WHERE 
            registro=$funcionarioRegistro";

        $updateResult = $conn->query($query);

        if ($updateResult) {
            header('Location: index.php?message=Dados do funcionário alterado com sucesso!!');
            die();
        }
    } catch (Exception $e) {
        $upadeError = $e->getMessage();
    }
}

try {
    $departamentoQuery = "SELECT * from departamentos";
    $departamentoResult = $conn->query($departamentoQuery);
} catch (Exception $e) {
    header('Location: index.php?message=Erro ao recuperar os departamentos!');
    die();
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
                Erro ao alterar os dados do funcionário.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar funcionário</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="departamento_id" class="form-label">Departamento</label>
                <select 
                    class="form-control" 
                    id="departamento_id" 
                    name="departamento_id"
                    required>
                        <option value></option>

                        <?php while($departamento = $departamentoResult->fetch_assoc()): ?>
                            <option 
                                value="<?=$departamento["id"]?>"
                                <?= $departamento["id"] == $funcionario["departamento_id"] ? 'selected' : '';?>
                                >
                                <?=$departamento["nome"]?>
                            </option>
                        <?php endwhile; ?>
                        
                        <?php $departamentoResult->close(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" value="<?= $funcionario["nome"]?>" id="nome" name="nome" placeholder="Nome do funcionário">
            </div>
            
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input type="text" class="form-control" value="<?= $funcionario["cargo"]?>" id="cargo" name="cargo" placeholder="Cargo do funcionário">
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>