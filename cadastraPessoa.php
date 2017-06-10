<?php

   $conexao = pg_connect("host=localhost port=5432 dbname=projetoForm user=postgres password=p");

   $_POST["codigo"] = str_replace(".", "", $_POST["codigo"]);
   $_POST["codigo"] = str_replace("-", "", $_POST["codigo"]);

   echo $_POST["nascimento"];

   $res = pg_insert($conexao, "pessoa", $_POST);
   if ($res) {
       echo "Dados POST arquivados com sucesso\n";
   }
   else {
       echo "O usuário deve ter inserido entradas inválidas\n";
   }

 ?>
