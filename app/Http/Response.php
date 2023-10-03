<?php
    namespace App\Http;
    class Response{
        /**
         * Código do Status HTTP
         * @var integer
         */
        private $httpCode = 200;
        /**
         * Cabeçalho do Reponse
         * @var array
         */
        private $headers = [];

        /**
         * Tipo de conteudo que está sendo retornado
         * @var string
         */
        private $contentType = 'text/html';

        /**
         * Conteudo do Response
         * @var mixed
         */
        private $content;
        /**
         * Metodo responsavel por iniciar a classe e definir
         * @param integer $httpCode
         * @param mixed  $content
         * @param string $contentType
         */
        public function __construct($httpCode,$content,$contentType = 'text/html'){
            $this->httpCode = $httpCode;
            $this->content = $content;
            $this->setContentType($contentType);
        }
        /**
         * Método responsavel por alterar o content type do response
         * @param string
         */
        public function setContentType($contentType){
            $this->contentType =$contentType;
            $this->addHeader('Content-Type',$contentType);
        }
        /**
         * Metodo responsavel por adicionar um registro no cabeçalho do response
         * @param string $key
         * @param string $value
         */
        public function addHeader($key,$value){
            $this->headers[$key] =$value;
        }
        /**
         * Metodo responsavel por enviar os headers para o navegador
         */
        private function sendHeaders(){
            //STATUS
            http_response_code($this->httpCode);
            //ENVIAR HEADERS
            foreach($this->headers as $key=>$value){
                header($key.': '.$value);
            }
        }
        /**
         * Método responsável por enviar a resposta para o usuário
         * 
         */
        public function sendResponse(){
            //ENVIAR OS HEADERS
            $this->sendHeaders();
            //IMPRIME O CONTEUDO
            switch ($this->contentType){
                case 'text/html':
                    echo $this->content;
                    exit;
                
            }
        }
    }
?>