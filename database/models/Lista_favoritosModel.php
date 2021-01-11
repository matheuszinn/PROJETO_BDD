<?php


namespace ConexaoPostgres;

use PDO;

class Lista_favoritosModel{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function delete_by_key($key){

        $this->pdo->beginTransaction();

        $this->pdo->exec("delete from lista_favoritos where id_jogo_fav = '$key'");

        $this->pdo->commit();
    }

    public function get_all(){
        $stmt = $this->pdo->query("select id_jogo_fav from lista_favoritos order by id_jogo_fav");
        $stocks = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'id_jogo_fav' => $row['id_jogo_fav']
            ];
        }
        return $stocks;
    }

    public function insert_new($id){
        $sql = "insert into lista_favoritos(id_jogo_fav) values (:id)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }
}