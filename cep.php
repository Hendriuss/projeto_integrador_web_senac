<?php

header('Content-Type: application/json; charset=utf-8');

$cep = filter_input(INPUT_GET, 'cep', FILTER_SANITIZE_STRING);

if ($cep) {
    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/{$cep}/json/";

    // Faz a requisição HTTP
    $response = file_get_contents($url);

    // Decodifica a resposta JSON
    $data = json_decode($response, true);

    // Verifica se houve erro na resposta da API
    if (isset($data['erro'])) {
        echo json_encode(['erro' => true, 'mensagem' => 'CEP não encontrado.']);
    } else {
        echo json_encode($data);
    }
} else {
    echo json_encode(['erro' => true, 'mensagem' => 'CEP inválido.']);
}

?>