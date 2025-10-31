<?php
const ALGORITMO_CRIPTOGRAFIA = 'aes-256-cbc';
const CHAVE_SECRETA = '02f0711767c86f6a27eae6ddfd3f1709a4943d48a71260835d5cfac0f98634cd';
const IV_TAMANHO = 16;

function encrypt_data($data) {
    $iv = openssl_random_pseudo_bytes(IV_TAMANHO);
    $encrypted = openssl_encrypt($data, ALGORITMO_CRIPTOGRAFIA, CHAVE_SECRETA, OPENSSL_RAW_DATA, $iv);
    // Retorna o IV e o dado criptografado, codificados em Base64 para armazenamento seguro.
    return base64_encode($iv . $encrypted);
}

function decrypt_data($data_base64) {
    // Se o dado estiver vazio ou não for string, retorna
    if (empty($data_base64) || !is_string($data_base64)) {
        return ''; 
    }

    // Decodifica de Base64
    $data = base64_decode($data_base64);

    // Verifica se a decodificação de Base64 resultou em dado suficiente para conter o IV
    if (strlen($data) < IV_TAMANHO) {
        // Logar erro ou retornar um marcador, pois o dado está corrompido ou não foi criptografado corretamente
        return '[Erro de Criptografia]'; 
    }

    // Extrai o IV do início da string
    $iv = substr($data, 0, IV_TAMANHO);
    
    // Extrai o texto criptografado (o restante da string)
    $encrypted_data = substr($data, IV_TAMANHO);

    // Descriptografa
    return openssl_decrypt(
        $encrypted_data,
        ALGORITMO_CRIPTOGRAFIA,
        CHAVE_SECRETA,
        OPENSSL_RAW_DATA,
        $iv
    );
}

?>