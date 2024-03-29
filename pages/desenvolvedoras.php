<?php

include '../database/models.php';
include_once '../database/database.ini.php';

use ConexaoPostgres\DesenvolvedoraModel;

try {
    $desenvolvedoras_model = new DesenvolvedoraModel($pdo);
    $desenvolvedoras = $desenvolvedoras_model->get_all();

}catch (PDOException $exception){
    echo $exception->getMessage();
}

?>

<?php include "../templates/header.php"; ?>

<main class="container px-3 text-start  ">

    <div class="row">
        <div class="col-auto me-auto">
            <h1>Desenvolvedoras</h1>
        </div>
        <div class="col-auto">
            <div class="text-end mb-4">
                <a class="btn btn-primary" href="create/adicionarDesenvolvedora.php">Cadastrar nova desenvolvedora</a>
            </div>
        </div>
    </div>
    <br>

    <div class="row row-cols-1 row-cols-md-2 g-4">

        <?php foreach ($desenvolvedoras as $desenvolvedora):?>
            <div class="col-md-6 ">
                <div class="card border border-1  text-white rounded-0 bg-success">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $desenvolvedora['nome_desenvolvedora']?></h5>
                    </div>
                    <p class="card-text mb-2 ps-3">Sede: <?php echo $desenvolvedora['sede_desenvolvedora']?></p>
                    <p class="card-text mb-2 ps-3"><?php
                        if ($desenvolvedora['independente'] == 'true'){
                            echo 'Desenvolvedora indie';
                        }else{
                            echo 'Desenvolvedora não indie';
                        }
                        ?></p>
                    <div class="float-end">
                        <div class="btn-group">
                            <?php if ((!is_null($desenvolvedora['url_site_d']) or $desenvolvedora['url_site_d'] != '') ) :?>
                                <a class="btn btn-primary btn-sm " href="<?php echo $desenvolvedora['url_site_d']?>">Site</a>
                            <?php endif; ?>
                            <a class="btn btn-primary btn-sm " href="update/editarDesenvolvedora.php?key=<?php echo $desenvolvedora['id_desenvolvedora'] ?>">Editar</a>
                            <a class="btn btn-primary btn-sm fim" href="delete/removerDesenvolvedora.php?key=<?php echo $desenvolvedora['id_desenvolvedora'] ?>">Remover</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>


</main>

<?php include '../templates/footer.php' ?>