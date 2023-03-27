<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <form class="row mt-5">            
            <div class="col-md-3">
                <select id="procedimentos" class="form-select">
                    <option selected>Selecione o procedimento</option>
                    <option value="HV">Halux Valgus</option>
                    <option>Procedimento 2</option>
                    <option>Procedimento 3</option>
                    <option>Procedimento 4</option>
                    <option>Procedimento 5</option>
                </select>                
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" id="codigo_tuss" placeholder="Código TUSS">               
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" id="valor_procedimento" placeholder="Valor do procedimento">               
            </div>
            <div class="col-md-3 mb-3">
                <button type="button" class="btn btn-outline-primary" id="calcular">Calcular</button>                    
            </div>
            <div class="" id="enviando"></div>
            <hr>
            <div class="col-md-3">
              <label for="" class="form-label">1º Auxiliar</label>
              <input type="password" class="form-control" id="">
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">2º Auxiliar</label>
                <input type="password" class="form-control" id="">
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Anestesista</label>
                <input type="password" class="form-control" id="">
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Instrumentador</label>
                <input type="password" class="form-control" id="">
            </div>
            
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

            $.ajax({
                type : 'POST',           
                url : `api/calcular=${valor}`,
                beforeSend : function(){
                    $('#enviando').html("Calculando...");
                }
            }).done(function(msg){
                $('#enviando').empty();
                console.log('Done');
            })
            .fail(function(){
                $('#enviando').empty();
                console.log('Fail');
            });
        });

    })
</script>
</html>