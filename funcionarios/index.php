<?php  
	require("../_config/connection.php");

	$message = false;
	$departamento_id = false;

	if($_GET){
		if(isset($_GET["message"])){
			$message = $_GET["message"];
		}
		if(isset($_GET["departamento_id"])){
			$departamento_id = $_GET["departamento_id"];
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<title>Recursos Humanos</title>
</head>
<body>

	<?php  
        readFile("../_partials/navbar.html");
    ?>

	<?php 
		$query = "SELECT f.*, d.nome as departamento 
			FROM funcionarios f
			INNER JOIN departamentos d on f.departamento_id = d.id";

		if($departamento_id){
			$query .= " WHERE f.departamento_id = $departamento_id";
		}

		$result = $conn->query($query);
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$result->close();

		try {
			$departamentoQuery = "SELECT * from departamentos";
			$departamentoResult = $conn->query($departamentoQuery);
		} catch (Exception $e) {
			header('Location: index.php?message=Erro ao recuperar os departamentos!');
			die();
		}
		
		$conn->close();
	?>
	<section class="container mt-5 mb-5">

		<?php if($message):?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?=$message?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif;?>

		<div class="row mb-3">
			<div class="col">
				<h1>Funcionários</h1>
			</div>
			<div class="col d-flex justify-content-end align-items-center">
				<a class="btn btn-primary" href="add.php">Adicionar</a>
			</div>
		</div>

		<form action="" method="get">
			<div class="input-group mb-3">
				<select 
					class="form-control" 
					id="departamento_id" 
					name="departamento_id">
						<option value></option>

						<?php while($departamento = $departamentoResult->fetch_assoc()): ?>
							<option 
								value="<?=$departamento["id"]?>"
								<?= $departamento["id"] == $departamento_id ? 'selected' : '';?>
							>
								<?=$departamento["nome"]?>
							</option>
						<?php endwhile; ?>
						
						<?php $departamentoResult->close(); ?>
				</select>
				<button class="btn btn-outline-secondary" type="submit">
					Pesquisar
				</button>
			</div>
		</form>

		<table class="table table-striped table-bordered">
			<thead class="table-dark">
				<tr>
					<th>Registo</th>
					<th>Nome</th>
					<th>Cargo</th>
					<th>Departamento</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $funcionario): ?>
					<tr>
						<td>
							<?=$funcionario["registro"]?>
						</td>
						<td>
							<?=$funcionario["nome"]?>
						</td>
						<td>
							<?=$funcionario["cargo"]?>
						</td>
						<td>
							<?=$funcionario["departamento"]?>
						</td>
						<td>
							<div class="btn-group" role="group">
								<button 
									type="button" 
									class="btn btn-outline-primary"
									onclick="confirmDelete(<?=$funcionario['registro']?>)">
									Excluir
								</button>
								<a 
									href="edit.php?registro=<?=$funcionario["registro"]?>" 
									class="btn btn-outline-primary">
									Editar
								</a>
								<a 
									href="view.php?registro=<?=$funcionario["registro"]?>" 
									class="btn btn-outline-primary">
									Ver
								</a>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script>
	const confirmDelete = (funcionarioRegistro) => {
		const response = confirm("Deseja realmente excluir este produto?")
		if(response){
			window.location.href = "delete.php?registro=" + funcionarioRegistro
		}
	}
</script>
</html>