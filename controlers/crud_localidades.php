<?php
include_once '../bd/connection.php';
include_once 'funcoes.php';

// Pega a conexão
$objeto = new Connection();
$connection = $objeto->Conectar();

// Pega os dados vindos do POST
$id = (isset($_POST['id'])) ? intval(trim($_POST['id'])) : '';
$localidade = (isset($_POST['localidade'])) ? strtoupper(trim($_POST['localidade'])) : '';
$hostname = (isset($_POST['hostname'])) ? trim($_POST['hostname']) : '';
$designacao = (isset($_POST['designacao'])) ? trim($_POST['designacao']) : '';
$ip = (isset($_POST['ip'])) ? trim($_POST['ip']) : '';
$uf = (isset($_POST['uf'])) ? trim($_POST['uf']) : '';
$reg = (isset($_POST['reg'])) ? trim($_POST['reg']) : '';
$og = (isset($_POST['og'])) ? strtoupper(trim($_POST['og'])) : 'GSOPBRMON2';
$equipe = (isset($_POST['equipe'])) ? strtoupper(trim($_POST['equipe'])) : 'GSOPBRMON2';
$cliente = (isset($_POST['cliente'])) ? trim($_POST['cliente']) : '';
$demanda = (isset($_POST['demanda'])) ? trim($_POST['demanda']) : '';
$solucao = (isset($_POST['solucao'])) ? trim($_POST['solucao']) : '';
$situacao = (isset($_POST['situacao'])) ? trim($_POST['situacao']) : '';
$operadora = (isset($_POST['operadora'])) ? trim($_POST['operadora']) : '';
$servico = (isset($_POST['servico'])) ? strtoupper(trim($_POST['servico'])) : '';
$ativo = 1; // localidade esta ativa, aquivada seria = 0
$tempo_atualizacao = (isset($_POST['tempo_atualizacao']) && !empty($_POST['tempo_atualizacao'])) ? str_Timestamp($_POST['tempo_atualizacao']) : get_timestamp();
//$tempo_atualizacao

// echo $_POST;
// FIXME:  - Ajustar os tempos vindos e gravados no post
// TODO:
//$ult_atualizacao = (isset($_POST['ult_atualizacao'])) ? $_POST['ult_atualizacao'] : '';
//$tempo = (isset($_POST['tempo'])) ? str_Timestamp(trim($_POST['tempo'])) : new DateTime('now');

//$tempo = str_Timestamp($str_tempo);

