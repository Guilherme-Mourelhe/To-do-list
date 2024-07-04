<?php
include_once 'conecta_banco.php';
include_once 'header.php';

//Inicia sessão.
session_start();

//Arrays de mensagens.
$erros = [];
$sucessos = [];

//Verifica login.
if (isset($_SESSION['logado'])) {

    if (isset($_POST['adicionaTarefa'])) {

        //Função que limpa entrada do usuário.
        function limpa_dados($entrada_usuario)
        {

            global $conexao;

            //Previne injeção SQL.
            $entrada_limpa = mysqli_real_escape_string($conexao, $entrada_usuario);

            //Previne script html.
            $entrada_usuario = htmlspecialchars($entrada_limpa);

            return $entrada_usuario;
        }

        //Pega entrada.
        $nome_tarefa = isset($_POST['nomeTarefa']) ? limpa_dados($_POST['nomeTarefa']) : '';

        //Pega id do usuário para armazenar no bd.
        $id_usuario = $_SESSION['id_usuario']; 

        //Cadastra a tarefa.
        $cadastra_tarefa = "INSERT INTO tarefas (Userid, Tarefa, Marcada) VALUES ('$id_usuario', '$nome_tarefa', 0)";
        $cadastra_tarefa_query = mysqli_query($conexao,$cadastra_tarefa);

        

        if($cadastra_tarefa_query){

            $sucessos[] = 'Tarefa cadastrada com sucesso!';
        }else {

            $erros[] = "Erro no cadastro de tarefas." . mysqli_error($conexao);
        }

        //Fechando conexão bd.
        mysqli_close($conexao);

       
    }

} else {

    $_SESSION['valida_acesso'] = 'Acesso negado, fazer login primeiro';
    header('Location: login.php');
}

?>

<body>
    <fieldset>
        <legend> <b> GERENCIADOR DE TAREFAS </b></legend>
        <form action="manage_tasks.php" method="post">
            <br>
            <h3> Adicionar nova tarefa </h3>
            <br>
            <b> Nome da tarefa: </b>
            <br>
            <br>
            <input type="text" name="nomeTarefa" id="nomeTarefa" class="inputTask" required>
            <br>
            <br>
            <h3 style = "color: green;">  <?php foreach($sucessos as $sucesso) {print ($sucesso); }?></h3>
            <h3 style = "color: red;"> <?php foreach($erros as $erro) {print ($erro); }?></h3>
            <br>
            <br>
            <button type="submit" name="adicionaTarefa" id="adicionaTarefa">Adicionar</button>
        </form>
    </fieldset>

</body>



<?php
include_once 'footer.php';
?>