<?php
class News {

    //Criando uma variável para o banco de dados.
    private $db;

    //Padrão Singleton
    private function __construct() {
        //Criando uma conexão com o banco de dados no construtor.
        $core = Core::getInstance();
        $this->db = $core->loadModule('database');
    }

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new News();
        }

        return $inst;
    }


    //Criando uma função para obter as notícias do banco de dados.
    public function getNewsList() {
        $array = array();

        $sql = $this->db->query("SELECT * FROM noticias");
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }


    public function getNewsInfo($id) {

        $array = array();

        $sql = $this->db->prepare("SELECT * FROM noticias WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }

        return $array;
    }



}
