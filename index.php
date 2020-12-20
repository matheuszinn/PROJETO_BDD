<?php
include('templates/header.php');
require 'database/JogoModel.php';
require 'BackgroundGetter.php';
include_once 'database/database.ini.php';

use ConexaoPostgres\JogoModel as JogoModel;

try {
    $jogoModel = new JogoModel($pdo);
    $random = $jogoModel->get_random();
    $bg_handler = new BackgroundGetter();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<main class="px-3">
    <div class="card text-dark m">
        <img src="<?php echo ($bg_handler->get_background_image(implode('', $random))) ?>" class="card-img darker border-0 rounded-3" alt="...">
        <div class="card-img-overlay d-flex">
            <div class="my-auto mx-auto text-center text-white">
                <h1 class="card-title">Esse é o MYGAMEBOOK.</h1>
                <p class="lead">Encontre jogos e guarde seus favoritos para checar a qualquer momento.</p>
            </div>
        </div>
        <p style="font-size: 1.5rem" class="text-end mx-5 my-1"><b><?php echo(implode($random))?></b></p>
    </div>
</main>

<?php
include('templates/footer.php')
?>