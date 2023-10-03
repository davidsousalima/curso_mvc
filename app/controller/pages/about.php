<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Organization;
    class About extends Page{
        /**
         * Método respinsável por  retornar o conteudo (view) da nossa home
         * @return string
         */
        public static function getHome(){
            //ORGANIZAÇÂO
            $obOrganization = new Organization;
            
            //VIEW DA HOME
            $content = View::render('pages/about',[
                'name' => $obOrganization->name,
                'description'=>$obOrganization->decription,
                'site' =>$obOrganization->site
            ]);
            //RETORNAR A VIEW DA PáGINA 
            return parent::getPage('SOBRE > WDEV',$content); 
        }
    }
?>