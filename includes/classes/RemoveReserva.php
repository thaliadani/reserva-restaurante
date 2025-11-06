<?php
// Define o fuso horário para garantir que a comparação de tempo seja correta.
date_default_timezone_set('America/Sao_Paulo');
 
require_once __DIR__ . '/Database.php';
 
class RemoveReserva
{
    private $db;
 
    /**
     * Construtor da classe.
     * @param Database $db A instância da classe de banco de dados.
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
 
    /**
     * Remove as reservas cuja data e hora já passaram.
     * Assume-se que a tabela de reservas se chama 'reservas' e possui as colunas 'data_reserva' (DATE) e 'horario_reserva' (TIME).
     * @return bool Retorna true se a operação foi bem-sucedida, false caso contrário.
     */
    public function removerReservasExpiradas()
    {
        try {
            $conn = $this->db->getConnection();
            // Combina a data e o horário da reserva e compara com a data e hora atuais.
            $sql = "DELETE FROM reservas WHERE STR_TO_DATE(CONCAT(data_reserva, ' ', horario_reserva), '%Y-%m-%d %H:%i:%s') < NOW()";
            $stmt = $conn->prepare($sql);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Em um ambiente de produção, seria ideal logar este erro em vez de exibi-lo.
            error_log("Erro ao remover reservas expiradas: " . $e->getMessage());
            return false;
        }
    }
}