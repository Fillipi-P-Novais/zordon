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
    </style>
</head>
<body>
    <div class="container">
        <form class="row mt-5">
            <div class="row centralizacao mb-3">
                <div class="col-md-3">
                    <select id="procedimentos" class="form-select" disabled>
                        <option selected>Selecione o procedimento</option>
                        <option value="HV">Halux Valgus</option>
                        <option>Procedimento 2</option>
                        <option>Procedimento 3</option>
                        <option>Procedimento 4</option>
                        <option>Procedimento 5</option>
                    </select>                
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control desabilitar" id="codigo_tuss" placeholder="Código TUSS" disabled>               
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="valor_procedimento" placeholder="Valor do procedimento" required>               
                </div>
                <div class="col-md-3"> <!-- d-flex justify-content-center -->
                    <button type="button" class="btn btn-outline-primary" id="add_procedimento">Adicionar Procedimento</button>                    
                </div>
            </div>
            <div class="row centralizacao mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="total_procedimentos" placeholder="Total dos Procedimentos" disabled>               
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="porcentagem_calculo" placeholder="% para calcular" required>               
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-primary" id="calcular">Calcular</button>                    
                </div>
                <div class="" id="enviando"></div>
            </div>
            <div class="row centralizacao mb-3" id="agrupamento_procedimentos">
            </div>
            <hr>
            <div class="row centralizacao mb-3">
                <h3>Valores sem acréscimos</h3>
                <div class="col-md-2">
                    <label for="" class="form-label">1º Auxiliar(30% do procedimento)</label>
                    <input type="text" class="form-control" id="parcial_auxiliar_1">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">2º Auxiliar(20% do procedimento)</label>
                    <input type="text" class="form-control" id="parcial_auxiliar_2">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Anestesista(40% do procedimento)</label>
                    <input type="text" class="form-control" id="parcial_anestesista">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Instrumentador(10% do procedimento)</label>
                    <input type="text" class="form-control" id="parcial_instrumentador">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Concierge(5% do procedimento)</label>
                    <input type="text" class="form-control" id="parcial_concierge">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Total</label>
                    <input type="text" class="form-control" id="parcial_total_sem_acrescimo">
                </div>
            </div>           
            <hr>
            <div class="row centralizacao mb-3">
                <h3>Valores com acréscimos de % definida no campo pertinente(referente ao bloco de valores acima)</h3>
                <div class="col-md-2">
                    <label for="" class="form-label">1º Auxiliar</label>
                    <input type="text" class="form-control" id="auxiliar_1_com_acrescimo">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">2º Auxiliar</label>
                    <input type="text" class="form-control" id="auxiliar_2_com_acrescimo">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Anestesista</label>
                    <input type="text" class="form-control" id="anestesista_com_acrescimo">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Instrumentador</label>
                    <input type="text" class="form-control" id="instrumentador_com_acrescimo">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">% Concierge</label>
                    <input type="text" class="form-control" id="concierge_com_acrescimo">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Total</label>
                    <input type="text" class="form-control" id="total_com_acrescimo">
                </div>                
            </div>
            <hr>            
        </form>  
    </div>
</body>
<script> 
    $(document).ready(function() {        
        $('#procedimentos').change(function() {           
           $('#codigo_tuss').val(123456789);
           $('#valor_procedimento').val(10000);
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
                let auxiliar1 = campos[0].auxiliar1;
                let auxiliar2 = campos[1].auxiliar2;
                let instrumentador = campos[2].instrumentador;
                let anestesista = campos[3].anestesista;
                let concierge = campos[4].concierge;
                let total_sem_acrescimo = campos[5].total_sem_acrescimo; 
                let auxiliar_1_com_acrescimo = campos[6].auxiliar1_com_acrescimo;
                let auxiliar_2_com_acrescimo = campos[7].auxiliar2_com_acrescimo;
                let instrumentador_com_acrescimo = campos[8].instrumentador_com_acrescimo;
                let anestesista_com_acrescimo = campos[9].anestesista_com_acrescimo;
                let concierge_com_acrescimo = campos[10].concierge_com_acrescimo;
                let total_com_acrescimo = campos[11].total_com_acrescimo;
                
                $('#parcial_auxiliar_1').val(auxiliar1);
                $('#parcial_auxiliar_2').val(auxiliar2);
                $('#parcial_anestesista').val(anestesista);
                $('#parcial_instrumentador').val(instrumentador);
                $('#parcial_concierge').val(concierge);
                $('#parcial_total_sem_acrescimo').val(total_sem_acrescimo);                
                $('#auxiliar_1_com_acrescimo').val(auxiliar_1_com_acrescimo);
                $('#auxiliar_2_com_acrescimo').val(auxiliar_2_com_acrescimo);
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
            
            /*
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'GET',           
                url : `api/calcular?valor=${valor}`,
                beforeSend : function(){
                    $('#enviando').html("Calculando...");
                }
            }).done(function(retorno){

            })
            .fail(function(){
                $('#enviando').empty();
                console.log('Fail');
            }); */
        });
    })
</script>
</html>