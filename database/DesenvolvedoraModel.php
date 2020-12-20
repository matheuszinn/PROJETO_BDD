<?php


namespace ConexaoPostgres;


use PDO;

class DesenvolvedoraModel{

    private $pdo;

    public function __construct( PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_all(){
        $stmt = $this->pdo->query("SELECT nome_desenvolvedora, sede_desenvolvedora, url_site_d, independente from desenvolvedora");
        $stocks =[];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $stocks[] =[
                'nome_desenvolvedora' => $row['nome_desenvolvedora'],
                'sede_desenvolvedora' => $row['sede_desenvolvedora'],
                'url_site_d' => $row['url_site_d'],
                'independente' => $row['independente']
            ];
        }
        return $stocks;
    }

    public function get_by_key($key){
        $stmt = $this->pdo->query("select nome_desenvolvedora, sede_desenvolvedora, url_site_d, independente from desenvolvedora where nome_desenvolvedora = '$key'");
        $desenvolvedora = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($desenvolvedora){
            return [
                'nome_desenvolvedora' => $desenvolvedora['nome_desenvolvedora'],
                'sede_desenvolvedora' => $desenvolvedora['sede_desenvolvedora'],
                'url_site_d' => $desenvolvedora['url_site_d'],
                'independente' => $desenvolvedora['independente']
            ];
        }else{
            return null;
        }
    }

    public function delete_by_key($key){
        $sql = "delete from public.desenvolvedora where nome_desenvolvedora = '$key'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function insert($nome_desenvolvedora, $sede_desenvolvedora, $url_site_d, $independente){
        $sql = "insert into desenvolvedora values (:nome_desenvolvedora, :sede_desenvolvimento, :url_site_d, :independente)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome_desenvolvedora', $nome_desenvolvedora);
        $stmt->bindValue(':sede_desenvolvimento', $sede_desenvolvedora);
        $stmt->bindValue(':url_site_d', $url_site_d);
        $stmt->bindValue(':independente', $independente);

        $stmt->execute();
    }

    public function  update(){

    }
}