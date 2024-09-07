<?php

require_once 'lib/Database/Connection.php';
require_once 'app/Src/Sys.php';

require_once 'autoload.php';
require_once 'vendor/autoload.php';

$template = file_get_contents('app/view/html/estrutura.html');
$get      = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

ob_start();
    $core = new Core;
    $core->start($get);

    $saida = ob_get_contents();
ob_end_clean();
// Verifica se a estrutura deve ser inclu�da antes de processar o template
if (isset($includeStructure)) {
    $tplPronto = str_replace('{{ conteudo }}', $saida, $template);
} else {
    $tplPronto = $saida; // Se a estrutura n�o deve ser inclu�da, apenas use o conte�do sem modifica��o
}

echo $tplPronto;