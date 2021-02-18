<?php
session_start();
require 'config.php';

//Criação do autoload
spl_autoload_register(function($class) {
    //se o arquivo existe, trazemos ele
    if(file_exists('modules/'.$class.'/'.$class.'.php')) {
        require 'modules/'.$class.'/'.$class.'.php';
    }

});

//Padrão Singleton
//Instanciando o banco de dados
Core::getInstance()->run($config);

?>