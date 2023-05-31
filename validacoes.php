<?php
function validar_dados($dados) {
    if ($dados['camas_solteiro'] < 0 || $dados['camas_casal'] < 0) {
        return false;
    }
    if ($dados['camas_solteiro'] + $dados['camas_casal'] <= 0) {
        return false;
    }
    if ($dados['reservado'] != 0 && $dados['reservado'] != 1) {
        return false;
    }
    return true;
}
?>
