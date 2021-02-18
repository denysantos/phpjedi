<?php

//Essa rota aqui serve para listar as notícias.
$this->get('noticias',function($arg){
    //echo 'entrou em notícias';
    
    //Criando o módulo de News
    //Quando o usuário acessou news, ele puxou a noticias_lista também.
    $tpl = $this->core->loadModule('template');
    $news = $this->core->loadModule('news');

    $array = array();
    //Aqui chamamos as notícias do banco de dados.
    $array['news'] = $news->getNewsList();

    $tpl->render('noticias_lista', $array);
});

$this->post('noticias',function($arg){
    echo "ENVIOU UM POST...";
});


//Já essa outra rota aqui serve exibir o conteúdo de cada notícia listada.
$this->get('noticias/{id}',function($arg){
    $tpl = $this->core->loadModule('template');
    $news = $this->core->loadModule('news');
    $array = array();
    //Pegando a notícia por parâmetro.
    $array['info'] = $news->getNewsInfo($arg['id']);
    $tpl->render('noticias_item', $array);




    //Se eu colocar o print_r e digitar a URL assim http://localhost/miniframework/noticias/123, então o resultado será:
        //Array ( [id] => 123 ) entrou em uma notícia específica
    //print_r($arg);

    //Carregando o módulo de template na variável $tpl.
    //$tpl = $this->core->loadModule('template');

    //$array = array('id'=>$arg['id']);
    //Se incluir este parâmetro acima e digitar a URL http://localhost/miniframework/noticias/123, o resultado será:
        //Este é um template de teste
        //Este é um arquivo de teste de template... 
        //Abrindo a notícia digitada na URL: #123

    /*
    //Fazendo conexão com o banco de dados
    $db = $this->core->loadModule('database');
    //$sql = $db->query("SHOW TABLES");
    //$sql = $db->query("SHOW COLUMNS FROM noticias");
    $sql = $db->query("SELECT * FROM noticias");
    $array = $sql->fetchAll();
    print_r($array);

    //Digitando a URL http://localhost/miniframework/noticias/123, o resultado será:
        //Array ( [0] => Array ( [Tables_in_db_mini] => noticias ) )

    */

    //$news = $this->core->loadModule('news');
    
    //$tpl->render('teste', $array);
    //Deste ponto em diante, se eu digitar a URL com este endereço http://localhost/miniframework/noticias/123, o resultado será este aqui, logo abaixo:
        //Este é um arquivo de teste de template...

    //echo 'entrou em uma notícia específica';
});


//Testando mais um pouquinho a URL...
/*
$this->get('nome/{nome}/{idade}', function($arg){
    echo 'Meu nome é '.$arg['nome'].' e eu tenho '.$arg['idade'].' anos.';
});
*/

//Se eu colocar o print_r e digitar a URL assim http://localhost/miniframework/nome/Deny/44, então o resultado será:
    //Meu nome é Deny e eu tenho 44 anos.


//Se a URL fosse assim, http://localhost/miniframework/noticias/123/abc
//deveremos usar esse padrão a mais aqui:




/*
$this->get('noticias/{id}/{categoria}',function($arg){
    echo 'entrou em uma notícia específica';
});

RESULTADO: 

Padrão:
Padrão: noticias
Padrão: noticias/[a-z0-9]{0,}
Padrão: noticias/[a-z0-9]{0,}/[a-z0-9]{0,}
*/