<?php
include_once 'conecta_banco.php';
include_once 'header.php';

$erros = [];

session_start();

//Verifica login.
if (isset($_SESSION['logado'])) {

    //Resetando mensagem.
    $_SESSION['valida_acesso'] = '';

    //Pegando id do usuário.
    $id_usuario = $_SESSION['id_usuario'];

    //Consultando tarefas associadas ao usuário logado.
    $consulta_tarefas = "SELECT * FROM tarefas WHERE Userid = '$id_usuario'";
    $consulta_tarefas_query = mysqli_query($conexao, $consulta_tarefas);

    if (mysqli_num_rows($consulta_tarefas_query) > 0) {

        //Atribuindo resultado da consulta a um array.
        //Usado mysqli_fetch_assoc pois a consulta retorna mais de uma linha. 
        //se retornasse apenas uma poderia usar mysqli_fetch_array.
        $tarefas = [];
        while ($resultado = mysqli_fetch_assoc($consulta_tarefas_query)) {

            $tarefas[] = $resultado;
        }

        //Muda o estado das tarefas.

        if (isset($_POST['mudaEstado'])) {

            $tarefas_marcadas = [];

            foreach ($tarefas as $tarefa) {

                $id_tarefa = $tarefa['ID'];

                if (isset($_POST['marcado_' . $id_tarefa])) {

                    $estado_marcado = $_POST['marcado_' . $id_tarefa];

                    $update_tarefas = "UPDATE tarefas SET Marcada = '$estado_marcado' WHERE ID = '$id_tarefa'";
                    $update_tarefas_query = mysqli_query($conexao, $update_tarefas);

                    if(!$update_tarefas_query){
                        
                        $erros[] = 'Erro ao atualizar tarefa de ID: ' . $id_tarefa;
                    }
                    
                }
            }

            //Recarrega consulta das tarefas para atualizar página.
            $consulta_tarefas_query = mysqli_query($conexao, $consulta_tarefas);
            $tarefas = [];

            while($resultado = mysqli_fetch_assoc($consulta_tarefas_query)){
                
                $tarefas[] = $resultado;
            }
        }
    } else {

        $erros[] = 'Nenhuma tarefa por aqui...';
    }


    //Bloqueia acesso sem login.
} else {

    $_SESSION['valida_acesso'] = 'Acesso negado, fazer login primeiro';
    header('Location: login.php');
}


?>

<body>
    <form action="view_tasks.php" method="post">
        <fieldset>
            <legend>TAREFAS</legend>
            <div class="scrollable">
                <?php
                if (isset($tarefas)) {
                    foreach ($tarefas as $tarefa) {
                        $id_tarefa = $tarefa['ID'];
                        print('<li> <b> Id: </b>' . $tarefa['ID'] . ' Tarefa:  <b>' . $tarefa['Tarefa'] . ' </b> </li> <br>' .

                            '<select name = "marcado_' . $id_tarefa . '" id = "marcado_' . $id_tarefa . '">
                                <option value = "0"' . ($tarefa['Marcada'] == 0 ? 'selected' : '') . ' >Pendente</option>
                                <option value = "1"' .  ($tarefa['Marcada'] == 1 ? 'selected' : '') . '>Concluída</option>
                            </select> <br><br>'
                        );
                    }
                }
                ?>
            </div>
            <h3 style="color: red;">
                <?php foreach ($erros as $erro) {
                    echo $erro;
                } ?>
            </h3>
            <h3 style="color: red;">
                <?php isset($_SESSION['valida_acesso']) ? print($_SESSION['valida_acesso']) : ''; ?>
            </h3>
            <br>
            <button type="submit" name="mudaEstado" id="mudaEstado">Salvar alterações</button>
        </fieldset>
    </form>
</body>
<?php
include_once 'footer.php';
?>