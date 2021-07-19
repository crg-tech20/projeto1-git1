<?php

function timestamp_DateStr($timestamp_int){

    // Retorna uma string com a data, formato d/m/Y H:i
    
	$date_str = date('d/m/Y H:i', $timestamp_int); // retirado os segundos
	//$date_str = date('d/m/Y H:i:s', $timestamp_int);
	return $date_str;    
}

function str_Timestamp($str_data){

    // Formata datas para o banco com saida em timestamp: formado de entrada d/m/Y H:i:s , saida timestamp //
    
	$dataform = explode(" ", $str_data);
	list($date, $hora) = $dataform;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$data_sem_barra = $data_sem_barra . " " . $hora; 
	$timestamp = (int) strtotime($data_sem_barra);
	return $timestamp;
}

function get_timestamp(){
		// Retorna o timestamp da data e hora atual

        date_default_timezone_set('America/Sao_Paulo');
		//$date = new DateTime('-1 houer');  // Devido ao horário do computador, foi removido uma hora do horário normal
		$date = new DateTime();
		//$date = new DateTime();
		$date->format('Y-m-d H:i');
        $timestamp= $date->getTimestamp();
		return (int) $timestamp;
}

function get_date_US(){
	// Retorna a data formato Y-m-d H:i

	date_default_timezone_set('America/Sao_Paulo');
	$date = new DateTime('-1 houer');
	$date->format('Y-m-d H:i');
	//$timestamp= $date->getTimestamp();
	return $date;
}

function get_time_larger(){

	// Subtrai anos, dias, horas, min., segundos de uma data e hora especificos

	//echo(strtotime("now") . "<br/>");
	$timestamp = strtotime("-1 hours -30 minutes 0 seconds");

	//date_default_timezone_set('America/Sao_Paulo'); // Coloca o time zone para São Paulo
	//$date = new DateTime('-1 houer'); // Devido ao horário do computador, foi removido uma hora do horário normal
	// new DateInterval('P7Y5M4DT4H3M2S')
	//$date->sub(new DateInterval('PT1H30M0S')); // Equivale à 1 hora e 30 minutos antes do horário atual.
	//$date->format('Y-m-d H:i');
	//$timestamp= $date->getTimestamp();
	return (int) $timestamp;
	//return $date->format('Y-m-d H:i');
	
}






