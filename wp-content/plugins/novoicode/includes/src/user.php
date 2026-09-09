<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/user.php
// ************************************************************************************** Lista de Usuários

// Função auxiliar para obter tipos dinamicamente
function get_tipos_configurados()
{
    return array_map('trim', explode(',', get_option('portal_input_7', '')));
}


//************* Docentes
function lista_docentes_intranet()
{
    $url = INTRANET . "/docentes/siteic";
    $response = wp_remote_get($url, ['sslverify' => false]);

    if (is_wp_error($response)) {
        error_log('Erro ao acessar API docentes: ' . $response->get_error_message());
        return '[]';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Erro ao decodificar JSON docentes: ' . json_last_error_msg());
        return '[]';
    }

    $docentes = [];
    if (isset($data['data']['ativos']) && is_array($data['data']['ativos'])) {
        foreach ($data['data']['ativos'] as $docente_api) {
            $departamento = $docente_api['Departamento'] ?? '';
            preg_match('/ - (\bD[STC][SICT]\b)$/', $departamento, $matches);

            $docentes[] = [
                'nome' => trim($docente_api['Nome'] ?? ''),
                'photo_url' => $docente_api['Foto Pessoal'] ?? null,
                'cargo' => $docente_api['Cargo'] ?? '',
                'email' => $docente_api['Email'] ?? '',
                'departamento' => $matches[1] ?? '',
                'matricula' => $docente_api['Matrícula'] ?? '',
                'telefone' => $docente_api['Telefone'] ?? '',
                'sala' => $docente_api['Sala'] ?? '',
                'lattes' => $docente_api['Currículo Lattes'] ?? ''
            ];
        }
    }

    return json_encode($docentes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
add_action("lista_docentes_intranet", "lista_docentes_intranet");



//************* Funcionarios IC
function lista_funcionarios_intranet()
{
    $url = INTRANET . "/funcionarios/siteic";
    $response = wp_remote_get($url, ['sslverify' => false]);

    if (is_wp_error($response)) {
        error_log('Erro ao acessar API funcionários: ' . $response->get_error_message());
        return '[]';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Erro ao decodificar JSON funcionários: ' . json_last_error_msg());
        return '[]';
    }

    $funcionarios = [];
    if (isset($data['data']['ativos']) && is_array($data['data']['ativos'])) {
        foreach ($data['data']['ativos'] as $funcionario_api) {
            $funcionarios[] = [
                'nome' => trim($funcionario_api['Nome'] ?? ''),
                'photo_url' => $funcionario_api['Foto Pessoal'] ?? null,
                'cargo' => $funcionario_api['Cargo'] ?? '',
                'email' => $funcionario_api['Email'] ?? '',
                'matricula' => $funcionario_api['Matrícula'] ?? '',
                'secao' => $funcionario_api['Seção'] ?? '',
                'telefone' => $funcionario_api['Telefone'] ?? '',
                'sala' => $funcionario_api['Sala'] ?? ''
            ];
        }
    }

    return json_encode($funcionarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
add_action("lista_funcionarios_intranet", "lista_funcionarios_intranet");



// ********************* Lista Usuários por Departamento na Intranet
function lista_usuarios_colegiado($depto)
{
    $url_intranet = INTRANET . "/composicao_" . $depto . "/json?modo=short";
    $response = wp_remote_get($url_intranet);

    if (is_wp_error($response)) {
        error_log('Erro ao acessar API departamento ' . $depto . ': ' . $response->get_error_message());
        return [];
    }

    $dados = json_decode(wp_remote_retrieve_body($response));
    $emails = [];

    $campos = ['chefe', 'vice_chefe', 'sec_acad'];
    foreach ($campos as $campo) {
        if (isset($dados->data->$campo->email_inst)) {
            $emails[] = $dados->data->$campo->email_inst;
        }
        if (isset($dados->data->$campo->email_sise)) {
            $emails[] = $dados->data->$campo->email_sise;
        }
    }

    $tipos_membros = ['docentes', 'titulares', 'suplentes'];
    foreach ($tipos_membros as $tipo) {
        if (isset($dados->data->$tipo) && is_array($dados->data->$tipo)) {
            foreach ($dados->data->$tipo as $membro) {
                if (isset($membro->email_inst))
                    $emails[] = $membro->email_inst;
                if (isset($membro->email_sise))
                    $emails[] = $membro->email_sise;
            }
        }
    }

    return array_unique(array_filter($emails));
}
add_action("lista_usuarios_colegiado", "lista_usuarios_colegiado");



// ******************* Retorna Membro Intranet
function retorna_membro($email)
{
    $slugs_array = get_tipos_configurados();

    // 1. PRIMEIRO: Garante que tenha acesso aos tipos obrigatórios
    $grupos = array_map('trim', explode(',', get_option('portal_input_10', '')));
  
    // 2. SEGUNDO: Busca nos colegiados
    foreach ($slugs_array as $slug) {
        if (!empty($slug) && in_array($email, lista_usuarios_colegiado($slug), true)) {
            $grupos[] = $slug;
        }
    }

    // 3. TERCEIRO: Busca no site IC
    $docentes = json_decode(lista_docentes_intranet(), true);
    foreach ($docentes as $professor) {
        if (isset($professor['email']) && $professor['email'] === $email && !empty($professor['departamento'])) {
            $depto_slug = strtolower($professor['departamento']);
            // Adiciona apenas se for um tipo válido configurado
            if (in_array($depto_slug, $slugs_array)) {
                $grupos[] = $depto_slug;
            }
            break;
        }
    }

    // Elimina duplicidades e retorna
    return array_unique($grupos);
}
add_action('retorna_membro', 'retorna_membro');