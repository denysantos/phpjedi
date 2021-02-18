<?php
class Router {

    private $get;
    private $post;
    private $core;
    

    //Padrão Singleton
    private function __construct() {}

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Router();
        }

        return $inst;
    }

    public function load() {
        //Carrega arquivos de rotas: o primeiro deles é o padrão (default.php), que está localizado na pasta routes.
        //Esta função verifica se o arquivo existe dentro da pasta routes.
        $this->core = Core::getInstance();
        $this->loadRouteFile('default');
        return $this;
    }

    public function loadRouteFile($f) {

        if(file_exists('routes/'.$f.'.php')) {
            require 'routes/'.$f.'.php';
        }
    }

    //1. Essa função primeiro pega a URL http://localhost/miniframework/noticias/3,
    //2. Depois ele pega o método (get, post...)
    //3. Pega o array das funções get e post com o método de requisição
    //4. E pega todos os gets criados nos arquivos. Em nosso exemplo aqui, temos três, sendo um no arquivo default.php e outros dois no arquivo noticias.php.
    //5. No exemplo, ele dá um loop no padrão get e verifica padrão por padrão e compara se bate com algum.
    public function match() {
        //Pega a url do .htaccess
        //Se URL informada pelo usuário existe, a variável abaixo pega ela, senão traz em branco.
        $url = ((isset($_GET['url']))?$_GET['url']:'');


        //Testando se a URL está funcionando. 
        //Vá até o browser e digite um endereço.
        //No exemplo, eu digitei a URL http://localhost/miniframework/noticias/123.
        //O browser me retornou URL: noticias/123.
        //echo "URL: ".$url;


        //6. O próximo passo agora é pegar o tipo de requisição
        //echo "METODO: ".$_SERVER['REQUEST_METHOD'];
        //Exibe a mensagem "METODO: GET" no browser.

        //O objetivo dessa função abaixo é pegar o array correto das funções get e post.
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                default:
                //Armazenamos a URL em uma variável
                $type = $this->get;
                break;
            
            case 'POST':
                $type = $this->post;
                break;
        }

        //Loop em todos os routes.
        foreach ($type as $pt => $func) {
            //Onde $pt é a chave e $func é o valor.
            //Substituiremos esse tipo de padrão aqui: 'noticias/{id}'
            //Abaixo usamos uma expressão regular substituída por outra na variável $pt.
            //O padrão abaixo nos diz que o {id} pode ter um padrão de caracteres que vão de "a" a "z", de "0" a "9" e de "0" a uma quantidade qualquer de caracteres.
            //Então, identifica os argumentos e substitui por uma regex (expressão regular).
            $pattern = preg_replace('(\{[a-z0-9]{0,}\})','([a-z0-9]{0,})',$pt);

            //Testando o padrão criado acima. 
            //echo "Padrão: ".$pattern;
            //echo '<hr>';

            /**
             * O resultado:
             * 
             * Padrão:
             * Padrão: noticias
             * Padrão: noticias/[a-z0-9]{0,}
             */


             //Os caracteres antes e depois da variável garantem a exatidão da informação vinda da URL.
             //Onde:
             //pega a $url mais acima,
             //e armazena o resultado na variável $matches e
             //o resultado deve ser exatamente igual a 1, onde bateu a comparação.
            if(preg_match('#^('.$pattern.')*$#i',$url, $matches) === 1) {

                //Testando se o resultado bateu ou não...
                //Vá até o browser e digite uma URL.
                //Até aqui, dê um comando print_r, conforme abaixo para exemplo.
                //print_r($matches);

                //RESULTADO:
                //Se trouxer o valor nulo, então não bateu com nenhum endereço. Em meu exemplo, utilizei a URL http://localhost/miniframework/noticias/123/abc 
                //Agora, utilizando a URL http://localhost/miniframework/noticias/123, o resultado foi:
                    //Array ( [0] => noticias/123 [1] => noticias/123 )

                //Se o resultado bateu, agora é preciso remover os registros.
                array_shift($matches);
                array_shift($matches);

                //Para ver o resultado até aqui, dê outro comando print_r.
                //print_r($matches);

                //RESULTADO
                //Digitando a URL: http://localhost/miniframework/, o resultado foi:
                    //Array ( )
                    //Array ( )
                    //Array ( )

                //Digitando a URL: http://localhost/miniframework/noticias, o resultado foi:
                    //Linha vazia
                    //Array ( )
                    //Linha vazia

                //Digitando a URL: http://localhost/miniframework/noticias/123, o resultado foi:
                    //Linha vazia
                    //Linha vazia
                    //Array ( [0] => 123 )

                //Se a comparação acima entrar nesse if, que no caso exemplificado foi Array ( [0] => 123 ), então devemos fazer uma referência direta ao {id} do arquivo de noticias.php, por exemplo.

                //Pegando todos os itens do arquivo de noticias.php 
                $itens = array();
                if (preg_match_all('(\{[a-z0-9]{0,}\})',$pt,$m)) {
                    //Onde o padrão singleton é o mesmo de $matches,
                    //O valor da chave é $pt e
                    //a variável $m é o match.
                    //print_r($m);

                    //RESULTADO:
                    //Digitando a URL: http://localhost/miniframework/noticias/123, o resultado foi:
                        //Linha vazia
                        //Linha vazia
                        //Array ( [0] => Array ( [0] => {id} ) )
                    
                    $itens = preg_replace('(\{|\})','',$m[0]);

                }
                    
                    //Se a URL digitada for http://localhost/miniframework/noticias/123/abc, então o resultado será assim:
                    //print_r($itens);
                    //Array ( [0] => id [1] => categoria )

                    //O próximo passo é fazer a associação entre 'id' e 'categoria'
                    $arg = array();
                    foreach ($matches as $key => $match) {
                        $arg[$itens[$key]] = $match;
                    }

                    //print_r($arg);
                    //Se a URL digitada for http://localhost/miniframework/noticias/123/abc, então o resultado será assim:
                        //Linha vazia
                        //Linha vazia
                        //Array ( [id] => 123 [categoria] => abc )

                    //Passo os parâmetros para a função... 
                    $func($arg);
                    //O break é para parar o foreach()
                    break;
                    //E o resultado agora é:
                        //Linha vazia
                        //Linha vazia
                        //entrou em uma notícia específica

                    
                    //Se a URL digitada for http://localhost/miniframework/noticias, então o resultado será assim:
                        //entrou em notícias
                    //Se a URL digitada for http://localhost/miniframework/, então o resultado será assim:
                        //home
                

            }

            //Comentando o comando abaixo, eu deixo de exibir os parâmetros da URL.
            //echo '<hr/>';
        }

        
    }

    //Essa função carrega um padrão e executa uma função. Por exemplo, http://localhost/mini/noticias/123
    //Onde:
    public function get($pattern, $function) {
        $this->get[$pattern] = $function;
    }

    public function post($pattern, $function) {
        $this->post[$pattern] = $function;
    }

    //Daqui em diante vai para a página default.php, onde é o lugar que será criada uma rota para o site.




}