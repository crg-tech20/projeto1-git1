$(document).ready(function() {
var option;
option = 4;

//#################################################################################################### 
//#########                           Definições para o DataTables                         ########### 
//####################################################################################################
// Definições para o DataTables ====================================================================
        crudlocalidades = $('#crudlocalidades').DataTable({  
            "lengthMenu":[[10,5,25,50,-1],[10,5,25,50, "All"]], // Quantidade resultados por página, valores.
            "ajax":{            
                "url": "controlers/crud_localidades.php", 
                "method": 'POST', //usamos metodo POST
                "data":{option:option}, //enviamos option 4 para um SELECT no banco de dados
                "dataSrc":""
            },
            "columns":[
                {"data": "id"},
                //{"data": "id"}, Exemplo comentar para tirar o id e mesmo assim vir ordenado
                {"data": "localidade"},
                {"data": "equipe"},
                {"data": "cliente"},
                {"data": "demanda"},
                {"data": "tempo_atualizacao"},
                {"data": "situacao"},
                //{"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-outline-primary btn-sm btnEditar'><i class='material-icons'>edit</i>Atualizações</button><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm deletar'><i class='material-icons'>delete</i></button></div></div>"}
                {
                    "data": "id", // usa o id para colocar nos botões
                    render:function(data, type, row)
                    {
                        // Função usada para colocar o id no botão para posterior coleta no id = $(this).attr("id");
                    return '<div class="text-center"><div class="btn-group">\
                            <button class="btn btn-outline-primary btn-sm btnEditar" id="'+data+'" title="Editar a Localidade!" ><i class="fas fa-home"></i></button>\
                            <button class="btn btn-outline-primary btn-sm btnEditar1" id="inserirAtualizacaoCRUDLocalidades" onclick="inserirAtualizacaoCRUDLocalidades('+data+')" title="Nova Atualização!"><i class="fas fa-edit"></i></button>\
                            <button class="btn btn-outline-primary btn-sm btnEditar1" id="inserirDocumentosCRUDLocalidades" onclick="inserirDocumentosCRUDLocalidades('+data+')" title="Inserir Documentos!"><i class="fas fa-book"></i></button>\
                            <button class="btn btn-outline-primary btn-sm btnEditar1" id="inserirAcionamentosCRUDLocalidades" onclick="inserirAcionamentosCRUDLocalidades('+data+')" title="Inserir Acionamentos!"><i class="fas fa-people-arrows"></i></i></button>\
                            <button class="btn btn-danger btn-sm deletar" id="'+data+'" title="Deletar a Localidade!"><i class="fas fa-trash-alt"></i></button>\
                            </div></div>';
                    },
                    "targets": -1
                }
                
                
            ],    
            // Formatação de linguagens
            "order": [[0, 'desc']],  // 0 -> significa ordenar pelo primeiro campo ao array ==> id. (comentar // para ordenar pelos select do banco)
            //"ordering": false, // Exemplo comentar para tirar o id e mesmo assim vir ordenado, deve ser comentado o order acima de descomentar este
            // https://datatables.net/reference/option/ordering
            "language":  {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                }
            }
        });   
        
//#################################################################################################### 
//#########                    Fim das Definições para o DataTables                        ########### 
//####################################################################################################

        var fila; //captura o modal, para editar o eliminar

        // xxxxxxxxxxx Acionando o submit, para novo item ou editar. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        // FIXME: //submit para atualização, pega os dados da modal atualização e grava no banco
        //  após acionar o submit, novo / editar
        $('#formLocalidades').submit(function(e){                         
            e.preventDefault(); //evita o comportamento normal de submit do formulario e recarrega a pagina

            id = $.trim($('#id_localidadeModal').val());
            localidade = $.trim($('#localidade').val());
            hostname = $.trim($('#hostname').val());
            designacao = $.trim($('#designacao').val()); 
            ip = $.trim($('#ip').val());
            uf = $.trim($('#uf').val());
            reg = $.trim($('#reg').val());
            og = $.trim($('#og').val());
            equipe = $.trim($('#equipe').val());
            cliente = $.trim($('#cliente').val());
            demanda = $.trim($('#demanda').val());
            solucao = $.trim($('#solucao').val());
            situacao = $.trim($('#situacao').val());
            operadora = $.trim($('#operadora').val());
            servico = $.trim($('#servico').val());
            tempo_atualizacao = $.trim($('#tempo_atualizacao').val());

            if(og === ""){og = equipe;}
            if(operadora === ""){operadora = "SEM OPERADORA";}

        // FIXME:  
        // TODO: -   

            //alert(situacao+' - id:'+id);
                $.ajax({
                    url: "controlers/crud_localidades.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {
                        option: option, 
                        localidade:localidade, 
                        hostname: hostname,
                        designacao: designacao,
                        ip: ip,
                        uf: uf,
                        reg: reg,
                        og: og,
                        equipe: equipe,
                        cliente: cliente,
                        demanda: demanda,
                        solucao: solucao,
                        servico: servico,                
                        operadora: operadora,
                        situacao: situacao,
                        tempo_atualizacao: tempo_atualizacao,
                        id: id
                    },    
                    success: function(data) {
                    crudlocalidades.ajax.reload(null, false);
                    }
                });			        
            $('#modalCRUD').modal('hide');	    									     			
        });
                
        // xxxxxxxxxxx Acionando novo item. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx 
        // FIXME:  - 
        // TODO:
        // Setar as cores e titulos do modal novo
        $("#btnNovo").click(function(){

            // Esconde os botões de atualizações, documentos e acionamentos
            $("#row_inicial, #row_final").hide();
            option = 1; // Opção de inserir no banco, novo registro           
            user_id=null;
            $('#tempo_atualizacao').prop('readonly', false);
            $('#busca').prop('readonly', false); // torna o campo de busca somente leitura, quando for editar, se for novo e false
            //$('#busca').remove();
            $("#formLocalidades").trigger("reset");
            $(".modal-header").css( "background-color", "#17a2b8");
            $(".modal-header").css( "color", "white" );
            $(".modal-title").text("Cadastro de Localidades:");
            
            // FIXME: - 
            $('#modalCRUD').modal('show');	    
        });


        // xxxxxxxxxxx Acionando o editar. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        //Editar, usa a classe .btnEditar    
        // FIXME:  
        // TODO: - fazer um $.post() para buscar o id e trocar no modal, buscar uma localidade especifica.    
        $(document).on("click", ".btnEditar", function(){	

                // Mostra os botões de atualizações, documentos e acionamentos
                $("#row_inicial, #row_final").show();
                //console.log($(this).attr("id"));	        
                option = 2;//editar
                fila = $(this).closest("tr");
                id = $(this).attr("id"); // Pega o valor do atributo id no btnEditar, que esta setado para o id que vem do banco      

                // limpa os campos no formulário editar
                $('#id_localidadeModal').val('');
                $('#busca').val('');
                $('#ip').val('');
                $('#localidade').val('');
                $('#hostname').val('');
                $('#designacao').val('');
                $('#uf').val('');
                $('#cliente').val('');
                $('#operadora').val('');
                
                option = 5; // carregar os dados no modal
                //var obj;
                $.ajax({
                    url: "controlers/crud_localidades.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {option:option, id:id},   
                    success: function(retorno) {
                        alert(retorno);
                        var obj = JSON.parse(retorno);
                        //console.log(obj[0].id);
                        
                        // Preenche os dados do Modal Editar
                        $("#ip").val(obj[0].ip);
                        $("#id_localidadeModal").val(obj[0].id);
                        $("#localidade").val(obj[0].localidade);
                        $("#hostname").val(obj[0].hostname);
                        $("#designacao").val(obj[0].designacao);
                        $("#operadora").val(obj[0].operadora);
                        $("#servico").val(obj[0].servico);
                        $("#uf").val(obj[0].uf);
                        $("#reg").val(obj[0].reg);
                        $("#equipe").val(obj[0].equipe);
                        $("#cliente").val(obj[0].cliente);
                        $("#og").val(obj[0].og);
                        $("#demanda").val(obj[0].demanda);
                        $("#tempo_atualizacao").val(obj[0].tempo_atualizacao);
                        $("#solucao").val(obj[0].solucao);
                        option = 2;
                    }
                });	

                // Define cores, label e remove o campo busca
                $('#busca').prop('readonly', true); // torna o item não editável.
                //$('#busca, #busca_label').remove(); // remove o item
                $('#tempo_atualizacao').prop('readonly', true);
                $(".modal-header").css("background-color", "#007bff");
                $(".modal-header").css( "color", "white" );
                $(".modal-title").text("Editar a Localidade:");		
                $('#modalCRUD').modal('show');	
                //alert(situacao);	   
        });

        // xxxxxxxxxxx Acionando o deletar. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        //Deletar localidade
        $(document).on("click", ".deletar", function(){
            fila = $(this); 
            id = $(this).attr("id"); // Pega o valor do atributo id, que esta setado para o id que vem do banco		
            option = 3; //eliminar        
            var resposta = confirm("Deseja deletar o registro "+id+"?");                
            if (resposta) {            
                $.ajax({
                url: "controlers/crud_localidades.php",
                type: "POST",
                datatype:"json",    
                data:  {option:option, id:id},    
                success: function() {
                    crudlocalidades.row(fila.parents('tr')).remove().draw();                  
                }
                });	
            }
        });
        
});

