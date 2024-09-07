<?php

Class Core
{
    public function start($url)
    {
        if ( isset($url['op']) ) {
            $acao = $url['op'];
        } else {
            $acao = 'index';
        }

        if ( isset($url['p']) ) {
            $controller = ucfirst($url['p'].'Controller');
        } else {
            $controller = 'HomeController';
        }

        if ( !class_exists($controller) ) {
            $controller = 'ErroController';
        }

        if ( isset($url['id']) && $url['id'] != null ) {
            $id = $url['id'];
        } else {
            $id = null;
        }

        call_user_func_array(array(new $controller, $acao), array($id));
    }
}