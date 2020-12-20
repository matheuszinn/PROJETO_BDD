<?php

require '../database/JogoModel.php';
require '../database/Plataforma_jogoModel.php';
require '../BackgroundGetter.php';
include_once '../database/database.ini.php';


use ConexaoPostgres\JogoModel as JogoModel;
use ConexaoPostgres\Plataforma_jogoModel as Plataforma_jogoModel;


$jogo_model = new JogoModel($pdo);
$plataforma_jogo_model = new Plataforma_jogoModel($pdo);
$bg_handle = new BackgroundGetter();


$key = $_REQUEST['key'];
$jogo = $jogo_model->get_by_key($key);

if(!empty($_GET['key'])){
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $key = $_POST['key'];
    try {
        $jogo_model->delete_by_key($key);
        header("Location: ../pages/jogos.php");
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
    <title>MYGAMEBOOK - Remoção Jogo</title>

    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
    <link rel="icon" href="../assets/favicon.ico"/>

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
<body class="d-flex h-0 text-center text-white bg-dark">

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
                <h1>Remover Jogo</h1>
            </div>
            <div class="col-auto">
                <div class="text-end mb-4">
                    <a class="btn btn-light" href="../pages/jogos.php">Voltar</a>
                </div>
            </div>
        </div>
        <br>

        <div class="px-3">
            <div class="card border border-1 border-white text-dark rounded-0">
                <div class="row g-0">
                    <img src="<?php echo $bg_handle->get_background_image($jogo['nome_jogo'])?>" class="card-img-top rounded-0" alt="">
                    <div class="col-md-8 ">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $jogo['nome_jogo']?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $jogo['nome_desen_jogo']?></h6>
                        </div>
                        <?php if (!is_null($jogo['serie_jogo'])) :?>
                            <p class="card-text mb-2 ps-3">Série: <?php echo $jogo['serie_jogo']?></p>
                        <?php endif; ?>
                        <p class="card-text mb-2 ps-3">Data De Lançamento: <?php $date = date_create($jogo['data_publicacao']);
                            echo date_format($date, 'd/m/Y'); ?></p>

                        <p class="card-text mb-2 ps-3"><?php


                            $results = $plataforma_jogo_model->get_all_by_key($jogo['nome_jogo']);
                            if (count($results) == 1){
                                echo ('Disponível na plataforma:');
                            }else{
                                echo 'Disponível nas plataforma:';
                            }

                            foreach ($results as $plat){
                                echo '<p class="card-text mb-2 ps-5">'. $plat["plataforma_rel"] .'</p>';
                            }
                            ?></>

                        <p class="card-text mb-2 ps-3">Genero: <?php echo $jogo['genero_jogo']?></p>
                    </div>
                    <div class="col-md-4 d-flex align-self-end flex-column">
                        <form class="row row-cols-lg-auto g-3 align-items-baseline" action="removerJogo.php?id=<?php echo $key?>" method="post">
                            <?php if (!empty($error)): ?>
                                <span class="text-danger"> <?php echo $error ?></span>
                            <?php endif; ?>
                            <input type="hidden" name="key" value="<?php echo $key?>">
                            <div class="row-12 p-5" role="alert">
                                <h5>Deseja excluir o jogo ?</h5>
                                <div class="form actions ">
                                    <div class="text-end ">
                                        <button type="submit" class="btn btn-danger">Sim</button>
                                        <a href="../pages/jogos.php" type="btn" class="btn btn-dark">Não</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </main>

<?php include '../templates/footer.php' ?>
