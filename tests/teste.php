<?php 
require "../src/NovoCNPJ.php";

$testes = [

    [
        "descricao" => "Numérico válido",
        "cnpj" => "11222333000181",
        "esperado" => true
    ],

    [
        "descricao" => "Numérico válido formatado",
        "cnpj" => "11.222.333/0001-81",
        "esperado" => true
    ],

    [
        "descricao" => "Alfanumérico válido",
        "cnpj" => "ML.J2V.WCK/0001-80",
        "esperado" => true
    ],

    [
        "descricao" => "Alfanumérico sem máscara",
        "cnpj" => "MLJ2VWCK000180",
        "esperado" => true
    ],

    [
        "descricao" => "Vazio",
        "cnpj" => "",
        "esperado" => false
    ],

    [
        "descricao" => "Muito curto",
        "cnpj" => "123456",
        "esperado" => false
    ],

    [
        "descricao" => "Muito longo",
        "cnpj" => "12345678901234567890",
        "esperado" => false
    ],

    [
        "descricao" => "Numérico inválido",
        "cnpj" => "11222333000182",
        "esperado" => false
    ],

    [
        "descricao" => "Numérico inválido formatado",
        "cnpj" => "11.222.333/0001-82",
        "esperado" => false
    ],

    [
        "descricao" => "Alfanumérico inválido",
        "cnpj" => "ML.J2V.WCK/0001-81",
        "esperado" => false
    ],

];

foreach ($testes as $teste) {

    $resultado = NovoCNPJ::validar($teste["cnpj"]);

    echo sprintf(
        "[%s] %s\n",
        $resultado === $teste["esperado"] ? "OK" : "ERRO",
        $teste["descricao"]
    );
}
