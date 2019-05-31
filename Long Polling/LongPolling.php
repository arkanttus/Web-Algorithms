<?php

//Created by: Italo Oliveira
//Based on Long Polling functions already developed

//I assume you have the class Conexao.php created
require_once "Conexao.php"; //Connection with the DataBase using PDO

class LongPolling{

	private $conexao;
	private $query; //Contains the query that will be executed to compare with the current value
	private $dado; //Stores the current value shown to the user
	private $EXECUTION_TIME; //Sets how long the script will run. Set 0 for the script to run in infinite loop
	private $SLEEP_TIME; //Time wich the script will is sleeping

	function __construct($query, $dado, $execTime, $sleep){
		$conexao = new Conexao();
		$this->conexao = $conexao->conectarMysql();
		$this->query = $query;
		$this->dado = $dado;
		$this->EXECUTION_TIME = $execTime;
		$this->SLEEP_TIME = $sleep;
	}

	public function start(){

		//Armazena o tempo em que o script iniciou
		$timeStart = time();

		//set um tempo de execução para esse script
		ini_set('max_execution_time', $this->EXECUTION_TIME);

		//Ficará executando enquanto o tempo atual - tempo inicial for menor igual que o tempo estipulado em $Execution_Time
		while( time() - $timeStart < ($this->EXECUTION_TIME - $this->SLEEP_TIME )){

			$result = $this->conexao->query($this->query);
			
			//verifica se o dado capturado é novo, se for, retorna ele
			if( $this->dado != $result){
				echo $result;
				exit();
			}

			sleep($this->SLEEP_TIME);
		}

      //Se nenhum dado novo chegou ao Banco de Dados, imprime vazio e encerra o script
	  	echo "";
	  	exit();
	}
}


?>
