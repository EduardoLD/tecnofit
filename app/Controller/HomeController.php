<?php

Class HomeController 
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('app/View/Html');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('home.twig');

        $parametros = array();

        $conteudo = $template->render($parametros);
        
        echo $conteudo;
    }
}