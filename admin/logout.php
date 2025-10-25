<?php
// Inicia a sessão para garantir que podemos manipulá-la.
session_start();

// Remove todas as variáveis de sessão (limpa os dados).
session_unset();

// Destrói a sessão completamente no servidor.
session_destroy();

// Redireciona o usuário para a página de login.
header("Location: index.php");
exit(); 
?>