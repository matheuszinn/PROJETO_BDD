<?php

require ('vendor/autoload.php');

class BackgroundGetter{
    
    private  $client;
    public function __construct(){

        $params = parse_ini_file('rawg.ini');

        $this->client= new Rawg\ApiClient(new Rawg\Config($params['api_key'],$params['api_lang']));
    }

    public function get_background_image($game_name){

        $game_filter = (new Rawg\Filters\GamesFilter())
            ->setPageSize(1)
            ->setSearch($game_name);

        return $this->client->games()->getGames($game_filter)->getData()['results']['0']['background_image'];
    }

}