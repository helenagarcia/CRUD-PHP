<?php

class Conexao {
	
	private $servername = "localhost";
	private $database = "recursoshumanos";
	private $username = "root";
	private $password = "labfiap#2019$";
	
	private $conexao = null;


	function getConexao(){		
		$this->conexao = new mysqli($this->servername, $this->username, $this->password, $this->database);
		
		if (empty($this->conexao) || ($this->conexao->connect_errno)){			
			die( $this->conexao->connect_errno . ' - Mensagem: ' . mysqli_connect_error());
		}
		return $this->conexao;
	}
	
	function closeConexao(){
		
		$status = false;
		if (isset($this->conexao)){
			$status = mysqli_close($this->conexao);		
		}
		return $status;
	}
}
?>