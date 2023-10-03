<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Organization;
    class Home extends Page{
        /**
         * Método respinsável por  retornar o conteudo (view) da nossa home
         * @return string
         */
        public static function getHome(){
            //ORGANIZAÇÂO
            $obOrganization = new Organization;
            
            //VIEW DA HOME
            $content = View::render('pages/home',[
                'name' => $obOrganization->name
            ]);
            //RETORNAR A VIEW DA PáGINA 
            return parent::getPage('Home > WDEV',$content); 
        }
    }
?>