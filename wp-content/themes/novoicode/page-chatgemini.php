<?php

// Arquivo: /wp-content/themes/novoicode/page-chatgemini.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['messages']) || !is_array($input['messages']) || empty($input['messages'])) {
    echo json_encode(['error' => 'Parâmetro "messages" ausente, inválido ou vazio']);
    exit;
}

$last_message = end($input['messages']);
if (!isset($last_message['content'])) {
    echo json_encode(['error' => 'A última mensagem não possui o campo "content"']);
    exit;
}

$pergunta = sanitize_text_field($last_message['content']);
$contexto = "Você é um assistente virtual do ICODE, com acesso a conteúdos internos da empresa em forma de posts e documentos indexados (atas, pautas, deliberações). Tem capacidade de responder sobre nome de pessoas do Instituto de Computação - Unicamp";
$out_of_context_response = "ICODE - IC.";

$array_membros = get_user_meta(wp_get_current_user()->ID, 'membro', true);

global $wpdb;
$max_content_length = 4000;

// Busca nos posts do WordPress
$post_results = get_posts([
    'post_type' => $array_membros,
    'posts_per_page' => 50,
    's' => $pergunta
]);

$post_content = '';
$post_fontes = [];
foreach ($post_results as $post) {
    $post_content .= "\nTítulo: {$post->post_title}\n";
    $post_content .= strip_tags($post->post_content) . "\n";
    $post_fontes[] = [
        'tipo' => 'post',
        'titulo' => $post->post_title,
        'url' => get_permalink($post->ID)
    ];
    if (strlen($post_content) > $max_content_length / 2)
        break;
}

// Busca na tabela de PDFs
if (!empty($array_membros)) {
    $placeholders = implode(',', array_fill(0, count($array_membros), '%s'));
    $query = "
        SELECT id, arquivo, url, texto 
        FROM {$wpdb->prefix}pdf_index 
        WHERE texto LIKE %s AND tipo IN ($placeholders)
        LIMIT 10
    ";
    $params = array_merge(['%' . $wpdb->esc_like($pergunta) . '%'], $array_membros);
    $pdf_rows = $wpdb->get_results($wpdb->prepare($query, ...$params));
}

$pdf_content = '';
$pdf_fontes = [];
foreach ($pdf_rows as $row) {
    $nome_arquivo = basename($row->arquivo);
    $pdf_content .= "\nArquivo: " . $nome_arquivo . "\n";
    $pdf_content .= mb_substr($row->texto, 0, 800) . "\n";

    $fonte_pdf = [
        'tipo' => 'pdf',
        'nome' => $nome_arquivo,
        'url' => $row->url
    ];

    $pdf_fontes[] = $fonte_pdf;
    if (strlen($pdf_content) > $max_content_length / 2)
        break;
}

// Junta o contexto
$contexto_completo = $contexto . "\n\nConteúdo relevante encontrado no sistema:\n\n" . $post_content . $pdf_content;
if (strlen($contexto_completo) > $max_content_length) {
    $contexto_completo = mb_substr($contexto_completo, 0, $max_content_length) . "...";
}

// Chave da API Gemini
$api_url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
$api_key = 'AIzaSyBXhVigywfKp2J9u-B26cYJ7QPDNzmI1Ew'; // Substitua por sua chave real

$payload = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                [
                    'text' => $contexto_completo .
                        "\n\nCom base nesse conteúdo, responda a seguinte pergunta: " . $pergunta .
                        "\nSe a pergunta não estiver relacionada à empresa IC ou aos dados acima, diga: \"$out_of_context_response\""
                ]
            ]
        ]
    ]
];

$ch = curl_init("$api_url?key=$api_key");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Resposta final para o front-end
if ($http_code >= 400) {
    echo json_encode(['error' => 'Erro na API Gemini', 'http_code' => $http_code, 'api_response' => json_decode($response, true)]);
} else {
    $data = json_decode($response, true);
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        echo json_encode([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => $data['candidates'][0]['content']['parts'][0]['text'],
                                'fontes' => [
                                    'posts' => $post_fontes,
                                    'pdfs' => $pdf_fontes
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    } else {
        echo json_encode(['error' => 'Resposta inesperada da API Gemini', 'api_response' => $data]);
    }
}