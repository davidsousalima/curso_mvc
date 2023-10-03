<?php
    namespace App\Http;

    use \Closure;
    use \Exception;
    class Router{
        /**
         * URL completa do projeto (raiz
         * @var string
         */
        private $url = '';
        /**
         * Prefixo de todas as rotas
         * @var string
         */
        private $prefix = ''; 

        /**
         * Indice de rotas
         * @var array
         */
        private $routes =[];

        /**
         * Instancia de Request
         * @var Request
         */
        private $request;
        /**
         * Método responsavel por iniciar a classe
         * @param string $url
         */
        public function __construct($url){
            $this->request = new Request();
            $this->url =$url;
            $this->setPrefix();
        }
        /**
         * Metodo responsavel por definir o prefixo das rotas
         */
        private function setPrefix(){
            //INFORMAÇÔES DA URL ATUAL
            $parseUrl =parse_url($this->url);
            //DEFINIR O PREFIXO
            $this->prefix =$parseUrl['path'] ??'';
        }
        /**
         * Método responsavel por adicionar uma rota na classe
         * @param string $method
         * @param string $route
         * @param array $params
         */
        private function addRoute($method,$route,$params = []){
            
            //VALIDAÇÂO DOS PARÂMETROS
            foreach($params as $key=>$value){
                if($value instanceof Closure){
                    $params['controller'] = $value;
                    unset($params[$key]);
                    continue;
                }
            }
            //PADRÃO DE VALIDAÇÂO DA URL
            $patternRoute ='/^'.str_replace('/','\/',$route).'$/';
            //ADICIONA A ROTA DENTRO DA CLASSE
            $this->routes[$patternRoute][$method] = $params;
           
        }
        /**
         * Método responsavel por definir uma rota de GET
         * @param string $route
         * @param array $params
         */
        public function get($route,$params = []){
            return $this->addRoute('GET',$route,$params);
        }
        /**
         * Método responsável por definir uma rota POST
         * @param string $route
         * @param array $params
         */
        public function post($route,$params = []){
            return $this->addRoute('POST',$route,$params);
        }
        /**
         * Método responsavel por definir uma rota de PUT
         * @param string $route
         * @param array $params
         */
        public function put($route,$params = []){
            return $this->addRoute('PUT',$route,$params);
        }
        /**
         * Metodo responsavel por definir uma rota de DELETE
         * @param string $route
         * @param array $params
         */
        public function delete($route,$params = []){
            return $this->addRoute('DELETE',$route,$params);
        }
        /**
         * Método responsável por retornar a URI desconsiderando o prefixo
         * @return string
         */
        private function getURI(){
            //URI DA REQUEST
            $uri = $this->request->getURI();
           //FATIA A URI COM A PREFIXO
            $xURI =strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];

            //RETORNA A URI SEM O PREFIXO
            return end($xURI);
        }
        /**
         * Método responsavel por retornar os dados da rota atual
         * @return array
         */
        private function getRoute(){
            //URI
            $uri = $this->getURI();

            //METODO 
            $httpMethod = $this->request->getHttpMethod();
            
            //VALIDA AS ROTAS
            foreach($this->routes as $patternRoute=>$methods){
                //VERIFICA SE A URI BATE O PADRÂO
                if(preg_match($patternRoute,$uri)){
                    //VERIFICA O MÉTODO
                    if($methods[$httpMethod]){

                        //RETORNO DOS PARÂMENTROS DA ROTA
                        return $methods[$httpMethod];
                    }
                    //MÉTODO NÃO PERMITIDO /DEFINIDO
                    throw new Exception("Método não permitido",405);
                }
            }
            //URL NÂO ENCONTRADA
            throw new Exception("URL NÃO ENCONTRADA",404);
        }
        /**
         * Método responsável por executar a rota atual
         * @return Response
         */
        public function Run(){
            try{
                //OBTEM A ROTA ATUAL
                $route = $this->getRoute();
                
                //VERIFICA O CONTROLADOR
                if(!isset($route['controller'])){
                    throw new Exception('A url não pode ser processada',500);
                }
                //ARGUMENTOS DA FUNÇÂO
                $args = [];
                //RETORNAR A EXECUÇÂO DA FUNÇÃO
                return call_user_func_array($route['controller'],$args);
            }catch(Exception $e){
                return new Response($e->getCode(),$e->getMessage());
            }
        }
    }
?>