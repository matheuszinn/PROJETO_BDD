<?php
require '../database/JogoModel.php';
require '../database/Plataforma_jogoModel.php';
require '../BackgroundGetter.php';
include_once '../database/database.ini.php';

use ConexaoPostgres\JogoModel as JogoModel;
use ConexaoPostgres\Plataforma_jogoModel as Plataforma_jogoModel;

try {
    $bg_handle = new BackgroundGetter();
    $jogoModel = new JogoModel($pdo);
    $plataforma_jogo_model = new Plataforma_jogoModel($pdo);
    $jogos = $jogoModel->get_all();

}catch (PDOException $e){
   echo $e->getMessage();
}

?>

<?php include '../templates/header.php' ?>

<main class="container px-3 text-start ">

    <div class="row">
        <div class="col-auto me-auto">
            <h1>Jogos</h1>
        </div>
        <div class="col-auto">
            <div class="text-end mb-4">
                <a class="btn btn-light" href="../forms/adicionarJogo.php">Cadastrar novo jogo</a>
            </div>
        </div>
    </div>
    <br>

    <div class="row row-cols-1 row-cols-md-2 g-4">

        <?php foreach ($jogos as $jogo):?>
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
                        <div class="btn-group">
                            <a class="btn btn-dark btn-sm " href="../forms/atualizarJogo.php?key=<?php echo $jogo['nome_jogo'] ?>">Editar</a>
                            <a class="btn btn-dark btn-sm fim" href="../forms/removerJogo.php?key=<?php echo $jogo['nome_jogo'] ?>">Remover</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>


</main>

<?php include '../templates/footer.php';