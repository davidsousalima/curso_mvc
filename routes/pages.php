<?php
    use \App\Http\Response;
    use App\Controller\Pages;

    //ROTA HOME
    $obRouter->get('/curso_mvc/',[
        function(){
            return new Response(200,Pages\Home::getHome());
        }
    ]);
    //IMPRIME O RESPONSE DA ROTA
    $obRouter->Run()->sendResponse();
    //ROTA SOBRE
    $obRouter->get('/sobre',[
        function(){
            return new Response(200,Pages\About::getHome());
        }
    ]);

?> 