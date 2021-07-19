$(document).ready(function() {

    // Campo de DateTimePicker do Modal - selecionar datas
    $("#tempo_atualizacao").datetimepicker({
        format:'d/m/Y H:i',
        step: 2
    });
    /* $("#datetime,#datetime1").datetimepicker({
        format:'d/m/Y H:i:s',
        step: 2
    });
    */

    
    // Chama a função pra carregar o select de serviços e clientes
    carregarSelectServico();
    carregarSelectCliente();
    
    // FIXME:  // Inserindo a table de atualizações.
    // TODO:  Segundo Modal atualizações
        $("#atualizacao_primeiro, #atualizacao_segundo").click(function(){
            // pega o id da localidade para ser usado
            id_localidade = $.trim($('#id_localidadeModal').val()); // funcionando.
            localidade_atualizacao = $.trim($('#localidade').val());
            hostname_atualizacao = $.trim($('#hostname').val());
            // Limpa o formulário para novas atualizações
            $("#formAtualizacoes").trigger("reset");
    
            // Pega a lista de atualizações para a localidade em questão
            carregarListaAtualizacoes(1, id_localidade);
            
            // Limpa os campos
            $('#idModalAtualizacoesHidden').val('');
            $('#idModalAtualizacoesdois').val('');
            $('#localidadeModalAtualizacoes').val('');
            $('#hostnameModalAtualizacoes').val('');
            $("#formControlTextarea").css( "resize", "none" ); // trava o resize na vertical e horizontal
    
            // coloca os valores nos campos do form, vindos da localidade sendo atualizada
            $('#idModalAtualizacoesHidden').val(id_localidade);
            $('#idModalAtualizacoesdois').val(id_localidade);
            $('#localidadeModalAtualizacoes').val(localidade_atualizacao);
            $('#hostnameModalAtualizacoes').val(hostname_atualizacao);
    
            // torna o campo de localidade e hostname somente leitura, true ou false
            $('#localidadeModalAtualizacoes').prop('readonly', true);
            $('#idModalAtualizacoesdois').prop('readonly', true); 
            $('#hostnameModalAtualizacoes').prop('readonly', true); 
    
            // define as cores do modalAtualizacoes
            $("#modal-headerAtualizacoes").css( "color", "white" );
            $("#modal-headerAtualizacoes").css("background-color", "#007bff");
            $("#atualizacoesModalLabel").text("Atualizações:");
            
            // Mostra a modal
            $('#modal_atualizacoes').modal('show');	
    
            // FIXME: imprimir o id para testes e configurações
            alert("Id: " + id + " - Localidade: " + localidade_atualizacao + " - Hostname: " + hostname_atualizacao); // estou pegando o id da localidade e mostrando com alert, esta funcionando.
            idteste = $('#idModalAtualizacoesHidden').val();
            //idteste = $.trim($('#ipModalAtualizacoes').val());
            alert('ID hidden: '+ idteste);
    
        });
    
        // OK - Terceiro Modal atualizações
        $("#novaAtualizacao").click(function(){
    
            // Define o título do modal
            $("#novaAtualizacaoModalTitle").text("Nova Atualização:");

            // Marca como 0 para nova atualização e como 1 para editar atualização
            $('#existeAtualizacao').val('0');
            $('#idAtualizacao').val('0');

            // trava o resize na vertical e horizontal
            $("#nova_atualizacao_Textarea").css( "resize", "none" ); // trava o resize na vertical e horizontal
            
            // Limpa os campos
            $('#nova_atualizacao_Textarea').val('');
    
            // pega os dados da localidade para ser usado
            id_novaAtualizacaoLocalidade = $.trim($('#idModalAtualizacoesHidden').val());
            localidade_novaAtualizacao = $.trim($('#localidadeModalAtualizacoes').val());
            hostname_novaAtualizacao = $.trim($('#hostnameModalAtualizacoes').val());
    
            // Insere nos campos os dados não editáveis
            $('#idNovaModalAtualizacaoHiddendois').val(id_novaAtualizacaoLocalidade);
            $('#nova_atualizacao_localidade').val(localidade_novaAtualizacao);
            $('#nova_atualizacao_hostname').val(hostname_novaAtualizacao);
    
            // Carrega o proximo id de ordenar para a nova atualização.
            carregarOrdenarAtualizacoes(3, id_novaAtualizacaoLocalidade);
    
            // torna o campo de localidade e hostname somente leitura, true ou false
            $('#idNovaModalAtualizacaoHiddendois').prop('readonly', true);
            $('#nova_atualizacao_localidade').prop('readonly', true); 
            $('#nova_atualizacao_hostname').prop('readonly', true);        
    
            // Definindo a data para o campo de atualização.
            var d = new Date();
            var months = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
            var mes = months[d.getMonth()];
            var dia = d.getDate();
            var ano = d.getFullYear();
            var data_string = dia + "/" + mes + "/" + ano + " - " ;
            var data_string = data_string.toString();
    
            // Insere a data no campo de atualização.
            $('#nova_atualizacao_Textarea').val(data_string);
    
            // Mostra a modal
            $('#modal_novaAtualizacao').modal('show');
            //alert(data_string);
    
        });
    
        // OK - Modal gravar atualização, ao clicar no botão gravar atualização.
        $("#gravarAtualizacao").click(function(){
            id_localidade = $.trim($('#idNovaModalAtualizacaoHiddendois').val());
            nova_ordenar = $.trim($('#nova_atualizacao_ordenar').val());
            nova_atualizacao = $.trim($('#nova_atualizacao_Textarea').val());        
    
            // Pega o tipo de atualização, nova ou editar uma já inserida
            // Marcada como 0 para nova atualização e como 1 para editar atualização
            let editar = $.trim($('#existeAtualizacao').val());
            let idAtualizacao = $.trim($('#idAtualizacao').val());

            // Sendo nova ou edição de atualizações, executa o gravarAtualizacoes, com option diferentes.
            if(editar == 1 && idAtualizacao != 0){
                alert("edição ");
                alert(idAtualizacao);
                gravarAtualizacoes(6, id_localidade, nova_ordenar, nova_atualizacao, idAtualizacao);
                // Atualiza o banco de dados com a edição da atualização
            } else { 
                alert("nova_atualizaçao");
                alert(idAtualizacao);
                // Atualiza o banco de dados com nova atualização
                gravarAtualizacoes(2, id_localidade, nova_ordenar, nova_atualizacao, idAtualizacao);
            }
            
    
            // Limpa os campos
            $('#nova_atualizacao_Textarea').val('');
            $('#nova_atualizacao_ordenar').val('');
    
            // Esconde o Modal
            $('#modal_novaAtualizacao').modal('hide');
    
        });
    
        // OK - Deletar atualização
        $(document).on("click", ".deletarAtualizacao", function(){
    
            //var apagar = $(this); 
            id = $(this).attr("id"); // Pega o valor do atributo id, que esta setado para o id que vem do banco		
            option = 4; //eliminar 
            alert(id);
    
            var resposta = confirm("Deseja deletar o registro "+id+"?"); 
            //$('#modal_atualizacoes').modal('hide');               
            if (resposta) { 
                // remove a linha da tabela selecionada no html
                var remover = $(this).parent().parent().remove(); // o Button esta dentro de uma TD que esta dentro de uma TR 
                // remove a linha do banco         
                $.ajax({
                    url: "controlers/carregar_atualizacoes.php",
                    type: "POST",
                    //datatype:"json",    
                    data:  {option:option, id:id},    
                    success: function() {
                        $('#lista_atualizacao').html(retorno);  // recarrega a lista atualizada.              
                    }
                });	
            }
        }); 

});
    
