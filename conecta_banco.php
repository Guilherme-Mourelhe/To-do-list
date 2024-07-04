<?php

$servidor = 'Localhost';
$usuario = 'root';
$senha = '';
$banco = 'to-do-list';

$conexao = mysqli_connect($servidor,$usuario,$senha,$banco);

if(!$conexao){

    print('<h3> Erro ao conectar ao banco.' . mysqli_connect_error());
}

?>