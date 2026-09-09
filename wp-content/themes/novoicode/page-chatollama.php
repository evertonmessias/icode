<?php
# Arquivo: /wp-content/themes/novoicode/page-chatollama.php

error_log('==== NOVA REQUISIÇÃO CHAT IA ====');

header('Content-Type: application/json');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// 🔹 Permitir streaming
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', false);
@ini_set('implicit_flush', true);
while (ob_get_level()) ob_end_flush();
ob_implicit_flush(true);

// =============================
// LER JSON DA REQUISIÇÃO
// =============================

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['model']) || !isset($input['messages'])) {
    echo json_encode(["type" => "error", "content" => "Requisição inválida"]) . "\n";
    exit;
}

$model = escapeshellarg($input['model']);

// 🔹 pegar última mensagem do usuário
$messages = $input['messages'];
$lastMessage = end($messages);

if (!$lastMessage || !isset($lastMessage['content'])) {
    echo json_encode(["type" => "error", "content" => "Pergunta não encontrada"]) . "\n";
    exit;
}

$pergunta = escapeshellarg($lastMessage['content']);

error_log("Modelo: " . $input['model']);
error_log("Pergunta: " . $lastMessage['content']);

// =============================
// EXECUTAR PYTHON COM STREAMING
// =============================

$cmd = "python3 ". ABSPATH ."ia/phpqueryia.py $model $pergunta";

$descriptorspec = [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
];

$process = proc_open($cmd, $descriptorspec, $pipes);

if (!is_resource($process)) {
    echo json_encode(["type" => "error", "content" => "Erro ao iniciar processo Python"]) . "\n";
    exit;
}

fclose($pipes[0]); // não vamos escrever no stdin

// 🔹 STREAM REAL
while (!feof($pipes[1])) {

    $linha = fgets($pipes[1]);

    if ($linha === false) {
        usleep(10000);
        continue;
    }

    $linha = trim($linha);

    if ($linha === '') continue;

    echo json_encode([
        "type" => "chunk",
        "content" => $linha . "\n"
    ]) . "\n";

    flush();
}

// Ler possíveis erros
$stderr = stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);

$return_value = proc_close($process);

if ($stderr) {
    error_log("Erro Python: " . $stderr);
    echo json_encode([
        "type" => "error",
        "content" => "Erro interno da IA"
    ]) . "\n";
    flush();
    exit;
}

// Finalizar stream
echo json_encode(["done" => true]) . "\n";
flush();
exit;
