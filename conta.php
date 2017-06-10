<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Projeto Form</title>
  <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/jquery-validation/js/jquery.validationEngine.js"></script>
  <script type="text/javascript" src="js/Inputmask-3.x/js/inputmask.js"></script>
  <script type="text/javascript" src="js/Inputmask-3.x/js/jquery.inputmask.js"></script>
  <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script type="text/javascript">
      $(document).ready(function() {

      $("#nome").val("");

      $("#data").inputmask("99/99/9999");
      $("#data").val("");
      $("#data").datepicker();

      $("#cep").inputmask("99.999-999");
      $("#cep").val("");

      $("#endereco").val("");

      $("#cep").on("blur", function() {

        var cep = $("#cep").val();

        cep = cep.replace('-', '');
        cep = cep.replace('.', '');

        if (cep == "") {
          $('#endereco').after('<span id="msg-cep" class="alert">Digita o CEP.</span>');
        } else {

          $('#msg-cep').remove();

          $.ajax({
            url: 'http://viacep.com.br/ws/' + cep + '/json/',
            type: 'get',
            dataType: 'json',
            crossDomain: true,
            data: {
              cep: cep,
              formato: 'json',
              chave: ''
            },
            success: function(data) {
              $('#endereco').val(data.logradouro + ' - ' + data.complemento + ' - ' + data.bairro + ' - ' + data.localidade);
            }

          });

        }

      }).on("blur");

    });

    $('.menu li').on('mouseover', function() {
      alert(this);
    });
  </script>
</head>

<body>

  <div class="toolbar">
    <button type="button" class="ui button">
      Adicionar
    </button>

    <button type="button" class="ui red button">
      Remover
    </button>
  </div>

    <?php
      $conexao = pg_connect("host=localhost port=5432 dbname=projetoForm user=postgres password=p");

      $query = "select codigo, nome, sexo, nascimento from pessoa";

      $resultado = pg_query($conexao, $query);

    ?>

    <table class="ui table">
      <thead>
        <tr>
          <th>CPF</th>
          <th>Nome</th>
          <th>Sexo</th>
          <th>Data Nascimento</th>
        </tr>
      </thead>
      <tbody>
        <?php while($obj = pg_fetch_object($resultado)) { ?>
          <tr>
            <td><?php echo $obj->codigo ?></td>
            <td><?php echo $obj->nome ?></td>
            <td><?php echo $obj->sexo ?></td>
            <td><?php echo $obj->nascimento ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div class="container conteudo">
      <div class="conteudo">

      <div style="background-color:#336ac4; height:400px; margin-top:5px;"><br>
        <form action="hello.html" style="margin-left:50px;" method="post">
          <h2>Formulário</h2><br>
          <input type="text" id="nome" value="" placeholder="Digite o Nome"><br><br>
          <input type="date" id="data" value="" placeholder="Digite a Data"><br><br>
          <input type="numeric" id="cep" value="" placeholder="Digite o CEP">
          <input type="text" style="width:550px;" id="endereco" value=""><br><br>
          <button type="submit" name="enviar">Enviar</button>
        </form>
      </div>

    </div>

    </div>

  </body>

</html>
