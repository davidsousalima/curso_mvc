<?php
    namespace App\Utils;
    class View{
        /**
         * Variáveis padrões da View
         * @var array 
         */
        private static $vars;
        /**
         * Método responsável por definir os dados inicuas da classe
         * @param array $vars
         */
        public static function init($vars = []){
            self::$vars = $vars;
        }
        /**
         * Método responsavel por retornar o conteudo de uma view
         * @param string $view
         * @return string
         */
        private static function getContentView($view){
            $file =__DIR__.'/../../resources/view/'.$view.'.html';
            return file_exists($file) ? file_get_contents($file):'';
        }
        /**
         * Metodo responsavel por retornar o conteudo renderizado de uma view
         * @param string $view
         * @param array $vars (string/numeric)
         * @return string
         */
        public static function render($view, $vars = []){
            //Conteudo da View
            $contentView = self::getContentView($view);

            //MERGE DE VARIAVEIS DA VIEW
            $vars = array_merge(self::$vars,$vars);
            
            //Chaves do Arrays de variaveis
            $keys = array_keys($vars);
            $keys = array_map(function($item){
                return '{{'.$item.'}}';
            },$keys);
            
            //Retornar o conteudo renderizado
            return str_replace($keys,array_values($vars),$contentView);
        }
    }
?>