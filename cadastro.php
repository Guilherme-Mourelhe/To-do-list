<?php
include_once 'conecta_banco.php';
include_once 'header.php';

//Variáveis de alerta para o usuário.
$erros = [];
$sucessos = [];

//Função que limpa entrada do usuário.
function limpa_dados($entrada_usuario){

    global $conexao;

    //Previne injeção SQL.
    $entrada_limpa = mysqli_real_escape_string($conexao, $entrada_usuario);

    //Previne script html.
    $entrada_usuario = htmlspecialchars($entrada_limpa);

    return $entrada_usuario;
}

if (isset($_POST['cadastrar'])) {

    //Recebe dados de cadastro do formulário.
    $nome_cadastro = isset($_POST['nomeCadastro']) ? limpa_dados($_POST['nomeCadastro']) : '';
    $senha_cadastro = isset($_POST['senhaCadastro']) ? limpa_dados($_POST['senhaCadastro']) : '';

    //Verifica se usuário já está cadastrado.
    $verifica_cadastro = "SELECT Nome FROM Usuario WHERE Nome = '$nome_cadastro'";
    $verifica_cadastro_query = mysqli_query($conexao, $verifica_cadastro);


    if (mysqli_num_rows($verifica_cadastro_query) > 0) {

        $erros[] = 'Este nome de usuário já está associado a uma conta, tente novamente.';
        
    } else {

        //Deixando senha mais segura

        $senha_cadastro = password_hash($senha_cadastro,PASSWORD_DEFAULT);


        //Cadastra usuário no banco.
        $cadastro = "INSERT INTO Usuario (Nome, Senha) VALUES ('$nome_cadastro', '$senha_cadastro')";
        $cadastro_query = mysqli_query($conexao,$cadastro);

        $sucessos[] = "Usuário cadastrado com sucesso!";

        
    }
}

?>

<body>

<?php if (!empty($erros)){ ?>
        <h4 style="color: red; "><?php foreach($erros as $erro) { print ($erro); } ?></h4>
    <?php } ?>
    <?php if (!empty($sucessos)){ ?>
        <h4 style="color: green; "><?php foreach($sucessos as $sucesso){ print($sucesso);} ?> 
        clique <a href = "login.php">aqui</a> para seguir para o Login.</h4>
    <?php } ?>

    <fieldset>
        <legend><b>CADASTRO</b></legend>
        <form action="cadastro.php" method="post">
            <div class="divInput">
                <b> Nome de usuário: </b>
                <br>
                <input type="text" name="nomeCadastro" id="nomeCadastro" class="userInput" required>
            </div>
            <br>
            <br>
            <div class="divInput">
                <b> Senha: </b>
                <br>
                <input type="password" name="senhaCadastro" id="senhaCadastro" class="userInput" required>
            </div>

            <br>

            <button type="submit" name="cadastrar" id="cadastrar">CADASTRAR</button>


        </form>
    </fieldset>
</body>

<?php
include_once 'footer.php';
?>