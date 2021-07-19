<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    <title>Diário | Localidades</title>
    <link rel="shortcut icon" href="img/faviconazulclaro.ico"  />
    <!-- <link rel="shortcut icon" href="img/serpro4.png"  /> -->
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/jquery/jquery-ui.min.css">

    <!-- CSS dateTimePicker --> 
    <link rel="stylesheet" href="assets/jquery/jquery.datetimepicker.min.css">
    
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="css/main.css">  
      
    <!-- Custom fonts for this template-->
    <link href="assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">    
    
    <!-- material.io/resources/icons/?icon=add_to_queue&style=outline -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 

    <style>
    </style>

    <script>
    </script>
    
  </head>
    
  <body> 
     <header>
     <h3 class='text-center'></h3>
     </header>    
      
    <div class="container">
    <!--<div class="container-fluid py-3">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 align='center'>Localidades</h1>            
                <!--<button id="btnNovo" type="button" class="btn btn-info" data-toggle="modal"><i class="material-icons">library_add</i></button>-->
                <button id="btnNovo" type="button" class="btn btn-info" data-toggle="modal"><i class="fas fa-plus fa-sm text-white-50"></i> Nova Localidade
                    <i class='fas fa-globe' style='font-size:48px;color:#75D6FF'></i>
                </button>
            </div>            
        </div>    
    </div>    
    <br>  
    <!-- <div class="container-fluid py-3 caja"> Usar esta config para ocupar tela inteira -->
    <!--<div class="container-fluid py-3">-->
    <div class="container caja">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">  
                    <div>                    
                        <h6>Esconder coluna:</h6>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <!--<button type="button" class="btn btn-outline-primary toggle-vis" data-column="0">Id</button>-->
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="0">Id</button>
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="1">Localidade</button>
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="2">Equipe</button>
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="3">Cliente</button>
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="4">Demanda</button>
                            <button type="button" class="btn btn-outline-primary toggle-vis" data-column="5">Ultima Atual.</button>
                        </div>
                        <hr>
                    </div>      
                    <table id="crudlocalidades" class="table table-striped table-bordered table-condensed" style="width:100%" >
                        <thead class="text-center">
                            <tr>
                                <!--
                                Comentar o id e o botão do id. Lá no main.js => comentar order e descomentar ordering: false e vira ordenado do banco
                                com o select    https://datatables.net/reference/option/ordering

                                <th>Id</th> esta também no main.js e acima nos botões
                                {"data": "id"}, Exemplo comentar para tirar o id e mesmo assim vir ordenado
                                "order": [[0, 'desc']],
                                //"ordering": false,
                                -->
                                <th>Id</th>
                                <th>Localidade</th>
                                <th>Equipe</th>
                                <th>Cliente</th>                                
                                <th>Demanda</th>  
                                <th>Ultima Atual</th>
                                <th>Situação</th>
                                <th>Ações.</th>
                            </tr>
                        </thead>
                        <tbody>                           
                        </tbody>        
                    </table>               
                </div>
            </div>
        </div>  
    </div>   

    <!--Modal para Adicionar/Editar Localidade -->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <!-- <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document"> -->
        <!-- <div class="modal-dialog " role="document"> --> 
        <!-- <div class="modal-dialog modal-lg" role="document"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="formLocalidades" autocomplete="off">    
                <div class="modal-body ">
                    <!-- Botões de menu -->
                    <div class="row" id="row_inicial" >
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <hr>
                                <div class="btn-group" role="group" aria-label="Exemplo básico">
                                    <button type="button" class="btn btn-outline-success" id='atualizacao_primeiro'>Atualizações</button>
                                    <button type="button" class="btn btn-outline-success" id='documento'>Documentos</button>
                                    <button type="button" class="btn btn-outline-success" id='acionamento'>Acionamentos</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                    </div>
                    <!-- Segunda linha -->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>IP:</b></label>
                                <input type="text" class="form-control" id="ip">
                                <input type="hidden" id="id_localidadeModal" name="id_localidadeModal" >
                            </div>               
                        </div>
                        <div class="col-lg-6">
                            <span id="listagem"></span>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="col-form-label" id="busca_label"><b>Buscar:</b></label>
                                <input type="text" class="form-control" id="busca">
                            </div>
                        </div>  
                    </div>
                    <!-- terceira linha -->
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Localidade:</b></label>
                                <input type="text" class="form-control" id="localidade">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Hostname:</b></label>
                                <input type="text" class="form-control" id="hostname">
                            </div> 
                        </div>    
                    </div>
                    <!-- quarta linha -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Designação:</b></label>
                                <input type="text" class="form-control" id="designacao">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Operadora:</b></label>
                                <input type="text" class="form-control" id="operadora">
                            </div> 
                        </div>  
                    </div>
                    <!-- quinta linha -->
                    <div class="row"> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="uf"><b>UF:</b></label>
                                <select class="form-control" id="uf" name="uf">
                                    <option value="AC">ACRE</option>
                                    <option value="AL">ALAGOAS</option>
                                    <option value="AP">AMAPÁ</option>
                                    <option value="AM">AMAZONAS</option>
                                    <option value="BA">BAHIA</option>
                                    <option value="CE">CEARÁ</option>
                                    <option value="ES">ESP. SANTO</option>
                                    <option value="GO">GOIÁS</option>
                                    <option value="MA">MARANHÃO</option>
                                    <option value="MT">MATO GROSSO</option>
                                    <option value="MS">MATO GROSSO S.</option>
                                    <option value="MG">MINAS GERAIS</option>
                                    <option value="PA">PARÁ</option>
                                    <option value="PB">PARAÍBA</option>
                                    <option value="PR">PARANÁ</option>
                                    <option value="PE">PERNAMBUCO</option>
                                    <option value="PI">PIAUÍ</option>
                                    <option value="RJ">R. DE JANEIRO</option>
                                    <option value="RN">R. GRANDE DO N.</option>
                                    <option value="RS">R. GRANDE DO S.</option>
                                    <option value="RO">RONDÔNIA</option>
                                    <option value="RR">RORAIMA</option>
                                    <option value="SC">S. CATARINA</option>                                    
                                    <option value="SP" selected>SÃO PAULO</option>
                                    <option value="SE">SERGIPE</option>
                                    <option value="TO">TOCANTINS</option>
                                    <option value="DF">DIST. FEDERAL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="reg"><b>Regional:</b></label>
                                <select class="form-control" id="reg" name="reg">
                                    <option value="BRA" selected>BRA</option>
                                    <option value="AC">ACRE</option>
                                    <option value="BSA">BSA</option>
                                    <option value="3">item3</option>
                                    <option value="4">item4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="equipe"><b>Equipe:</b></label>
                                <select class="form-control" id="equipe" name="equipe">
                                    <option value="GSOPBRMON2" selected>GSOPBRMON2</option>
                                    <option value="GSOPBRMON1">GSOPBRMON1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="cliente"><b>Cliente:</b></label>
                                <select class="form-control" id="cliente" name="cliente">  
                                    <!-- Carrega o select por $.get no atualizacao.js -->                                  
                                </select>
                            </div>
                        </div>   
                    </div>
                    <!-- sexta linha -->
                    <div class="row">
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Orgão Gestor:</b></label>
                                <input type="text" class="form-control" id="og">
                            </div>            
                        </div> 
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Demanda:</b></label>
                                <input type="text" class="form-control" id="demanda">
                            </div>
                        </div>    
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>data:</b></label>
                                <input type="text" class="form-control" id="tempo_atualizacao">
                            </div>            
                        </div>    
                    </div>
                    <!-- sétima linha -->
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Solução aplicada:</b></label>
                                <input type="text" class="form-control" id="solucao">
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="" class="col-form-label" id="demo"><b>Situação:</b></label>
                                <select class="form-control" id="situacao" name="situacao">
                                    <option value="Aberto" selected>Aberto</option>
                                    <option value="Fechado">Fechado</option>
                                    <option value="Transferido">Transferido</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Aguarda Cliente">Aguarda Cliente</option>
                                </select>
                            </div>
                        </div> 
                    </div>
                    <!-- Oitava linha -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-form-label"><b>Serviço:</b></label>
                                <select class="form-control" id="servico" name="servico">
                                    <!-- Carrega o select por $.get no atualizacao.js -->
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-6" id="row_final">
                            <div class="form-group">
                                <hr>
                                <div class="btn-group" role="group" aria-label="Exemplo básico">
                                    <button type="button" class="btn btn-outline-success" id='atualizacao_segundo'>Atualizações</button>
                                    <button type="button" class="btn btn-outline-success" id='documento'>Documentos</button>
                                    <button type="button" class="btn btn-outline-success" id='acionamento'>Acionamentos</button>
                                </div>
                            </div>
                        </div> 
                    </div>

                </div>
                <!-- Botões de rodapé do Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal" >Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-outline-success">Gravar</button>
                </div>
            </form>    
            </div>
        </div>
    </div>   


