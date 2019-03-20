<?php

require_once "Conexao.php";

class LongPolling{

	private $conexao;
	private $query;
	private $dado;
	private $EXECUTION_TIME;
	private $SLEEP_TIME;

	function __construct($query, $dado, $execTime, $sleep){
		$conexao = new Conexao();
		$this->conexao = $conexao->conectarMysql();
		$this->query = $query;
		$this->dado = $dado;
		$this->EXECUTION_TIME = $execTime;
		$this->SLEEP_TIME = $sleep;
	}

	public function start(){

		//guarda o tempo q o long polling começou
		$timeStart = time();

		//seta um tempo de execução para esse script
		ini_set('max_execution_time', $this->EXECUTION_TIME);

		//fica rodando enquanto o tempo de exec do script for menor que o tempo estipulado
		while( time() - $timeStart < ($this->EXECUTION_TIME - $this->SLEEP_TIME )){

			$result = $this->conexao->query($this->query)->fetchColumn();
			
			//verifica se o dado capturado é novo, se for, retorna ele
			if( $this->dado != $result){
				echo $result;//."\n".$executionTime;
				exit();
			}

			sleep($this->SLEEP_TIME);
		}


	  	echo "";
	  	exit();
	}
}


?>