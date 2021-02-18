<?php
class Template {

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Template();
        }

        return $inst;
    }


    //Criando uma função para chamar os arquivos .html
    //Onde:
        //carrega como parâmetros o template e os dados, e este último se não informado, traz um array vazio. 
    public function render($tpl, $data = array()) {
        //se existir o arquivo, eu busco ele na pasta 'templates'. 
        if(file_exists('templates/'.$tpl.'.php')) {
            require 'templates/'.$tpl.'.php';
            //deste ponto, se houver um arquivo na pasta 'templates', ele carrega esse arquivo através de outro arquivo de exemplo, que é o 'noticias.php'. Nesse arquivo, nós fazemos a referência essa função 'render'. Neste exemplo, criamos o arquivo de 'teste.php'. 
        }

    }
}