<!-- ==============      Segundo Modal atualizações, documentos e acionamentos        ======================= -->    

    <!--Modal para CRUD-->
    <div class="modal fade" id="modal_atualizacoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modal-headerAtualizacoes" >
                    <h5 class="modal-title" id="atualizacoesModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form id="formAtualizacoes" autocomplete="off">  
                        <div class="row">
                    <!-- primeira linha -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Id Localidade:</b></label>
                                    <input type="text" class="form-control" id="idModalAtualizacoesdois" name="ipModalAtualizacoesdois">
                                    <input type="hidden" id="idModalAtualizacoesHidden" name="ipModalAtualizacoesHidden" >
                                </div>               
                            </div>
                            <div class="col-lg-6">                                
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">                                   
                                </div>
                            </div>  
                        </div>

                        <!-- segunda linha -->
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Localidade:</b></label>
                                    <input type="text" class="form-control" id="localidadeModalAtualizacoes">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Hostname:</b></label>
                                    <input type="text" class="form-control" id="hostnameModalAtualizacoes">
                                </div> 
                            </div>    
                        </div>
                        <!-- terceira linha -->
                        <div class="row">
                            <div class="col-lg-3">              
                            </div>
                            <div class="col-lg-7">                                
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-success" id="novaAtualizacao" >Nova Atualização</button>
                                </div>
                            </div>  
                        </div>
                    </form> 
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">Ordem:</th>
                                <th scope="col">Usuário:</th>
                                <th scope="col">Atualizações:</th>
                                <th scope="col" lign="right" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <!-- espaço para inserir a table de atualização -->
                        <tbody id="lista_atualizacao">                            
                        </tbody>
                    </table>
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div> 