//#######################################################################
//#########                    Funções                        ########### 
//#######################################################################

// Recarregar as localidades a cada 30 segundos, para manter tudo atualizado.
function recarregar(){
    crudlocalidades.ajax.reload(null, false);
}

// Função para verificar se necessita atualizar a localidade
function verIntervaloAtualizacao(){
    // Pega os dados da última atualização
    //var mostrar = 0;
    $.ajax({
        url: "controlers/verificar_ultima_atualizacao.php",
        type: "POST",
        datatype:"json",    
        data:  {option:1},   
        success: function(retorno) { 

            alert(retorno);
            var obj = JSON.parse(retorno);
            //alert(obj['qtde_linhas']);
            var dados = obj['dados'];
            //alert(dados[0].localidade);
            //alert(obj['dados'][0].localidade + obj['dados'][0].tempo_atualizacao);
            for (var i = 0; i < obj['qtde_linhas']; i++) {
               // alert(dados[i].localidade);
               // alert(dados[i].tempo_atualizacao);
            }
            //alert(obj['html']);
            $('#quantidadeAtualizar').value(obj['qtde_linhas']);
            $('#necessarioAtualizar').html(obj['html']);
        }
    }); 



} // Fecha => function verIntervaloAtualizacao()

// Chama a função recarregar 
setInterval(recarregar, 30000); //Tempo de 30 segundos

// Chama a função que verifica se necessita atualização com intervalo de tempo de 30 segundos
setInterval(verIntervaloAtualizacao, 30000); //Tempo de 30 segundos




