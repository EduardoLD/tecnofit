<?php

// Função de carregamento automático
function my_autoloader($class) {
    
    $caminhos = [
        'app/Controller/',
        'app/Model/',
        'app/Core/',
        'app/Src/'
    ];

    foreach ( $caminhos as $key => $caminho ) {
        $arquivo = $caminho . $class . '.php';

        if ( file_exists($arquivo) ) {
            require_once $arquivo;
        }
    }
}

// Registrar a função de carregamento automático
spl_autoload_register('my_autoloader');
