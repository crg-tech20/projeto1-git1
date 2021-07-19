<?php
include_once '../bd/connection.php';
include_once 'funcoes.php';

// Pega a conexão
$objeto = new Connection();
$connection = $objeto->Conectar();

$option = (isset($_GET['option'])) ? trim($_GET['option']) : 1;

try {

    switch($option){        
            //case 1 Carregar lista de serviços
            case 1:
                $retorno = "";
                $sql = "SELECT * FROM tb_servicos WHERE servico NOT LIKE 'WAN%' "; // Exclui o WAN que esta fixado no selected
                $stm = $connection->prepare($sql);
                $stm->execute();
                $dados = $stm->FetchAll(PDO::FETCH_OBJ);

                $retorno = "<option value='WAN' selected >WAN</option>";
                foreach($dados as $reg):
                    $retorno .= "<option value='{$reg->servico}'>{$reg->servico}</option>";
                endforeach;
                //sleep(5);
                echo $retorno;
                break;

            case 2:
                $retorno = "";
                $sql = "SELECT * FROM tb_clientes WHERE sigla NOT LIKE 'RFB%' "; // Exclui o WAN que esta fixado no selected
                $stm = $connection->prepare($sql);
                $stm->execute();
                $dados = $stm->FetchAll(PDO::FETCH_OBJ);

                $retorno = "<option value='RFB' selected >RFB</option>";
                foreach($dados as $reg):
                    $retorno .= "<option value='{$reg->sigla}'>{$reg->sigla}</option>";
                endforeach;
                //sleep(5);
                echo $retorno;
                break;
    }
    $connection=null; // Fecha a conexão aberta mesmo se der erro

} catch (PDOException $e){
    // TODO: imprime os erros
    echo "Erro ao carregar listas: ". $e->getMessage()."<br>";
    echo 'Nome do arquivo: ' . $e->getFile().'<br>';
    echo 'Linha do arquivo: ' . $e->getLine().'<br>';
    $connection=null; // Fecha a conexão aberta mesmo se der erro

} //finally {
  //  $connection=null; // Fecha a conexão aberta mesmo se der erro
//}




