<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO-DO-LIST</title>
    <style>
        /* Estilos para o header */
        .title {
            text-align: center;
            margin-top: 20px;
        }

        .MainMenuTitle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .MainMenuTitle a {
            font-size: 18px;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }

        .MainMenuTitle a:hover {
            background-color: #fff;
            color: #333;
        }

        /* Estilos para o conteúdo da página de visualizar tarefas*/
        fieldset {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 150px;
            margin-bottom: 280px;
        }

        .scrollable {
            width: 100%;
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
        }
        
    </style>
</head>

<body>
    <header class="title">
        <h1>LISTA DE TAREFAS</h1>
    </header>
    <hr>
    <br>
    <header class="MainMenuTitle">
        <nav>
            <a href="login.php">LOGIN</a>
            <a href="cadastro.php">CADASTRO</a>
            <a href="view_tasks.php">VISUALIZAR TAREFAS</a>
            <a href="manage_tasks.php">ADICIONAR TAREFAS</a>
            <a href="logout.php" style="color: red;">LOGOUT</a>
        </nav>
    </header>

</body>