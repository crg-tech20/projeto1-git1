$(document).ready(function() {
    
// FIXME:  ===============    Campos de Busca    =======================================
// TODO: Campos de busca
// Campos de busca
        // Atribui evento e função para limpeza dos campos
        $('#busca').on('input', limpaCampos);
    
        // Dispara o Autocomplete a partir do segundo caracter digitado no campo busca
        $( "#busca" ).autocomplete({
            minLength: 2, // dispara no segundo caracter, alterando pode mudar comportamento
            source: function( request, response ) {
                $.ajax({
                    url: "controlers/consulta_cmdb.php",
                    dataType: "json",
                    data: {
                        acao: 'autocomplete',
                        parametro: $('#busca').val()
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            focus: function( event, ui ) {
                $("#busca").val( ui.item.cir );  // titulo vem do json, ver abaixo no append html => item.titulo; item.codigo_barra; item.categoria, etc
                carregarDados();
                $('#busca').val('')
                return false;
            },
            select: function( event, ui ) {
                $("#busca").val(); // PBJPARFBCE000008  // C2833ITBN228
                return false;
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append( "<a><b>Local.: </b>" + item.nome + " - " + item.uf + "<br>&nbspDesignação: " + item.designacao + "</a><br>" )
            .appendTo( ul );
        };
    
        // Função para carregar os dados da consulta nos respectivos campos
        function carregarDados(){
            var busca = $('#busca').val();
    
            if(busca != "" && busca.length >= 2){
                $.ajax({
                    url: "controlers/consulta_cmdb.php",
                    dataType: "json",	
                    data: {
                        acao: 'consulta',
                        parametro: $('#busca').val()
                    },
                    success: function( data ) {
                        $('#busca').val('');
                        $('#ip').val(data[0].loopback);
                        $('#localidade').val(data[0].nome);
                        $('#hostname').val(data[0].hostname);
                        $('#designacao').val(data[0].designacao);
                        $('#uf').val(data[0].uf);
                        $('#cliente').val(data[0].cliente);
                        $('#operadora').val(data[0].operadora);
                    }
                });
            }
        }
    
        // Função para limpar os campos caso a busca esteja vazia
        function limpaCampos(){
            var busca = $('#busca').val();
    
            if(busca == ""){
                
                $('#ip').val('');
                $('#localidade').val('')
                $('#hostname').val('');
                $('#designacao').val('');
                $('#operadora').val('');
                $('#uf').val('');
                $('#cliente').val('')
            }
        }

        // Tornar coluna visível ou não
        var table = $('#crudlocalidades').DataTable();
        //table.column( 0 ).visible( false );
        $('.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
        
            // pegar a coluna API object
            //var idHide = table.column( $(this).data() );
            var column = table.column( $(this).attr('data-column') );
            
            //console.log(idHide);
            // Alternância de visibilidade
            column.visible( ! column.visible() );
        } );
});

