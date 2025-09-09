<?php
// Definições de headers
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem (Vercel)
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verifica se é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitização dos dados
    $nome = trim(strip_tags($_POST["nome"] ?? ""));
    $email = trim(strip_tags($_POST["email"] ?? ""));
    $mensagem = trim(strip_tags($_POST["mensagem"] ?? ""));

    // Verifica campos obrigatórios
    if ($nome && filter_var($email, FILTER_VALIDATE_EMAIL) && $mensagem) {
        $to = "luiz.gabriel12br@gmail.com"; // ALTERE para seu email
        $subject = "Novo contato do portfólio: $nome";
        $body = "Nome: $nome\nE-mail: $email\n\nMensagem:\n$mensagem";

        // Cabeçalhos: use email do próprio domínio para evitar bloqueio no InfinityFree
        $headers = "From: luiz.gabriel12br@gmail.com\r\n"; // substitua pelo email do seu domínio
        $headers .= "Reply-To: $email\r\n";

        // Envia o e-mail
        if (mail($to, $subject, $body, $headers)) {
            echo json_encode(["success" => true, "message" => "Mensagem enviada com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao enviar e-mail."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Preencha os campos corretamente."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método inválido."]);
}
