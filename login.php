<?php 
include_once 'conecta_banco.php';
include_once 'header.php';

//Vetores que armazenam mensagem de aviso para o usuário.
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


if(isset($_POST['logar'])){

//Recebe entrada.
$nome_usuario = isset($_POST['nomeUsuario']) ? limpa_dados($_POST['nomeUsuario']) : '';
$senha_usuario = isset($_POST['senhaUsuario']) ? limpa_dados($_POST['senhaUsuario']) : '';

//Faz a consulta do login.
$verifica_login = "SELECT * FROM usuario WHERE Nome = '$nome_usuario'";

$verifica_login_query = mysqli_query($conexao,$verifica_login);


//Valida login.
if(mysqli_num_rows($verifica_login_query) === 1){
    
    //Passando retorno da consulta SQL contendo os dados do usuário para um array.
    $dados_usuario = mysqli_fetch_array($verifica_login_query);

    $senha_usuario_db = $dados_usuario['Senha'];

    //Convertendo o hash e verificando. Ultima etapa da verificação de login.
    if(password_verify($senha_usuario,$senha_usuario_db)){

        $sucessos[] = 'Logado com sucesso!';

        //definindo variáveis de sessão.
        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $dados_usuario['Nome'];
        $_SESSION['id_usuario'] = $dados_usuario['ID'];

        header('Location: view_tasks.php');
    }else{
        
        $erros[] = 'Senha incorreta';
    }

}else {

    $erros[] = 'Nome de usuário não encontrado.';
}

}


?>

<body>

    <fieldset>
        <legend><b>LOGIN</b></legend>
        <form action="login.php" method="post">
            <div class="divInput">
                <b> Usuário: </b>
                <br>
                <input type="text" name="nomeUsuario" id="nomeUsuario" class="userInput" required>
            </div>
            <br>
            <br>
            <div class="divInput">
                <b> Senha: </b>
                <br>
                <input type="password" name="senhaUsuario" id="senhaUsuario" class="userInput" required>
            </div>
            <!-- exibe mensagens de erro ou sucesso. -->
            <h3 style = "color: red;"> <?php  foreach($erros as $erro){ echo $erro; } ?> </h3>
            <h3 style = "color: green;"> <?php foreach($sucessos as $sucesso) {echo $sucesso;} ?></h3>

            <br>

            <button type="submit" name="logar" id="logar">FAZER LOGIN</button>


        </form>

    </fieldset>

    <h3 style = "color: red;"> <?php session_start();  isset($_SESSION['valida_acesso']) ?
     print($_SESSION['valida_acesso']) : ''; ?> </h3>
</body>

<?php
include_once 'footer.php';
?>