<?php
include '../database/models.php';
include_once '../database/database.ini.php';

require '../BackgroundGetter.php';

use ConexaoPostgres\DesenvolvedoraModel;
use ConexaoPostgres\JogoModel as JogoModel;
use ConexaoPostgres\Plataforma_jogoModel as Plataforma_jogoModel;
use ConexaoPostgres\PlataformaModel as Plataforma_model;

try {
    $bg_handle = new BackgroundGetter();
    $jogoModel = new JogoModel($pdo);
    $plataforma_model = new Plataforma_Model($pdo);
    $desenvolvedora_model = new DesenvolvedoraModel($pdo);
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
                <a class="btn btn-primary" href="create/add_removerPlataforma.php">Cadastrar/Remover Plataforma</a>
                <a class="btn btn-primary" href="create/adicionarJogo.php">Cadastrar novo jogo</a>
            </div>
        </div>
    </div>
    <br>

    <div class="row row-cols-1 row-cols-md-2 g-4">

        <?php foreach ($jogos as $jogo):?>
            <div class="col">
                <div class="card border border-1 border-white text-white rounded-0 bg-success">
                    <img src="<?php echo $bg_handle->get_background_image($jogo['nome_jogo'])?>" class="card-img-top rounded-0" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $jogo['nome_jogo']?></h5>
                        <h6 class="card-subtitle mb-2 my-auto text-white"><?php echo $desenvolvedora_model->get_by_key($jogo['id_desen_jogo'])['nome_desenvolvedora']?></h6>
                    </div>
                    <?php if (!is_null($jogo['serie_jogo']) or $jogo['serie_jogo'] != '') :?>
                        <p class="card-text mb-2 ps-3">Série: <?php echo $jogo['serie_jogo']?></p>
                    <?php endif; ?>
                    <p class="card-text mb-2 ps-3">Data De Lançamento: <?php $date = date_create($jogo['data_publicacao']);
                        echo date_format($date, 'd/m/Y'); ?></p>

                    <p class="card-text mb-2 ps-3"><?php


                            $results = $plataforma_jogo_model->get_all_by_key($jogo['id_jogo']);
                            if (count($results) == 1){
                                echo ('Disponível na plataforma:');
                            }else{
                                echo 'Disponível nas plataformas:';
                            }

                            foreach ($results as $plat){
                                echo '<p class="card-text mb-2 ps-5">'. $plataforma_model->get_by_key($plat["id_plataforma_rel"])['nome_plataforma'] .'</p>';
                            }


                        ?></>

                    <p class="card-text mb-2 ps-3">Genero: <?php echo $jogo['genero_jogo']?></p>
                    <div class="float-end">
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm " href="update/atualizarJogo.php?key=<?php echo $jogo['id_jogo'] ?>">Editar</a>
                            <a class="btn btn-primary btn-sm fim" href="delete/removerJogo.php?key=<?php echo $jogo['id_jogo'] ?>">Remover</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>


</main>

<?php include '../templates/footer.php';