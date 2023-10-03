<?php
    namespace App\Http;
    class Request{
        /**
         * Metodo HTTP da requisição
         * @var string
         */
        private $httpMethod;

        /**
         * URI da página
         * @var string
         */
        private $uri;

        /**
         * Parâmentros da URL ($_GET)
         * @var array
         */
        private $queryParams = [];

        /**
         * Variáveis recebidas no POST da página  ($_POST)
         * @var array
         */
        private $postVars = [];
        /**
         * Cabeçalho da requisição
         * @var array
         */
        private $headers = [];

        /**
         * Construtor da classe
         * @
         */
        public function __construct(){
            $this->queryParams =$_GET ?? [];
            $this->postVars =$_POST ?? [];
            $this->headers = getallheaders();
            $this->httpMethod =$_SERVER['REQUEST_METHOD'] ?? '';
            $this->uri =$_SERVER['REQUEST_URI'] ?? '';
        }
        /**
         * Método responsavel por retornar uma método http da requisição
         * @return string
         */
        public function getHttpMethod(){
            return $this->httpMethod;
        }
        /**
         * Método responsavel por retornar a URI da requisição
         * @return string 
         */
        public function getURI(){
            return $this->uri;
        }
        /**
         * Metodo responsavel por retornar os headers da requisição
         * @return array
         */
        public function getHeaders(){
            return $this->headers;
        }
        /**
         * Metodo responsavel por retornar os parâmetros da URL da requisição 
         * @return array
         */
        public function getQueryParams(){
            return $this->queryParams;
        }
        /**
         * Método responsavel por retornar as variáveis POST da requisição
         * @return array 
         */
        public function getPostVars(){
            return $this->postVars;
        }
    }
?>