<?php

include("../Conexao.php");

class DepartamentoDAO{

    private $conexao;

    public function __construct(){
        $objConexao = new Conexao();
		$this->conexao = $objConexao->getConexao();
    }
    
    function insert($nome, $responsabilidade){
        return $this->conexao->query("INSERT INTO departamentos (
            nome, 
            responsabilidade
        ) VALUES (
            '$nome',
            '$responsabilidade'
        )");
    }

    function selectAll(){
		$resultado = $this->conexao->query("select * from departamentos");
		$lista = $resultado->fetch_all(MYSQLI_ASSOC);
		return $lista;
		
	}

    function findById($departamentoId){
		$resultado = $this->conexao->query("SELECT * FROM departamentos WHERE id=$departamentoId");
		$registro = $resultado->fetch_assoc();
		return $registro;
		
	}
        
    function update($departamentoId, $nome, $responsabilidade){
		return $this->conexao->query("UPDATE departamentos SET nome='$nome', responsabilidade='$responsabilidade'
        WHERE id=$departamentoId");
		
	}
    
    function remove($departamentoId){
		return $this->conexao->query("DELETE FROM departamentos WHERE id=$departamentoId");
		
	}
}