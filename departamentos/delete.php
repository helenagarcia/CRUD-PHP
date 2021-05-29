<?php  
	
    include("../departamentos/departamentoController.php");
    

    $departamentoId = $_GET["id"];

    $controller = new DepartamentoController();

    $controller->excluir($departamentoId);

