<?php 
include_once '../bd/connection.php';
include_once 'funcoes.php';
// include_once '../bd/connection.php';

// Pega a conexão
$objeto = new Connection();
$conexao = $objeto->Conectar();

// Recebe os parâmetros enviados via GET
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? strtoupper($_GET['parametro']) : ''; // PHP strtoupper() 

// Configura uma conexão com o banco de dados
//$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
//$conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME, USER, PASSWORD, $opcoes);

// Verifica se foi solicitado uma consulta para o autocomplete
if($acao == 'autocomplete'):
	$where = (!empty($parametro)) ? 'WHERE loopback LIKE ? OR designacao LIKE ? OR hostname LIKE ? OR nome LIKE ? OR cir LIKE ?' : '';
	$sql = "SELECT * FROM tb_cmdb " . $where;

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, '%'.$parametro.'%');
	$stm->bindValue(2, '%'.$parametro.'%');
	$stm->bindValue(3, '%'.$parametro.'%');
	$stm->bindValue(4, '%'.$parametro.'%');
	$stm->bindValue(5, '%'.$parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
    echo $json;
    //echo $_GET['parametro'];
endif;

// Verifica se foi solicitado uma consulta para preencher os campos do formulário
if($acao == 'consulta'):
	$sql = "SELECT * FROM tb_cmdb ";
	$sql .= "WHERE cir LIKE ? LIMIT 1";

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
    echo $json;
    //echo $_GET['acao'];
endif;
$conexao=null; // Fecha a conexão aberta mesmo se der erro