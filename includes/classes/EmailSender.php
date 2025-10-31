<?php
// Substitua pelo caminho correto para a sua instalação do PHPMailer
// Se usou Composer:
// require __DIR__ . '/../../vendor/autoload.php';

// Se instalou manualmente (Ajuste os caminhos):
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require_once __DIR__ . '/../../PHPMailer/src/Exception.php'; 
// require_once __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
// require_once __DIR__ . '/../../PHPMailer/src/SMTP.php';

class EmailSender {

    public static function enviarStatus($email_cliente, $nome_cliente, $id_reserva, $novo_status, $detalhes_reserva) {
        
        $mail = new PHPMailer(true);
        $assunto = "Atualização da Reserva #{$id_reserva} | La Tavola Fina";
        $corpo_html = self::gerarCorpoEmail($nome_cliente, $id_reserva, $novo_status, $detalhes_reserva);
        $corpo_texto = "Status da sua reserva #{$id_reserva} alterado para: {$novo_status}.";
        
        try {
            // Configurações do Servidor SMTP (AJUSTE AQUI)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Ex: smtp.gmail.com, mail.seudominio.com
            $mail->SMTPAuth   = true;
            $mail->Username   = 'latavolafina@gmail.com'; // Seu e-mail completo
            $mail->Password   = '1q2w3e4r5t6YU';   // Sua senha ou App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // 'ssl' ou 'tls'
            $mail->Port       = 587; // Ou 465 para SSL

            // Remetente e Destinatário
            $mail->setFrom('nao-responda@latavolafina.com', 'La Tavola Fina');
            $mail->addAddress($email_cliente, $nome_cliente);

            // Conteúdo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $assunto;
            $mail->Body    = $corpo_html;
            $mail->AltBody = $corpo_texto; // Versão em texto puro

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Registra o erro detalhado no log do servidor
            error_log("Erro ao enviar email para {$email_cliente}. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    private static function gerarCorpoEmail($nome, $id, $status, $detalhes) {
        $cor = ($status == 'Confirmada') ? '#28a745' : (($status == 'Cancelada') ? '#dc3545' : '#ffc107');

        // Note: Para 'Cancelada' o e-mail deve ser enviado ANTES de deletar, se você implementou a exclusão.
        
        return "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                <h2 style='color: #4a4a4a; border-bottom: 2px solid #eee; padding-bottom: 10px;'>
                    Atualização da Sua Reserva
                </h2>
                <p>Olá, <strong>{$nome}</strong>,</p>
                <p>O status da sua reserva (ID: <strong>#{$id}</strong>) no restaurante La Tavola Fina foi atualizado:</p>
                
                <p style='text-align: center; margin: 30px 0;'>
                    <span style='background-color: {$cor}; color: #fff; padding: 10px 20px; border-radius: 5px; font-weight: bold; font-size: 1.1em;'>
                        Status: {$status}
                    </span>
                </p>

                <h3 style='color: #4a4a4a; margin-top: 30px;'>Detalhes da Reserva:</h3>
                <ul style='list-style: none; padding: 0;'>
                    <li><strong>Data:</strong> " . date('d/m/Y', strtotime($detalhes['data_reserva'])) . "</li>
                    <li><strong>Hora:</strong> " . substr($detalhes['hora_reserva'], 0, 5) . "</li>
                    <li><strong>Pessoas:</strong> {$detalhes['num_pessoas']}</li>
                    <li><strong>Observações:</strong> " . htmlspecialchars($detalhes['observacoes']) . "</li>
                </ul>

                <p>Agradecemos a sua preferência.</p>
                <p>Atenciosamente,<br>Equipe La Tavola Fina</p>
                <div style='text-align: center; margin-top: 20px; font-size: 0.8em; color: #999;'>
                    Este é um e-mail automático, por favor, não responda.
                </div>
            </div>
        </body>
        </html>
        ";
    }
}