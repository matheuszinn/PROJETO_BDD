<?php


namespace ConexaoPostgres;

use PDO;

class Plataforma_jogoModel{

    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_all_by_key($id){
        $stmt = $this->pdo->query("select id_plataforma_rel from plataforma_jogo where id_jogo_rel = '$id' order by id_plataforma_rel");
        $stocks = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'id_plataforma_rel' => $row['id_plataforma_rel']
            ];
        }
        return $stocks;
    }

    public function insert_new($id_plataforma_rel,$id_jogo_rel){
        $sql = "insert into plataforma_jogo(id_plataforma_rel, id_jogo_rel) values (:id_plataforma_rel, :id_jogo_rel)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id_plataforma_rel', $id_plataforma_rel);
        $stmt->bindValue(':id_jogo_rel', $id_jogo_rel);

        $stmt->execute();
    }

    public function delete_by_key($key){
        $sql = "delete from plataforma_jogo where id_plataforma_rel = '$key'";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }

}