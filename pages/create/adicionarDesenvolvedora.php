<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';


use ConexaoPostgres\DesenvolvedoraModel as DesenvolvedoraModel;

$desenvolvedora_model = new DesenvolvedoraModel($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $desenvolvedora_model->insert($_REQUEST['nome_desenvolvedora'], $_REQUEST['sede_desenvolvedora'], $_REQUEST['url_site_d'], $_REQUEST['independente']);
        header("Location: ../pages/desenvolvedoras.php");
    }catch (PDOException $e){
        $error = $e->getMessage();
    }
}

?>

    <!doctype html>
    <html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MYGAMEBOOK - Adicionar Desenvolvedora</title>

        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
                crossorigin="anonymous"></script>
        <link rel="icon" href="../../assets/favicon.ico"/>

        <style>

            .m img{
                filter: brightness(30%);
            }

            .fim {
                border-radius: 0 !important;
            }

            .btn-group{
                float: right;
            }


            body {
                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, 0.5);
                box-shadow: inset 0 0 5rem rgba(0, 0, 0, 0.5);
            }

            .cover-container {
                max-width: 55em;
            }

            .nav-masthead .nav-link {
                padding: .25rem 0;
                font-weight: 700;
                color: rgba(255, 255, 255, .5);
                background-color: transparent;
                border-bottom: .25rem solid transparent;
            }

            .nav-masthead .nav-link:hover,
            .nav-masthead .nav-link:focus {
                border-bottom-color: rgba(255, 255, 255, .25);
            }

            .nav-masthead .nav-link + .nav-link {
                margin-left: 1rem;
            }

            .nav-masthead .active {
                color: #fff;
                border-bottom-color: #fff;
            }

        </style>

    </head>
<body class="d-flex h-100 text-center text-white bg-dark">

<div class="cover-container d-flex w-100 h-100 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0 active">MYGAMEBOOK</h3>
        </div>
    </header>
    <hr>

    <main class="container px-3 text-start ">

        <div class="row">
            <div class="col-auto me-auto">
                <h1>Adicionar Desenvolvedora</h1>
            </div>
            <div class="col-auto">
                <div class="text-end mb-4">
                    <a class="btn btn-light" href="../desenvolvedoras.php">Voltar</a>
                </div>
            </div>
        </div>
        <br>

        <form class="form-floating row g-3" action="adicionarDesenvolvedora.php" method="post">

            <?php if (!empty($error)) : ?>
                <span class="text-danger"><?php echo $error; ?></span>
            <?php endif; ?>

            <div class="col-md-6">
                <label for="nomedesenvolvedora">Nome da Desenvolvedora</label>
                <input class="form-control" type="text" name="nome_desenvolvedora" id="nomedesenvolvedora" required>
            </div>

            <div class="col-md-6">
                <label for="sededesenvolvedora" >Sede</label>
                <input class="form-control" type="text" name="sede_desenvolvedora" id="sededesenvolvedora">
            </div>

            <div class="col-md-12 ">
                <label for="urlsite">URL do Site</label>
                <input class="form-control" id="urlsite" name="url_site_d" type="text">
            </div>

            <div class="col-md-12">
                <label for="independente">Independente?</label>
                <input type="checkbox" class="custom-control-input" id="independente"
                                                          name='independente'>
            </div>


            <input class="btn btn-light" type="submit" value="Adicionar">
        </form>


    </main>
<?php include '../templates/footer.php' ?>