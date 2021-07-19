<?php
include_once '../bd/connection.php';
include_once 'funcoes.php';

/*     
// TODO:
* - Arquivo usado para carregar as atualizações
* - Será usado parecido para documentos e acionamentos


*/
// Pega a conexão
$objeto = new Connection();
$connection = $objeto->Conectar();

// Dados vindos das solicitações ajax.
$option = (isset($_POST['option'])) ? trim($_POST['option']) : 1;
$id_localidade = (isset($_POST['id_localidade'])) ? trim($_POST['id_localidade']) : null;
$ordenar = (isset($_POST['nova_ordenar'])) ? trim($_POST['nova_ordenar']) : null;
$atualizacao = (isset($_POST['nova_atualizacao'])) ? trim($_POST['nova_atualizacao']) : null;
$id = (isset($_POST['id'])) ? trim($_POST['id']) : null;
$idAtualizacao = (isset($_POST['idAtualizacao'])) ? trim($_POST['idAtualizacao']) : null;


$tempo = get_timestamp(); // função para retornar o timestamp => funções.php
$usuario = "Carlos"; // FIXME:

try {

    switch($option){  

        // OK - Carregar lista de atualizações.
        case 1:
            // OK - Carregar lista de atualizações.
            // Seleciona as atualizações {$id_localidade}
            $sql = "SELECT * FROM tb_atualizacoes WHERE id_localidade = {$id_localidade} ORDER BY ordenar"; // Seleciona as atualizações {$id_localidade}
            $stm = $connection->prepare($sql);
            $stm->execute();
            $dados = $stm->FetchAll(PDO::FETCH_OBJ);
            // OK - Monta a tabela de atualizações e devolve em $retorno.
            $retorno = "";
            foreach($dados as $reg):
                $retorno .= "<tr>";
                $retorno .= "<td>{$reg->ordenar}</td><td>{$reg->usuario}</td><td>{$reg->atualizacao}</td>";
                $retorno .= "<td width='20%' align='center' align='center'>";
                $retorno .= "<button type='button' class='btn btn-success btn-sm editarAtualizacao ' onclick='editarAtualizacao(".$reg->id.",".$reg->id_localidade.")' id='{$reg->id}'>Editar</button>";
                $retorno .= "<button type='button' class='btn btn-danger btn-sm deletarAtualizacao' id='{$reg->id}'>Deletar</button></td></tr>";
            endforeach;
            //sleep(5);
            echo $retorno;
            break;

        // OK - Inserir nova atualização.
        case 2:

            // TODO: Completa o form no index.php
            // FIXME:  - Inserir a atualização da localidade, como ultima atualização.
            // FIXME:   carregar os dados de atualização.

            //$atualizacao = "Teste de atualização: ".$ordenar;

//$consulta = "INSERT INTO tb_atualizacoes (id_localidade, ordenar, tempo, usuario, atualizacao) VALUES(:id_localidade, :ordenar, :tempo, :usuario, :atualizacao) RETURNING id";
            $consulta = "INSERT INTO tb_atualizacoes (id_localidade, ordenar, tempo, usuario, atualizacao) VALUES(:id_localidade, :ordenar, :tempo, :usuario, :atualizacao) ";						
            $stm = $connection->prepare($consulta);
            // $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':id_localidade', $id_localidade, PDO::PARAM_INT);
            $stm->bindParam(':ordenar', $ordenar, PDO::PARAM_INT);
            $stm->bindParam(':tempo', $tempo, PDO::PARAM_INT);
            $stm->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stm->bindParam(':atualizacao', $atualizacao, PDO::PARAM_STR);
            $stm->execute();   

            // TODO: para verificar os ids de inserção, não usado, deixado para testes
//$id_inserido = $stm->fetchColumn(); // retornou o id e testei no código abaixo 
            //echo $retorno; 

            // OK - Grava na tabela localidades a última atualização da mesma.
            $sql = "UPDATE tb_localidades SET tempo_atualizacao = {$tempo} WHERE id = {$id_localidade}"; 
            $stm = $connection->prepare($sql);
            $stm->execute();

            // OK - Seleciona as atualizações para devolver ao modal novamente, através do $retorno;
            $sql = "SELECT * FROM tb_atualizacoes WHERE id_localidade = {$id_localidade} ORDER BY ordenar"; // Seleciona as atualizações {$id_localidade}
            $stm = $connection->prepare($sql);
            $stm->execute();
            $dados = $stm->FetchAll(PDO::FETCH_OBJ);
            // OK - Monta a tabela de atualizações e devolve em $retorno.
            $retorno = "";
            foreach($dados as $reg):
                $retorno .= "<tr>";
                $retorno .= "<td>{$reg->ordenar}</td><td>{$reg->usuario}</td><td>{$reg->atualizacao}</td>";
                $retorno .= "<td width='20%' align='center' align='center'>";
                $retorno .= "<button type='button' class='btn btn-success btn-sm editarAtualizacao ' onclick='editarAtualizacao(".$reg->id.",".$reg->id_localidade.")' id='{$reg->id}'>Editar</button>";
                $retorno .= "<button type='button' class='btn btn-danger btn-sm deletarAtualizacao' id='{$reg->id}'>Deletar</button></td></tr>";
            endforeach;
            //sleep(5);
            echo $retorno;
            break;

        // OK - Seleciona o último ordenar a acrescenta +3, para dar intervalo para alterações.    
        case 3:
            // OK - Seleciona o último ordenar a acrescenta +3, para dar intervalo para alterações.

            $sql  = "SELECT max(ordenar) FROM tb_atualizacoes WHERE id_localidade = {$id_localidade}";
            $result= $connection->query($sql);                
            // retorna os dados do banco
            $result = $result->fetch();
            $ordenar = $result[0] + 3;  // Retorno com soma de 3.

            echo $ordenar; // Devolve para quem chamou.
            break;

        // OK - Deleta a atualização solicitada pelo id.    
        case 4:
            // OK - Deleta a atualização solicitada pelo id.

            // OK - Seleciona o id_localidade referente ao id a ser deletado
            $sql  = "SELECT id_localidade FROM tb_atualizacoes WHERE id = {$id}";
            $result= $connection->query($sql);

            // retorna os dados do banco
            $result = $result->fetch();
            $id_localidade = (int) $result[0];

            $sql  = "DELETE FROM tb_atualizacoes WHERE id = {$id}";
            $result= $connection->query($sql);   

            // Seleciona as atualizações para devolver ao modal novamente, através do $retorno;
            $sql = "SELECT * FROM tb_atualizacoes WHERE id_localidade = {$id_localidade} ORDER BY ordenar"; // Seleciona as atualizações {$id_localidade}
            $stm = $connection->prepare($sql);
            $stm->execute();
            $dados = $stm->FetchAll(PDO::FETCH_OBJ);
            // OK - Monta a tabela de atualizações e devolve em $retorno.
            $retorno = "";
            foreach($dados as $reg):
                $retorno .= "<tr>";
                $retorno .= "<td>{$reg->ordenar}</td><td>{$reg->usuario}</td><td>{$reg->atualizacao}</td>";
                $retorno .= "<td width='20%' align='center' align='center'>";
                $retorno .= "<button type='button' class='btn btn-success btn-sm editarAtualizacao ' onclick='editarAtualizacao(".$reg->id.",".$reg->id_localidade.")' id='{$reg->id}'>Editar</button>";
                $retorno .= "<button type='button' class='btn btn-danger btn-sm deletarAtualizacao' id='{$reg->id}'>Deletar</button></td></tr>";
            endforeach;
            //sleep(5);
            echo $retorno;
            break;

        // FIXME:  // edição de atualizações. =========> case 5 selecionar uma localidade, case 6 update de uma localidade.
        // TODO:
        // OK - Seleciona uma atualização especifica pelo id.    
        case 5:
            //  - Seleciona uma atualização especifica pelo id.
            $sql  = "SELECT * FROM tb_atualizacoes WHERE id = {$id}";
            $stm = $connection->prepare($sql);
            $stm->execute();
            $request = $stm->FetchAll(PDO::FETCH_OBJ);
            //$retorno = json_encode($request, JSON_UNESCAPED_UNICODE);// envia o array no formato json AJAX
            $retorno = json_encode($request);// envia o array no formato json AJAX
            //$retorno = json_encode($request);// envia o array no formato json AJAX
            //sleep(5);
            echo $retorno;
            break;

        //  - Update da atualização solicitada pelo id.
        case 6:
            //  - Update da atualização solicitada pelo id.
            $sql = "UPDATE tb_atualizacoes SET ordenar=:ordenar, tempo=:tempo, usuario=:usuario, atualizacao=:atualizacao WHERE id= :idAtualizacao";
            $stm = $connection->prepare($sql);
            // $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':idAtualizacao', $idAtualizacao, PDO::PARAM_INT);
            $stm->bindParam(':ordenar', $ordenar, PDO::PARAM_INT);
            $stm->bindParam(':tempo', $tempo, PDO::PARAM_INT);
            $stm->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stm->bindParam(':atualizacao', $atualizacao, PDO::PARAM_STR);
            $stm->execute();

            // OK - Seleciona as atualizações para devolver ao modal novamente, através do $retorno;
            $sql = "SELECT * FROM tb_atualizacoes WHERE id_localidade = {$id_localidade} ORDER BY ordenar"; // Seleciona as atualizações {$id_localidade}
            $stm = $connection->prepare($sql);
            $stm->execute();
            $dados = $stm->FetchAll(PDO::FETCH_OBJ);
            // OK - Monta a tabela de atualizações e devolve em $retorno.
            $retorno = "";
            foreach($dados as $reg):
                $retorno .= "<tr>";
                $retorno .= "<td>{$reg->ordenar}</td><td>{$reg->usuario}</td><td>{$reg->atualizacao}</td>";
                $retorno .= "<td width='20%' align='center' align='center'>";
                $retorno .= "<button type='button' class='btn btn-success btn-sm editarAtualizacao ' onclick='editarAtualizacao(".$reg->id.",".$reg->id_localidade.")' id='{$reg->id}'>Editar</button>";
                $retorno .= "<button type='button' class='btn btn-danger btn-sm deletarAtualizacao' id='{$reg->id}'>Deletar</button></td></tr>";
            endforeach;
            //sleep(5);
            echo $retorno;
            break;
            
    } // Fecha switch($option)
    $connection=null; // Fecha a conexão aberta

} catch (PDOException $e){
    // TODO: imprime os erros
    echo "Erro ao carregar listas: ". $e->getMessage()."<br>";
    echo 'Nome do arquivo: ' . $e->getFile().'<br>';
    echo 'Linha do arquivo: ' . $e->getLine().'<br>';
    $connection=null; // Fecha a conexão aberta mesmo se der erro

} //finally {
//    $connection=null; // Fecha a conexão aberta mesmo se der erro
//}
