<?php
class Database {

    private $pdo;
    
    //Padrão Singleton
    private function __construct() {
        //Conexão com o banco de dados.
        $core = Core::getInstance();
        $db = $core->getConfig('db');

        try {
            $this->pdo = new PDO("mysql:dbname=".$db['dbname'].";host=".$db['host'].";", $db['user'], $db['pass']);
            //Verifica erro na conexão com o banco de dados.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Associação direta
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Database();
        }

        return $inst;
    }


    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    /*
    public function execute($array) {
        return $this->pdo->execute($array);
    }
    */



}