<?php

require '../database/Lista_favoritosModel.php';
require '../database/database.ini.php';
require '../database/Plataforma_jogoModel.php';
require '../database/JogoModel.php';
require '../BackgroundGetter.php';

use ConexaoPostgres\Lista_favoritosModel as Lista_FavoritosModel;
use ConexaoPostgres\Plataforma_jogoModel;
use ConexaoPostgres\JogoModel as JogoModel;

$lista_favoritos_model = new Lista_FavoritosModel($pdo);

$lista_favoritos_all = $lista_favoritos_model->get_all();


if (!empty($lista_favoritos_all)){
    $plataforma_jogo_model = new Plataforma_jogoModel($pdo) ;
    $jogo_model = new JogoModel($pdo);
    $bg_handle = new BackgroundGetter();

    $lista_jogos = [];

    foreach ($lista_favoritos_all as $j){
        $lista_jogos[] = $jogo_model->get_by_key($j['jogo_nome_fav']);
    }


}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        if(!empty($_REQUEST['jogo_nome'])) {
            $lista_favoritos_model->delete_by_key($_REQUEST['jogo_nome']);
            header("Location: ..\pages\Favoritos.php");
        }
        if(!empty($_REQUEST['add_nome_jogo'])){
            $lista_favoritos_model->insert_new($_REQUEST['add_nome_jogo']);
            header("Location: \pages\Favoritos.php");
        }
    }catch (PDOException $e){
        $error = $e->getMessage();
    }
}

?>

<?php include '../templates/header.php' ?>


    <main class="container px-3 text-start ">

        <div class="row">
            <div class="col-auto me-auto">
                <h1>Jogos Favoritos</h1>
            </div>
            <div class="col-auto">
                <form action="Favoritos.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="add_nome_jogo" class="form-control" placeholder="Nome do jogo" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Favoritar jogo</button>
                    </div>
                </form>
            </div>
        </div>
        <br>

        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php if (!empty($error)) : ?>
                <span class="text-danger"><?php echo $error; ?></span>
            <?php  elseif(empty($lista_favoritos_all)):?>
                <h2>A lista está vazia...</h2>
            <?php else: ?>
                <?php foreach ($lista_jogos as $jogo):?>
                    <div class="col-md-6 ">
                        <div class="card border border-1 border-white text-dark rounded-0">
                            <img src="<?php echo $bg_handle->get_background_image($jogo['nome_jogo'])?>" class="card-img-top rounded-0" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $jogo['nome_jogo']?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $jogo['nome_desen_jogo']?></h6>
                            </div>
                            <?php if (!is_null($jogo['serie_jogo']) or $jogo['serie_jogo'] != '') :?>
                                <p class="card-text mb-2 ps-3">Série: <?php echo $jogo['serie_jogo']?></p>
                            <?php endif; ?>
                            <p class="card-text mb-2 ps-3">Data De Lançamento: <?php $date = date_create($jogo['data_publicacao']);
                                echo date_format($date, 'd/m/Y'); ?></p>

                            <p class="card-text mb-2 ps-3"><?php


                                $results = $plataforma_jogo_model->get_all_by_key($jogo['nome_jogo']);
                                if (count($results) == 1){
                                    echo ('Disponível na plataforma:');
                                }else{
                                    echo 'Disponível nas plataformas:';
                                }

                                foreach ($results as $plat){
                                    echo '<p class="card-text mb-2 ps-5">'. $plat["plataforma_rel"] .'</p>';
                                }
                                ?></>

                            <p class="card-text mb-2 ps-3">Genero: <?php echo $jogo['genero_jogo']?></p>
                            <div class="float-end">
                                <form class="text-end" action="Favoritos.php" method="post">
                                    <input type="hidden" id="nomeJogo" name="jogo_nome" value="<?php echo $jogo['nome_jogo']?>">
                                    <button class="btn btn-dark btn-md" type="submit">Remover</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif; ?>

        </div>


    </main>

<?php include '../templates/footer.php';
