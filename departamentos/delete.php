<?php  
	require("../_config/connection.php");

    $error = false;

    if(!$_GET || !$_GET["id"]){
        header('Location: index.php?message=Id do departamento não informado!!');
        die();
    }

    $departamentoId = $_GET["id"];

    try {
        $query = "DELETE FROM departamentos WHERE id=$departamentoId";
		$result = $conn->query($query);
        $conn->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    $message = ($result && !$error) ? "Departamento excluido com sucesso." : "Erro ao excluir o departamento.";
    header("Location: index.php?message=$message");
    die();

