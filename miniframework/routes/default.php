<?php

//O primeiro parâmetro é vazio pq ainda o usuário acessou o site e não digitou nenhuma rota na URL.
$this->get('',function($arg){
    echo 'home';
});

//Ao invés de criarmos as rotas em apenas um arquivo, nós chamamos todas elas aqui.
//Obs.: a função loadRouteFile funciona aqui porque ele está dentro da classe Router, assim como as outras funções que se encontram lá também.
$this->loadRouteFile('noticias');

