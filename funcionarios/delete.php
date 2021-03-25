<?php  
	require("../_config/connection.php");

    $error = false;

    if(!$_GET || !$_GET["registro"]){
        header('Location: index.php?message=Nº Registro do funcionário não informado!!');
        die();
    }

    $funcionarioRegistro = $_GET["registro"];

    try {
        $query = "DELETE FROM funcionarios WHERE registro=$funcionarioRegistro";
		$result = $conn->query($query);
        $conn->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    $message = ($result && !$error) ? "Funcionário excluido com sucesso." : "Erro ao excluir o funcionário.";
    header("Location: index.php?message=$message");
    die();

