<?php
include_once '../bd/connection.php';
include_once 'funcoes.php';

// Pega a conexão
$objeto = new Connection();
$connection = $objeto->Conectar();

    try{
        $arquivo = '';

            if(isset($_FILES['cmdb'])){
                $erro= array();
                $file_name = $_FILES['cmdb']['name']; // Nome original do arquivo
                $file_size =$_FILES['cmdb']['size'];
                $file_tmp =$_FILES['cmdb']['tmp_name']; // O nome temporário do arquivo, como foi guardado no servidor.
                $file_type=$_FILES['cmdb']['type'];
                $extencao = explode('.',$file_name);
                $file_ext = strtolower($extencao[1]);
                $novo_nome = "cmdb.json";// Nome correto do arquivo

                //$extensions= array("jpeg","jpg","png");
                $extensions= array("json");

                if(in_array($file_ext,$extensions)=== false){
                    $erro="<div class='alert alert-warning' role='alert'> Não é permitido uploade deste arquivo.</div>";
                }
            
                if($file_size > 2097152){
                    $erro="<div class='alert alert-warning' role='alert'> Arquivo deve ser menor que 2 MB.</div>"; // o cmdb tem um pouco mais de 1Mb 
                }
            
                if(empty($erro)==true){
                    move_uploaded_file($file_tmp,"../upload/".$novo_nome); // move e renomeia o arquivo, com concatenação.
                    // move_uploaded_file($_FILES['myFile']['tmp_name'], '/upload_files/myFile.txt');
                    sleep(2);
                    // Atribui o conteúdo do arquivo para variável $arquivo
                    $arquivo = file_get_contents('../upload/cmdb.json');
                    //sleep(1);

                    // Decodifica o formato JSON e retorna um Objeto
                    $json = json_decode($arquivo);

                    // FIXME:       // TODO:  Arrumar os codigos , excluir o não usado
                    if(!empty($json)){
                        // Deleta a tabela cmdb
                        $sql_drop_table = 'DROP TABLE IF EXISTS tb_cmdb'; // Deleta a tabela toda, tem que usar o CREATE
                        $sql_delete_table = 'DELETE FROM tb_cmdb'; // Limpa toda a tabela
                        $sql_truncate_table = 'TRUNCATE TABLE tb_cmdb RESTART IDENTITY'; // Limpa toda a tabela
                        $sql_last_id  = "SELECT max(id) FROM tb_cmdb";
                        $sql_renomear_table = "ALTER TABLE tb_cmdb RENAME TO tb_cmdb1" ; 
                        $sql_drop_table1 = 'DROP TABLE IF EXISTS tb_cmdb';
                        $sql_create_table = 'CREATE TABLE IF NOT EXISTS tb_cmdb (
                            operadora varchar(100),
                            cliente varchar(100),
                            velocidade varchar(50),
                            uf varchar(10),
                            contato text,
                            endereco text, 
                            designacao varchar(50),
                            loopback varchar(20),
                            cir varchar(20),
                            nome varchar(100), 
                            hostname varchar(50)
                        )';

                        $connection->beginTransaction();
                        //$stm = $connection->prepare($sql_delete_table);
                        //$stm->execute();
                        $retorno = $connection->exec($sql_drop_table);
                        //$retorno = $connection->exec($sql_renomear_table);
                        //$connection->commit();
                        sleep(5);
                        //$stm->execute();
                        //$connection->beginTransaction();
                        $retorno = $connection->exec($sql_create_table);
                        $connection->commit();
                        sleep(5);

                        // Loop para percorrer o Objeto                
                        foreach ($json->data as $registro){
                            // Colocar os códigos para gravar no banco
                            $operadora = $registro->OPERADORA;
                            $cliente = $registro->CLIENTE;
                            $velocidade = $registro->VELOCIDADE_VPN;
                            $uf = $registro->UF;
                            $contato = $registro->INFOCONTATO;
                            $endereco = $registro->ENDERECO;
                            $designacao = trim($registro->DESIGNACAO);
                            $loopback = trim($registro->IP_LOOPBACK);
                            $cir = trim($registro->IUR_CIRCUITO2);
                            $nome = trim($registro->NOME);
                            $hostname = trim($registro->HOSTNAME2);  
                            
                            $buscar=$connection->prepare("SELECT * FROM tb_cmdb WHERE cir LIKE ?");
                            $buscar->bindValue(1, "%" . $cir . "%");
                            $buscar->execute();
                            $resultado = $buscar->fetchAll(PDO::FETCH_ASSOC);
                            //print_r($resultado[0]); 

                            if(isset($resultado[0]["cir"])){
                                continue;
                            }else{
                                // Grava no banco as localidades com os dados de contato, circuito, etc...
                                $sql = "INSERT INTO tb_cmdb (operadora, cliente, velocidade, uf, contato, endereco, designacao, loopback, cir, nome, hostname) VALUES(:operadora, :cliente, :velocidade, :uf, :contato, :endereco, :designacao, :loopback, :cir, :nome, :hostname)";			
                                $stm = $connection->prepare($sql);
                                //$stm->bindParam(':id', $id_banco, PDO::PARAM_INT);
                                $stm->bindParam(':operadora', $operadora, PDO::PARAM_STR);
                                $stm->bindParam(':cliente', $cliente, PDO::PARAM_STR);
                                $stm->bindParam(':velocidade', $velocidade, PDO::PARAM_STR);            
                                $stm->bindParam(':uf', $uf, PDO::PARAM_STR);
                                $stm->bindParam(':contato', $contato, PDO::PARAM_STR);
                                $stm->bindParam(':endereco', $endereco, PDO::PARAM_STR);
                                $stm->bindParam(':designacao', $designacao, PDO::PARAM_STR);
                                $stm->bindParam(':loopback', $loopback, PDO::PARAM_STR);
                                $stm->bindParam(':cir', $cir, PDO::PARAM_STR);
                                $stm->bindParam(':nome', $nome, PDO::PARAM_STR);
                                $stm->bindParam(':hostname', $hostname, PDO::PARAM_STR);
                                $stm->execute();
                            }    
                        // echo 'Código: ' . $operadora . ' - Nome: ' . $nome . '<br>';                        
                        // FIXME:       // TODO: Terminar o código de inserção na tabela cmdb                        
                        } // Fecha foreach
                    }else{
                        $retorno = "<div class='alert alert-warning' role='alert'> Não foi possível gravar o arquivo!</div>";
                        echo $retorno;
                    }                        
                    // FIXME:       // TODO:   Arrumar o retorno de erro em um alert bootstrap ou javascript
                    sleep(4);
                    $retorno = "<div class='alert alert-success' role='alert'> Gravado com sucesso!</div>";
                    echo $retorno;                    
                }else{
                    echo $erro;
                }
        }
        $connection=null; // Fecha a conexão aberta 
    } catch (Exception $e){
        echo "Erro: ". $e->getMessage()."<br>";
        $connection=null; // Fecha a conexão aberta mesmo se der erro
    } //finally {
        //$connection=null; // Fecha a conexão aberta mesmo se der erro
    //}

?>