//#################################################################################################### 
//######### FIXME:                          Funções JS                                     ########### 
//####################################################################################################
//=========================================================================
// FIXME:  ===============    Funções JS    =======================================
// TODO: 

    // Carrega a lista de serviços no select
    function carregarSelectServico() {
    
        //document.getElementById("demo").innerHTML = "Iframe is loaded.";
    
        $.get(
            "controlers/carregar_listas.php",
            {option: 1},
            function (retorno){
                $('#servico').html(retorno); // Pego o retorno em html montado no carregar_listas e inseri no modal.
            }
        );
    }

    // Carrega a lista de clientes no select
    function carregarSelectCliente() {        
            //document.getElementById("demo").innerHTML = "Iframe is loaded.";        
            $.get(
                "controlers/carregar_listas.php",
                {option: 2},
                function (retorno){
                    $('#cliente').html(retorno); // Pego o retorno em html montado no carregar_listas e inseri no modal.
                }
            );
    }
    
    // Função para carregar as atualizações.
    function carregarListaAtualizacoes(option, id_localidade) {
        var option = option; 
        var id_localidade = id_localidade;
        // Pega a lista de atualizações para a localidade em questão
        $.post(
            "controlers/carregar_atualizacoes.php",
            {
                option: option,
                id_localidade: id_localidade
            },
            function (retorno){
                $('#lista_atualizacao').html(retorno);
            }
        );
    }
    
    // Função para carregar último valor de ordenar na atualização da localidade.
    function carregarOrdenarAtualizacoes(option, id_localidade) {
        var option = option; 
        var id_localidade = id_localidade;
        // Pega a lista de atualizações para a localidade em questão
        $.post(
            "controlers/carregar_atualizacoes.php",
            {
                option: option,
                id_localidade: id_localidade
            },
            function (retorno){
                $('#nova_atualizacao_ordenar').val(retorno);
            }
        );
    }

    // Função para gravar as atualizações.
    function gravarAtualizacoes(option, id_localidade, nova_ordenar, nova_atualizacao, idAtualizacao) {
        var option = option; 
        var id_localidade = id_localidade;
        var nova_ordenar = nova_ordenar;
        var nova_atualizacao = nova_atualizacao;
    
        // Pega a lista de atualizações para a localidade em questão
        $.post(
            "controlers/carregar_atualizacoes.php",
            {
                option: option,
                idAtualizacao: idAtualizacao,
                id_localidade: id_localidade,
                nova_ordenar: nova_ordenar,
                nova_atualizacao: nova_atualizacao
            },
            function (retorno){
                $('#lista_atualizacao').html(retorno);
            }
        );
    }

    //  =====   OK - Função para adicionar atualização - Direto no CRUD Localidades  ===========
    
    function inserirAtualizacaoCRUDLocalidades(id){
        var id_localidade = id;

        // Definição de cores do modal
        $('#tempo_atualizacao').prop('readonly', true);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css( "color", "white" );
        // Define o título do modal
        $("#novaAtualizacaoModalTitle").text("Nova Atualização:");  
        $("#nova_atualizacao_Textarea").css( "resize", "none" ); // trava o resize na vertical e horizontal       

        // Limpa os campos
        $('#nova_atualizacao_Textarea').val('');
        $('#nova_atualizacao_ordenar').val('');
        $('#idNovaModalAtualizacaoHiddendois').val('');
        $('#nova_atualizacao_localidade').val('');
        $('#nova_atualizacao_hostname').val(''); 
        $('#nova_atualizacao_ordenar').val('');

        // Carrega os dados da localidade no modal de nova atualização.
        $.ajax({
            url: "controlers/crud_localidades.php",
            type: "POST",
            datatype:"json",    
            data:  {option:5, id:id},   
            success: function(retorno) {
                alert(retorno);
                var obj = JSON.parse(retorno);
                
                // Preenche os dados do Modal
                $('#idNovaModalAtualizacaoHiddendois').val(obj[0].id);
                $('#nova_atualizacao_localidade').val(obj[0].localidade);
                $('#nova_atualizacao_hostname').val(obj[0].hostname);

            }
        });                

        // Carrega o próximo id de ordenar para a nova atualização.
        carregarOrdenarAtualizacoes(3, id);

        // torna o campo de localidade e hostname somente leitura, true ou false
        $('#idNovaModalAtualizacaoHiddendois').prop('readonly', true);
        $('#nova_atualizacao_localidade').prop('readonly', true); 
        $('#nova_atualizacao_hostname').prop('readonly', true);        

        // Definindo a data para o campo de atualização.
        var d = new Date();
        var months = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
        var mes = months[d.getMonth()];
        var dia = d.getDate();
        var ano = d.getFullYear();
        var data_string = dia + "/" + mes + "/" + ano + " - " ;
        var data_string = data_string.toString();

        // Inserir a data no campo de atualização.
        $('#nova_atualizacao_Textarea').val(data_string);

        // Mostrar a modal
        $('#modal_novaAtualizacao').modal('show'); 

    }

    // Editar atualização. 
    // FIXME:  // edição de atualizações. 1º Selecionar uma atualização, depois update desta atualização
    // TODO:  
    function editarAtualizacao(id, id_localidade){
        option = 5; // carregar_atualizacoes.php
        alert(id);
        alert(id_localidade);

        // Marca como 0 para nova atualização e como 1 para editar atualização
        $('#existeAtualizacao').val('1');
        $('#idAtualizacao').val(id);

        // Definição de cores do modal
        $('#tempo_atualizacao').prop('readonly', true);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css( "color", "white" );

        // Define o título do modal
        $("#novaAtualizacaoModalTitle").text("Editar Atualização:");  
        $("#nova_atualizacao_Textarea").css( "resize", "none" ); // trava o resize na vertical e horizontal       

        // Limpa os campos
        $('#nova_atualizacao_Textarea').val('');
        $('#nova_atualizacao_ordenar').val('');
        $('#idNovaModalAtualizacaoHiddendois').val('');
        $('#idNovaModalAtualizacaoHidden').val('');
        $('#nova_atualizacao_localidade').val('');
        $('#nova_atualizacao_hostname').val(''); 
        $('#nova_atualizacao_ordenar').val('');        
        
        // Carrega os dados da localidade no modal de edição da atualização.
        $.ajax({
            url: "controlers/crud_localidades.php",
            type: "POST",
            datatype:"json",    
            data:  {option:5, id:id_localidade},   
            success: function(retorno) {
                alert(retorno);
                var obj = JSON.parse(retorno);

                // Preenche os dados do Modal
                $('#idNovaModalAtualizacaoHiddendois').val(obj[0].id);
                $('#idNovaModalAtualizacaoHidden').val(obj[0].id);
                $('#nova_atualizacao_localidade').val(obj[0].localidade);
                $('#nova_atualizacao_hostname').val(obj[0].hostname);
            }
        });
        
        // Pega os dados da atualização para edição
        $.ajax({
            url: "controlers/carregar_atualizacoes.php",
            type: "POST",
            datatype:"json",    
            data:  {option:5, id:id},   
            success: function(retorno) {
                alert(retorno);
                var obj = JSON.parse(retorno);
                
                // Preenche os dados do Modal 
                $("#nova_atualizacao_Textarea").val(obj[0].atualizacao);
                $('#nova_atualizacao_ordenar').val(obj[0].ordenar);
            }
        });
        
        // torna o campo de localidade e hostname somente leitura, true ou false
        $('#idNovaModalAtualizacaoHiddendois').prop('readonly', true);
        $('#nova_atualizacao_localidade').prop('readonly', true); 
        $('#nova_atualizacao_hostname').prop('readonly', true);

        // Mostrar a modal
        $('#modal_novaAtualizacao').modal('show'); 

    }




