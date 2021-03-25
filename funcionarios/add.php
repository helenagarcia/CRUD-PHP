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
    <title>Adicionar Funcionário</title>
</head>

<?php
$result = false;
$error = false;


if ($_POST) {
    try {

        $nome = $_POST["nome"];
        $cargo = $_POST["cargo"];
        $departamento_id = $_POST["departamento_id"];

        $query = "INSERT INTO funcionarios (
            nome, 
            cargo, 
            departamento_id
        ) VALUES (
            '$nome',
            '$cargo',
            $departamento_id
        )";

        $result = $conn->query($query);
        $conn->close();

        if ($result) {
            header('Location: index.php?message=Funcionário inserido com sucesso!');
            die();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

try {
    $departamentoQuery = "SELECT * from departamentos";
    $departamentoResult = $conn->query($departamentoQuery);
} catch (Exception $e) {
    header('Location: index.php?message=Erro ao recuperar o departamento!');
    die();
}

$conn->close();
?>

<body>

    <?php
        readFile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">

        <?php if ($_POST && (!$result || $error)) : ?>
            <p>
                Erro salvar o novo funcionário.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Adicionar Funcionário</h1>
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
                            <option value="<?=$departamento["id"]?>">
                                <?=$departamento["nome"]?>
                            </option>
                        <?php endwhile; ?>
                        
                        <?php $departamentoResult->close(); ?>
                </select>
            </div>


            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do funcionário">
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo do funcionário">
            </div>


            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>