// Opção para seleção de qual ação tomar
$option = (isset($_POST['option'])) ? trim($_POST['option']) : 4;
//echo $_POST;
try {
    switch($option){

        //case 1 ok
        case 1:
//$consulta = "INSERT INTO tb_localidades (localidade, hostname, designacao, ip, uf, reg, og, equipe, cliente, demanda, solucao, situacao, operadora, servico, ativo, tempo_cadastro, tempo_atualizacao) VALUES(:localidade, :hostname, :designacao, :ip, :uf, :reg, :og, :equipe, :cliente, :demanda, :solucao, :situacao, :operadora, :servico, :ativo, :tempo_cadastro, :tempo_atualizacao) RETURNING id";
            $consulta = "INSERT INTO tb_localidades (localidade, hostname, designacao, ip, uf, reg, og, equipe, cliente, demanda, solucao, situacao, operadora, servico, ativo, tempo_cadastro, tempo_atualizacao) VALUES(:localidade, :hostname, :designacao, :ip, :uf, :reg, :og, :equipe, :cliente, :demanda, :solucao, :situacao, :operadora, :servico, :ativo, :tempo_cadastro, :tempo_atualizacao) RETURNING id";						
            $stm = $connection->prepare($consulta);
            // $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':localidade', $localidade, PDO::PARAM_STR);
            $stm->bindParam(':hostname', $hostname, PDO::PARAM_STR);
            $stm->bindParam(':designacao', $designacao, PDO::PARAM_STR);
            $stm->bindParam(':ip', $ip, PDO::PARAM_STR);
            $stm->bindParam(':uf', $uf, PDO::PARAM_STR);
            $stm->bindParam(':reg', $reg, PDO::PARAM_STR);
            $stm->bindParam(':og', $og, PDO::PARAM_STR);
            $stm->bindParam(':equipe', $equipe, PDO::PARAM_STR);
            $stm->bindParam(':cliente', $cliente, PDO::PARAM_STR);
            $stm->bindParam(':demanda', $demanda, PDO::PARAM_STR);
            $stm->bindParam(':solucao', $solucao, PDO::PARAM_STR);
            $stm->bindParam(':situacao', $situacao, PDO::PARAM_STR);
            $stm->bindParam(':operadora', $operadora, PDO::PARAM_STR);
            $stm->bindParam(':servico', $servico, PDO::PARAM_STR);
            $stm->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $stm->bindParam(':tempo_cadastro', $tempo_atualizacao, PDO::PARAM_INT);
            $stm->bindParam(':tempo_atualizacao', $tempo_atualizacao, PDO::PARAM_INT);
            $stm->execute();

            // TODO: NÃO APAGAR, É RESPONSÁVEL PELA PRIMEIRA ATUALIZAÇÃO.
            // FIXME:   retornou o id e testei no código abaixo
//$id_inserido = $stm->fetchColumn(); // retornou o id e testei no código abaixo            

            //$id_inserido2 = $stm->lastInsertId(); 
            //echo $id_inserido;
/* 
// Inserir para cada nova localidade, uma primeira atualização.
$sql_atualização = "INSERT INTO tb_atualizacoes (id_localidade, ordenar, tempo, usuario, atualizacao) VALUES (:id_localidade, :ordenar, :tempo, :usuario, :atualizacao) ";
$stm = $connection->prepare($sql_atualização);
$stm->execute(array(
    ':id_localidade' => (int) $id_inserido, 
    ':ordenar' => 1, 
    ':tempo' => $tempo_atualizacao, 
    ':usuario' => 'Carlos', 
    ':atualizacao' => timestamp_DateStr($tempo_atualizacao).'h - '.$localidade.' - '.$designacao.' - '.$demanda
));
 */            
            $sql = "SELECT * FROM tb_localidades ORDER BY id DESC LIMIT 1"; // Seleciona e limita a 1 usuário retornado            
            $stm = $connection->prepare($sql);
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC); 

            break;  

            
        // case 2 ok
        case 2:        
            // UPDATE da localidade
            $stmt = $connection->prepare('UPDATE tb_localidades SET localidade = :localidade, hostname = :hostname, designacao = :designacao, ip = :ip, uf = :uf, reg = :reg, og = :og, equipe = :equipe, cliente = :cliente, demanda = :demanda, solucao = :solucao, situacao = :situacao, operadora = :operadora, servico = :servico, ativo = :ativo, tempo_atualizacao = :tempo_atualizacao WHERE id = :id');
            //$stmt = $connection->prepare('UPDATE tb_localidades SET localidade = :localidade, hostname = :hostname, ip = :ip, uf = :uf, reg = :reg, og = :og, equipe = :equipe, cliente = :cliente, solucao = :solucao, ativo = :ativo, situacao = :situacao, ult_atualizacao = :ult_atualizacao, tempo = :tempo WHERE id = :id');
            $stmt->execute(array(
              ':localidade' => $localidade,
              ':hostname' => $hostname,
              ':designacao' =>$designacao,              
              ':ip' => $ip,
              ':uf' => $uf,
              ':reg' => $reg,
              ':og' => $og,
              ':equipe' => $equipe,
              ':cliente' => $cliente,
              ':demanda' => $demanda,
              ':solucao' => $solucao,
              ':situacao' => $situacao,
              ':operadora' =>$operadora,
              ':servico' => $servico,
              ':ativo' => $ativo,
              ':tempo_atualizacao' => $tempo_atualizacao,
              ':id' => $id
            ));        
            
            $sql = 'SELECT * FROM tb_localidades WHERE id = :id';       
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $retorno = $stmt->rowCount(); // conta a quantidade de linhas retornada na consulta.
            //print($retorno);
            for($i = 0; $i<$retorno; $i++ ){
               // transforma o time stamp em data no formato string}
                $data1[$i]['tempo_atualizacao']= timestamp_DateStr($data1[$i]['tempo_atualizacao']);
              } // Retorna uma string com a tempo
            $data = $data1;
            break;

        // case 3 ok    
        case 3:   // Delete            
            // Deletar localidades            
            $stmt = $connection->prepare('DELETE FROM tb_localidades WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Procura por atualizações para deletar.
            $stmt = $connection->prepare('DELETE FROM tb_atualizacoes WHERE id_localidade = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $retorno = $stmt->rowCount();

            // Procura por documentos para deletar.
            $stmt = $connection->prepare('DELETE FROM tb_documentos WHERE id_localidade = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $retorno = $stmt->rowCount();

            // Procura por acionamentos para deletar.
            $stmt = $connection->prepare('DELETE FROM tb_acionamentos WHERE id_localidade = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $retorno = $stmt->rowCount();
                        
            break;

        // case 4 ok
        case 4: 
            // Selecionar todas as localidades.   
            $sql = "SELECT * FROM tb_localidades ORDER BY id DESC";
            $stmt = $connection->prepare($sql);
            $stmt->execute();        
            $data1 = $stmt->fetchAll(PDO::FETCH_OBJ); 
            // Segunda forma
            //$data1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $retorno = $stmt->rowCount(); // conta a quantidade de linhas retornada na consulta.
            //print($retorno);
            foreach($data1 as $row){
                $row->tempo_cadastro = timestamp_DateStr($row->tempo_cadastro);
                $row->tempo_atualizacao = timestamp_DateStr($row->tempo_atualizacao);
            }
            $data = $data1;
            break;
/* 
                'select com order multiplos'
                
                SELECT  *
                FROM    mytable
                ORDER BY
                        column1 DESC, column2 ASC
 */

        case 5:
            // Selecionar a localidade para o modal
            $sql = 'SELECT * FROM tb_localidades WHERE id = :id';       
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data1 = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            $data1[0]["tempo_atualizacao"] = timestamp_DateStr($data1[0]["tempo_atualizacao"]);
            
            $data = $data1;
            break;

    }
    //print_r(json_encode($data));
    // Devolve o json de $data, selecionados no banco
    //print json_encode($data, JSON_UNESCAPED_UNICODE);// envia o array no formato json AJAX
    print json_encode($data);// envia o array no formato json AJAX

    // Fecha a conexão                                           
    $connection=null;

} catch (PDOException $e){
    // TODO: imprime os erros
    echo "Erro no crud_localidades: ". $e->getMessage()."<br>";
    echo 'Nome do arquivo: ' . $e->getFile().'<br>';
    echo 'Linha do arquivo: ' . $e->getLine().'<br>';
    $connection=null; // Fecha a conexão aberta mesmo se der erro

} //finally {
  //  $connection=null; // Fecha a conexão aberta mesmo se der erro
//}