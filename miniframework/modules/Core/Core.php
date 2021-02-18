<?php
class Core {

    private $config;

    //Padrão Singleton
    private function __construct() {}

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Core();
        }

        return $inst;
    }

    public function run($cfg) {
        $this->config = $cfg;
        //Carrega as rotas da pasta routes. A função load() se encontra no arquivo Router.php.

        //Obs.: observe que a função loadModule() está chamando a função load() e esta, por sua vez, chama a função match().
        $this->loadModule('router')->load()->match();

    }

    public function getConfig($name) {
        return $this->config[$name];
    }

    //Função para prepara o carregamento dos outros módulos através do autoload
    public function loadModule($moduleName) {
        //Incluindo dentro de um try catch para prevenir erros de carregamento de módulos inexistentes

        try {
            //Função para converter a variável em minúsculo e depois aplicar a primeira letra em maiúsculo
            $moduleName = ucfirst(strtolower($moduleName));
            //Instanciando o router da função run()
            $module = $moduleName::getInstance();
        return $module;
        } catch (Exception $e) {
            die($e->getMessage());
        }

        

    }

}