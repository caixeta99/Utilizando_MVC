
<?php

error_reporting(-1);

const LOG = true;

function phpErro($erro, $mensagem, $arquivo, $linha)
{

    switch ($erro):

        case 2:
            $css = 'alert-warning';

            break;

        case 8:
            $css = 'alert-primary ';
            break;
        default:
            $css = '';
    endswitch;

    echo "<P class=\"alert {$css} m-2\"><b>Erro:</b> {$mensagem} <b>no arquivo</b>  {$arquivo} <b>na linha</b> <strong class=\"text-danger \"> {$linha}</strong> <b>do tipo</b>  {$erro}";


    if(LOG) :
        $logs = "Erro: {$mensagem} no arquivo  {$arquivo} na linha  {$linha} do tipo  {$erro}\n";
        error_log($logs, 3, "" . dirname(__FILE__) . "..\..\logs\logErros.log");
    endif;

    if ($erro == 1 || $erro == 256) :
        die();
    endif;
}

set_error_handler('phpErro');
