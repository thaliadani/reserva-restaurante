<?php
// 1. Inicia a sessão para garantir que podemos manipulá-la
session_start();

// 2. Remove todas as variáveis de sessão (limpa os dados)
session_unset();

// 3. Destrói a sessão completamente no servidor
session_destroy();

// 4. Redireciona o usuário para a página de login
// Como logout.php está dentro de admin/, ele redireciona para index.php (que está na mesma pasta)
header("Location: index.php");
exit(); 
?>