<!-- ==============          Fim do segundo modal       ================================ --> 
<!-- ==============           Terceiro modal            ================================ -->  


    <!--Modal para CRUD-->
    <div class="modal fade" id="modal_novaAtualizacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modal-headerNovaAtualizacao" >
                    <h5 class="modal-title" id="novaAtualizacaoModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form id="formNovaAtualizacao" autocomplete="off">  
                        <!-- primeira linha -->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Id Localidade:</b></label>
                                    <input type="text" class="form-control" id="idNovaModalAtualizacaoHiddendois" name="idNovaModalAtualizacaoHiddendois">
                                    <input type="hidden" id="idNovaModalAtualizacaoHidden" name="idNovaModalAtualizacaoHidden" >
                                    <input type="hidden" id="idAtualizacao" name="idAtualizacao" >
                                    <input type="hidden" id="existeAtualizacao" name="existeAtualizacao" >
                                </div>               
                            </div>
                            <div class="col-lg-6">                                
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">                                   
                                </div>
                            </div>  
                        </div>
                        <!-- segunda linha -->
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Localidade_Atualização:</b></label>
                                    <input type="text" class="form-control" id="nova_atualizacao_localidade">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Hostname_Atualização:</b></label>
                                    <input type="text" class="form-control" id="nova_atualizacao_hostname">
                                </div> 
                            </div>    
                        </div>
                        <!-- terceira linha -->
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Ordenar:</b></label>
                                    <input type="text" class="form-control" id="nova_atualizacao_ordenar">
                                </div> 
                            </div> 
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label for="" class="col-form-label"><b>Inserir Atualização:</b></label>
                                    <textarea class="form-control" id="nova_atualizacao_Textarea" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- quarta linha -->
                        <div class="row">
                            <div class="col-lg-3">              
                            </div>
                            <div class="col-lg-7">                                
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-success" id="gravarAtualizacao" >Gravar Atualização</button>
                                </div>
                            </div>  
                        </div>
                    </form> 
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div> 
<!-- ==============          Fim do Terceiro modal      ================================ --> 

<!-- ==============          Includes          ================================ -->

<?php 
    include_once 'models/atualizacoes/modal_verificar_ultima_atualizacao.html';
?>

<!-- ==============          Fim dos includes          ========================= -->  

    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/jquery/jquery-ui.min.js"></script>
    <!-- JS dateTimePicker -->
    <script src="assets/jquery/jquery.datetimepicker.full.js"></script>
    <!-- <script src="assets/custom.js"></script> -->
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="assets/datatables/datatables.min.js"></script>    
    
    <!-- script do diario -->

    <script type="text/javascript" src="js/main.js"></script> 
    <script type="text/javascript" src="js/atualizacao.js"></script>
    <script type="text/javascript" src="js/autocomplete.js"></script> 
    
    
  </body>
</html>
