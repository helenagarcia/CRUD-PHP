<?php

include("departamentoDAO.php");

class DepartamentoController {


    private $departamentoDao;
	
	public function __construct() {
		$this->departamentoDao = new DepartamentoDAO();
	}

    public function inserir($nome, $responsabilidade){
		$resultado = false;
		if ($this->departamentoDao->insert($nome, $responsabilidade)){
			$resultado = true;
		}		
		return $resultado;
	}

    public function alterar($departamentoid, $nome, $responsabilidade){

        $resultado = false;

        if ($this->departamentoDao->update($departamentoid, $nome, $responsabilidade)){

            $resultado = true;

        }       

        return $resultado;

    }

    public function excluir($departamentoid){

        $resultado = false;

        if ($this->departamentoDao->remove($departamentoid)){

            $resultado = true;

        }       

        return $resultado;

    }

	public function listarTodos(){
		return $todos = $this->departamentoDao->selectAll();
	}
}