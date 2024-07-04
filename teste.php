<?php

if (isset($_POST['mudaEstado'])) {
        $marca_tarefas = [];

        foreach ($tarefas as $tarefa) { //Passa um dado por vez para $tarefa.
            $id_tarefa = $tarefa['ID']; // pega id do bd (Tarefas recebe consulta sql).
            if (isset($_POST['marcado_' . $id_tarefa])) {
                $marca_tarefas[$id_tarefa] = $_POST['marcado_' . $id_tarefa]; // 1 para true.
            }
        }

        // Aqui você pode fazer o que precisar com $marca_tarefas,
        // como atualizar o banco de dados.
        foreach ($marca_tarefas as $id_tarefa => $estado) {
            $update_query = "UPDATE tarefas SET Estado = '$estado' WHERE ID = '$id_tarefa' AND Userid = '$id_usuario'"; //Estado = 'Marcado' BD
            mysqli_query($conexao, $update_query);
        }
    }

    ?>

<body>
    <form action="view_tasks.php" method="post">
        <h2>TAREFAS</h2>
        <div class="scrollable">
            <?php
            if (isset($tarefas)) {
                foreach ($tarefas as $tarefa) {
                    $id_tarefa = $tarefa['ID'];
                    echo '<li><b>Id: </b>' . $id_tarefa . ' Tarefa: ' . $tarefa['Tarefa'] . '</li><br>';
                    echo '<select name="marcado_' . $id_tarefa . '" id="marcado_' . $id_tarefa . '">
                            <option value="pendente"' . ($tarefa['Estado'] == 'pendente' ? ' selected' : '') . '>Pendente</option>
                            <option value="feita"' . ($tarefa['Estado'] == 'feita' ? ' selected' : '') . '>Concluída</option>
                          </select>';
                }
            }
            ?>
            <h3 style="color: red;"><?php foreach ($erros as $erro) echo $erro; ?></h3>
            <h3 style="color: red;"><?php isset($_SESSION['valida_acesso']) ? print($_SESSION['valida_acesso']) : ''; ?></h3>
            <br>
            <br>
            <button type="submit" name="mudaEstado" id="mudaEstado">Salvar alterações</button>
        </div>
    </form>
</body>