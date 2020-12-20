<?php


namespace ConexaoPostgres;

use PDO;

class Plataforma_jogoModel{

    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_all_by_key($nome_jogo){
        $stmt = $this->pdo->query("select plataforma_rel from plataforma_jogo where jogo_plat_rel = '$nome_jogo'");
        $stocks = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'plataforma_rel' => $row['plataforma_rel']
            ];
        }
        return $stocks;
    }

    public function insert_new($plataforma_rel,$jogo_plat_rel){
        $sql = "insert into plataforma_jogo(plataforma_rel, jogo_plat_rel) values (:plataforma_rel, :jogo_plat_rel)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':plataforma_rel', $plataforma_rel);
        $stmt->bindValue(':jogo_plat_rel', $jogo_plat_rel);

        $stmt->execute();
    }

    public function delete_by_key($key){
        $sql = "delete from plataforma_jogo where plataforma_rel = '$key'";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }

}