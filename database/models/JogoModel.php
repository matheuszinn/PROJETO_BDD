<?php


namespace ConexaoPostgres;


use PDO;

class JogoModel{

    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_random(){
        $stmt = $this->pdo->query("select nome_jogo from jogo order by random() limit 1");
        $jogo = $stmt->fetch(PDO::FETCH_ASSOC);
        return[
          'nome_jogo' =>  $jogo['nome_jogo']
        ];
    }

    public function get_all(){
        $stmt = $this->pdo->query("select id_jogo, nome_jogo, serie_jogo, id_desen_jogo, data_publicacao, genero_jogo from jogo order by nome_jogo");
        $stocks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'id_jogo' => $row['id_jogo'],
                'nome_jogo' => $row['nome_jogo'],
                'serie_jogo' => $row['serie_jogo'],
                'id_desen_jogo' => $row['id_desen_jogo'],
                'data_publicacao' => $row['data_publicacao'],
                'genero_jogo' => $row['genero_jogo']
            ];
        }
        return $stocks;
    }

    public function insert_new($nome_jogo, $serie_jogo, $data_publicacao, $genero_jogo, $id_desen_jogo){
        $sql = "insert into jogo (nome_jogo, serie_jogo, data_publicacao, genero_jogo, id_desen_jogo) values (:nome_jogo,:serie_jogo,:data_publicacao,:genero_jogo,:id_desen_jogo);";
        $stmt = $this->pdo->prepare($sql);



        $stmt->bindValue(':nome_jogo', $nome_jogo);

        if ($serie_jogo === ''){
            $stmt->bindValue(':serie_jogo', "NULL", PDO::NULL_NATURAL);
        }else{
            $stmt->bindValue(':serie_jogo', $serie_jogo);
        }

        $stmt->bindValue(':data_publicacao', $data_publicacao);
        $stmt->bindValue(':genero_jogo', $genero_jogo);
        $stmt->bindValue(':id_desen_jogo', $id_desen_jogo);

        $stmt->execute();
    }

    public function update($nome_jogo, $serie_jogo, $data_publicacao, $genero_jogo, $id_desen_jogo, $id){
        $sql = "update jogo set nome_jogo='$nome_jogo', serie_jogo='$serie_jogo', data_publicacao='$data_publicacao', genero_jogo='$genero_jogo', id_desen_jogo='$id_desen_jogo' where id_jogo='$id'";
        $stmt= $this->pdo->prepare($sql);

        $stmt->execute();

    }

    public function delete_by_key($key){
        $sql ="delete from jogo where id_jogo = '$key'";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }

    public function get_by_key($key){
        $stmt = $this->pdo->query("select id_jogo, nome_jogo, serie_jogo, id_desen_jogo, data_publicacao, genero_jogo from jogo where id_jogo = '$key'");
        $jogo = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($jogo){
            return [
                'id_jogo' => $jogo['id_jogo'],
                'nome_jogo' => $jogo['nome_jogo'],
                'serie_jogo' => $jogo['serie_jogo'],
                'id_desen_jogo' => $jogo['id_desen_jogo'],
                'data_publicacao' => $jogo['data_publicacao'],
                'genero_jogo' => $jogo['genero_jogo']
            ];
        }else{
            return  null;
        }
    }


}