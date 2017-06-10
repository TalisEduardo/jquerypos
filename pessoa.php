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

      $("#cpf").inputmask("999.999.999-99");
      $("#cpf").val();

      $("#nome").val("");

      $("#data").inputmask("dd/mm/yyyy");
      $("#data").datepicker();
      $("#data").val("");

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

      $('#formPessoa').css('display','none');
      $('#consultaPessoa').css('display','none');

      $('#dadosPessoa').on('click', function() {

        $('#formPessoa').css('display','none');

        if ($('#consultaPessoa').css('display') == 'none') {
          $('#consultaPessoa').css('display','block');
        }
        else {
          $('#consultaPessoa').css('display','none');
        }

      });

      $('#addPessoa').on('click', function() {
        $('#consultaPessoa').css('display','none');

        $('#formPessoa').css('display','block');
      });

      $('#retornaPessoa').on('click', function() {
        $('#formPessoa').css('display','none');
        $('#consultaPessoa').css('display','block');
      });

      $('#formEndereco').css('display','none');
      $('#consultaEndereco').css('display','none');

      $('#dadosEndereco').on('click', function() {

        if ($('#consultaEndereco').css('display') == 'none') {
          $('#consultaEndereco').css('display','block');
        }
        else {
          $('#consultaEndereco').css('display','none');
        }

      });

      $('#retornaEndereco').on('click', function() {
        $('#formEndereco').css('display','none');
        $('#consultaEndereco').css('display','block');
      });

    });
  </script>
</head>

<body>

    <?php $conexao = pg_connect("host=localhost port=5432 dbname=projetoForm user=postgres password=p"); ?>

    <div class="container conteudo">
      <div class="conteudo">

        <div class="submenu">
          <ul>
            <li id="dadosPessoa">Dados Pessoa</li>
            <li id="dadosEndereco">Dados Endereço</li>
          </ul>
        </div>

        <?php
          $query = "select codigo, nome, sexo, nascimento from pessoa";

          $resultado = pg_query($conexao, $query);

        ?>

        <div id='consultaPessoa'>

          <table>
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

          <div class="toolbar">
            <button type="button" id="addPessoa">
              Adicionar
            </button>

            <button type="button" id="delPessoa">
              Remover
            </button>
          </div>

        </div>

        <div id="formPessoa" style="background-color:#336ac4; height:400px; margin-top:5px;"><br>
          <form action="cadastraPessoa.php" style="margin-left:50px;" method="post">
            <h2>Cadastro Pessoa</h2><br>
            CPF: <input type="text" id="cpf" name="codigo" value="" placeholder="Digite o CPF"><br><br>
            Nome: <input type="text" id="nome" name="nome" value="" placeholder="Digite o Nome" style="width:300px;"><br><br>
            Sexo: <select name="sexo" id="sexo" name="sexo" style="width:90px;">
                    <option selected="selected" value="M">Masculino</option>
                    <option value="F">Feminino</option>
                  </select><br><br>
            Data de Nascimento: <input type="text" id="data" name="nascimento" value="" placeholder="Digite a Data"><br><br>
            <button type="submit" id="enviar">Enviar</button>
            <button type="button" id="retornaPessoa">Voltar</button>
          </form>
        </div>

        <div id="formEndereco" style="background-color:#336ac4; height:400px; margin-top:5px;"><br>
          <form action="cadastraEndereco.php" style="margin-left:50px;" method="post">
            <h2>Cadastro Endereço</h2><br>
            <input type="numeric" id="cep" value="" placeholder="Digite o CEP">
            <input type="text" style="width:550px;" id="endereco" value=""><br><br>
            <input type="numeric" id="numero" value="" placeholder="Digite o Número">

            <button type="submit" name="enviar">Enviar</button>
            <button type="button" id="retornaEndereco">Voltar</button>
          </form>
        </div>

      </div>
    </div>

  </body>

</html>
