/*
    Essa foi a classe mais problemática, devido a natureza de um jogo ter várias plataformas
*/


<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';

use ConexaoPostgres\DesenvolvedoraModel as DesenvolvedoraModel;
use ConexaoPostgres\PlataformaModel as PlataformaModel;
use ConexaoPostgres\JogoModel as JogoModel;
use ConexaoPostgres\Plataforma_jogoModel as Plataforma_jogoModel;

$plataforma_model = new PlataformaModel($pdo);
$plataformas_all = $plataforma_model->get_all();

$desenvolvedora_model = new DesenvolvedoraModel($pdo);
$desenvolvedoras_all = $desenvolvedora_model->get_all();

$plataforma_jogo_model = new Plataforma_jogoModel($pdo);

$nome_jogo = null;
$serie_jogo = null;
$nome_desen_jogo = null;
$data_publicacao = null;
$genero_jogo = null;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome_jogo = $_REQUEST['nome_jogo'];
    $serie_jogo = $_REQUEST['serie_jogo'];
    $nome_desen_jogo = $_REQUEST['nome_desen_jogo'];
    $data_publicacao = $_REQUEST['data_publicacao'];
    $genero_jogo = $_REQUEST['genero_jogo'];
    $plataformas = $_REQUEST['plataformas'];

    try {
        $jogo_modelo = new JogoModel($pdo);
        $jogo_modelo->insert_new(trim($_REQUEST['nome_jogo']),$_REQUEST['serie_jogo'],$_REQUEST['data_publicacao'],$_REQUEST['genero_jogo'], $_REQUEST['add_id_jogo']);

        $ultimo = $jogo_modelo->get_by_key($pdo->lastInsertId());

        foreach ( $plataformas as $plat){
            $plataforma_jogo_model->insert_new($plat, $ultimo['id_jogo']);
        }

        # Essa parte não está muito otimizada, infelizmente. São muitos acessos ao banco de dados
        
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
    <title>MYGAMEBOOK - Adicionar Jogo</title>

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
                <h1>Adicionar Jogo</h1>
            </div>
            <div class="col-auto">
                <div class="text-end mb-4">
                    <a class="btn btn-light" href="../jogos.php">Voltar</a>
                </div>
            </div>
        </div>
        <br>

        <form class="form-floating row g-3" action="adicionarJogo.php" method="post">

            <?php if (!empty($error)) : ?>
                <span class="text-danger"><?php echo $error; ?></span>
            <?php endif; ?>

            <div class="col-md-6">
                <label for="nomejogo">Nome do jogo</label>
                <input class="form-control" value="<?php echo !empty($nome_jogo) ? $nome_jogo :'' ?>"type="text" name="nome_jogo" id="nomejogo" required>
            </div>

            <div class="col-md-6">
                <label for="seriejogo" >Série</label>
                <input class="form-control" value="<?php echo !empty($serie_jogo) ? $serie_jogo :'' ?>"type="text" name="serie_jogo" id="seriejogo">
            </div>

            <div class="col-md-6">
                <label for="ldesen">Desenvolvedoras</label>
                <select class="form-select col-md-6" name="add_id_jogo" id="ldesen">
                    <?php foreach ($desenvolvedoras_all as $j):?>
                        <option value="<?php echo $j['id_desenvolvedora']?>"><?php echo $j['nome_desenvolvedora']?></option>
                    <?php endforeach;?>
                </select>
            </div>


            <div class="col-md-6">
                <label for="datapublicacao">Data de lançamento</label>
                <input class="form-control" value="<?php echo !empty($data_publicacao) ? $data_publicacao :'' ?>" type="date" name="data_publicacao" id="datapublicacao" required>
            </div>

            <div class="col-md-6 ">
                <label for="plataformas">Plataformas</label>
                <select multiple class="form-control" id="plataformas" name="plataformas[]"  required>

                    <?php foreach ($plataformas_all as $plataforma): ?>
                        <tr>
                            <option value="<?php echo $plataforma['id_plataforma']?>" <?php echo $plataforma['nome_plataforma']  ?>><?php echo $plataforma['nome_plataforma']?></option>
                        </tr>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="genero">Genero</label>
                <input class="form-control" value="<?php echo !empty($genero_jogo) ? $genero_jogo :'' ?>" type="text" name="genero_jogo" id="genero" required>
            </div>


                <input class="btn btn-light" type="submit" value="Adicionar">
        </form>


    </main>
    <?php include '../templates/footer.php' ?>
