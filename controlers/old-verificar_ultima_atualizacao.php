<?php
include_once '../bd/connection.php';
include_once 'funcoes.php';

/*     
    - Arquivo para coletar as localidades que necessitam atualizar,
    - Faz uso de funções que estão no controlers/funcoes.php
*/

// Pega a conexão
$objeto = new Connection();
$connection = $objeto->Conectar();

// Dados vindos das solicitações ajax.
$option = (isset($_POST['option'])) ? trim($_POST['option']) : 1;

try {

    switch($option){  

        // OK - Verifica se a localidade precisa atualização, retorna as com horários divergentes.

        case 1:
            // Verifica se a localidade precisa atualização, retorna as com horários divergentes.
            $tempo_maior = get_time_larger(); // Pega o tempo atual menos uma hora e meia, esta no controlers/funcoes.php
            $sql  = "SELECT localidade, tempo_atualizacao FROM tb_localidades WHERE tempo_atualizacao < {$tempo_maior} ORDER BY id DESC"; 
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $data = $stmt->FetchAll(PDO::FETCH_OBJ);
            $qtde_linhas = $stmt->rowCount(); // conta a quantidade de linhas retornada na consulta.


            $retorno['qtde_linhas'] = $qtde_linhas;
            $retorno['dados'] = '';

            if ($qtde_linhas > 0){
                
                foreach($data as $row){
                    $row->tempo_atualizacao = timestamp_DateStr($row->tempo_atualizacao);
                }


                $retorno['dados'] = $data;
                $retorno['html'] = '';
                $montar = '';
                foreach($data as $reg):
                    $montar .= "<a class='dropdown-item d-flex align-items-center' href='#'><div class='mr-3'><div class='icon-circle bg-warning'>";
                    $montar .= "<i class='fas fa-file-alt text-white'></i></div></div>";
                    $montar .= "<div><div class='small text-gray-500'>{$reg->tempo_atualizacao}</div>";
                    $montar .= "<span class='font-weight-bold'>{$reg->localidade}</span></div></a>";
                endforeach;                    
                $retorno['html'] = $montar;
          
            } else {
                $retorno = 0; // especifica o retorno como 0, será pego no main.js e tratado como retorno em function verIntervaloAtualizacao()
            }   
          
            //$tempo_maior = get_time_larger();

            //$tempo_maior = json_encode($tempo_maior);// envia o array no formato json AJAX
            $retorno = json_encode($retorno);// envia o array no formato json AJAX
            //sleep(5);            
            echo $retorno; // retorno zero ou um html montado com as localidades.
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
