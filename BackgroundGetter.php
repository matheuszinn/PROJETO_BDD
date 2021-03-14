# Classe simples essencial para o funcionamento da aplicação

<?php

require ('vendor/autoload.php');

class BackgroundGetter{
    
    private  $client;
    public function __construct(){

        $params = parse_ini_file('rawg.ini');
        $this->client= new Rawg\ApiClient(new Rawg\Config($params['api_key'],$params['api_lang']));
    }

   
    
    public function get_background_image($game_name){

        /**
         * Função responsável por procurar o nome do jogo na api e retornar a imagem em forma de link relacionada a ele. Como ela busca pelo nome do jogo, é possível que a imagem resultada possa não ser tão satisfatória caso o nome do jogo esteja errado
         *
         * @param string $game_name Nome do jogo a ser procurado
         * 
         * @return string
         */ 
        
        # Cria um filtro, tipo uma página com todas as busca, o setPageSize seleciona a quantidade de resultados, e a setSearch o que será procurado.
        $game_filter = (new Rawg\Filters\GamesFilter())
            ->setPageSize(1)
            ->setSearch($game_name);
        
        # Pega os dados e retorna a string
        return $this->client->games()->getGames($game_filter)->getData()['results']['0']['background_image'];
    }
}
