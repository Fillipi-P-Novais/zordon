<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Document') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        .desabilitar {
            pointer-events: none;
        }

        .centralizacao {
            text-align-last: center;
        }

        .grid {
            display: grid;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="row mt-5">
            <div class="col-md-2 d-flex mb-2" >
                <input type="text" class="form-control" id="buscar_procedimento" placeholder="Código TUSS">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-primary" id="buscarTuss">Buscar</button>
            </div>
            <div class="row centralizacao mb-3">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="tuss">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="descricao">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="valor">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-warning" id="incluir">Incluir</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger" id="remover">Remover</button>
                </div>
                <div class="" id="enviando"></div>
            </div>
            <div class="row centralizacao mb-3" id="agrupamento_procedimentos">
            </div>
            <hr>
            <section class="row grid centralizacao mb-3 col-md-6 justify-content-center" id="secao_sem_acrescimo">                
                <div class="col">
                    <label for="" class="form-label">1º Auxiliar</label>
                    <input type="text" class="form-control" id="parcial_auxiliar_1">
                </div>                               
                <div class="col">
                    <label for="" class="form-label">Anestesista</label>
                    <input type="text" class="form-control" id="parcial_anestesista">
                </div>
                <div class="col">
                    <label for="" class="form-label">Instrumentador</label>
                    <input type="text" class="form-control" id="parcial_instrumentador">
                </div>
                <div class="col">
                    <label for="" class="form-label">Concierge</label>
                    <input type="text" class="form-control" id="parcial_concierge">
                </div>
                <div class="col">
                    <label for="" class="form-label">Total</label>
                    <input type="text" class="form-control" id="parcial_total_sem_acrescimo">
                </div>
            </section>
            <section class="grid centralizacao mb-3 col-md-6 justify-content-center" id="secao_com_acrescimo">                
                <div class="col">
                    <label for="" class="form-label">1º Auxiliar</label>
                    <input type="text" class="form-control" id="auxiliar_1_com_acrescimo">
                </div>
                <div class="col">
                    <label for="" class="form-label">Anestesista</label>
                    <input type="text" class="form-control" id="anestesista_com_acrescimo">
                </div>
                <div class="col">
                    <label for="" class="form-label">Instrumentador</label>
                    <input type="text" class="form-control" id="instrumentador_com_acrescimo">
                </div>
                <div class="col">
                    <label for="" class="form-label">Concierge</label>
                    <input type="text" class="form-control" id="concierge_com_acrescimo">
                </div>
                <div class="col">
                    <label for="" class="form-label">Total</label>
                    <input type="text" class="form-control" id="total_com_acrescimo">
                </div>                
            </section>
            <hr>            
        </form>  
    </div>
</body>
<script> 
    $(document).ready(function() {        
        $('#buscarTuss').click(function() {           
          let tuss = $('#buscar_procedimento').val();

           $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'GET',           
                url : `api/buscarTuss?tuss=${tuss}`,
                beforeSend : function(){
                    $('#enviando').html("Calculando...");
                }
            }).done(function(retorno){
                let dados = retorno;
                let tuss_code = dados[0].codigo_tuss;
                let descricao = dados[0].descricao_procedimento;
                let valor = dados[0].valor_procedimento;

                $('#tuss').val(tuss_code);
                $('#descricao').val(descricao);
                $('#valor').val(valor);
                console.log(dados, tuss_code);
            })
        });

        $('#calcular').click(function(){
            let valor= $('#valor_procedimento').val();
            let porcentagem= $('#porcentagem_calculo').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'GET',           
                url : `api/calcular?valor=${valor}&porcentagem=${porcentagem}`,
                beforeSend : function(){
                    $('#enviando').html("Calculando...");
                }
            }).done(function(retorno){
                $('#enviando').empty();                
                let campos = retorno.dados;
                console.log(campos);
                let auxiliar1 = campos[0].auxiliar1;
                let instrumentador = campos[1].instrumentador;
                let anestesista = campos[2].anestesista;
                let concierge = campos[3].concierge;
                let total_sem_acrescimo = campos[4].total_sem_acrescimo; 
                let auxiliar_1_com_acrescimo = campos[5].auxiliar1_com_acrescimo;
                let instrumentador_com_acrescimo = campos[6].instrumentador_com_acrescimo;
                let anestesista_com_acrescimo = campos[7].anestesista_com_acrescimo;
                let concierge_com_acrescimo = campos[8].concierge_com_acrescimo;
                let total_com_acrescimo = campos[9].total_com_acrescimo;
                
                $('#parcial_auxiliar_1').val(auxiliar1);
                $('#parcial_anestesista').val(anestesista);
                $('#parcial_instrumentador').val(instrumentador);
                $('#parcial_concierge').val(concierge);
                $('#parcial_total_sem_acrescimo').val(total_sem_acrescimo);                
                $('#auxiliar_1_com_acrescimo').val(auxiliar_1_com_acrescimo);
                $('#anestesista_com_acrescimo').val(instrumentador_com_acrescimo);
                $('#instrumentador_com_acrescimo').val(anestesista_com_acrescimo);
                $('#concierge_com_acrescimo').val(concierge_com_acrescimo);
                $('#total_com_acrescimo').val(total_com_acrescimo); 
            })
            .fail(function(){
                $('#enviando').empty();
                console.log('Fail');
            });
        });

        $('#add_procedimento').click(function(){
            let valor= $('#valor_procedimento').val();
            $('#agrupamento_procedimentos').append(`
                
                <div class="col-md-4">
                    <select id="procedimentos" class="form-select">
                        <option selected>Selecione o procedimento</option>
                        <option value="HV">Halux Valgus</option>
                        <option>Procedimento 2</option>
                        <option>Procedimento 3</option>
                        <option>Procedimento 4</option>
                        <option>Procedimento 5</option>
                    </select>                
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control desabilitar" id="codigo_tuss" placeholder="Código TUSS" disabled>               
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="valor_procedimento" placeholder="Valor do procedimento">               
                </div>
                
            `);
        });

        $('#add_auxiliar').click(function(){                       
            $('#secao_sem_acrescimo').prepend(`
                <div class="col aux2">
                    <label for="" class="form-label">2º Auxiliar</label>
                    <input type="text" class="form-control" id="parcial_auxiliar_2">                   
                </div>
            `);
            $('#secao_com_acrescimo').prepend(`
                <div class="col aux2">
                    <label for="" class="form-label">2º Auxiliar</label>
                    <input type="text" class="form-control" id="auxiliar_2_com_acrescimo">                   
                </div>
            `);
        });

        $('#deletar_auxiliar').click(function(){
            $('.aux2').remove();
        });
    })
</script>
</html>