# Sistema de Reservas - La Tavola Fina

<p align="center">
  <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Licença MIT">
  <img src="https://img.shields.io/badge/php-^7.4 | ^8.0-blue" alt="Versão do PHP">
  <img src="https://img.shields.io/badge/status-funcional-green" alt="Status do Projeto">
</p>

## 📖 Sobre

**La Tavola Fina - Sistema de Reservas** é uma aplicação web desenvolvida para simplificar e otimizar a gestão de reservas de um restaurante. O projeto nasceu da necessidade de criar uma ferramenta administrativa centralizada, segura e eficiente, que permitisse aos funcionários do restaurante visualizar e gerenciar todas as solicitações de reserva feitas pelos clientes.

Este sistema resolve o problema da gestão manual e descentralizada de reservas, oferecendo um painel de controle onde é possível alterar o status de uma reserva (de "Pendente" para "Confirmada" ou "Cancelada") com apenas um clique. O grande diferencial é a **comunicação automatizada**: ao confirmar ou cancelar uma reserva, o sistema envia automaticamente um e-mail profissional para o cliente, mantendo-o informado e melhorando a sua experiência.

## 📜 Tabela de Conteúdos

*   Sobre
*   Funcionalidades
*   Tecnologias Utilizadas
*   Como Começar
*   Configuração
*   Como Contribuir
*   Licença

## ✨ Funcionalidades

*   **Painel Administrativo Seguro:** Acesso restrito com sistema de login e senha para administradores.
*   **Cadastro de Administradores:** Interface para cadastrar novos usuários administrativos com senhas criptografadas (hash).
*   **Listagem de Reservas:** Visualização de todas as reservas em uma tabela clara e organizada, com informações do cliente, data, hora e observações.
*   **Gerenciamento de Status:** Alteração do status de cada reserva (`Pendente`, `Confirmada`, `Cancelada`) diretamente na lista.
*   **Notificações por E-mail:** Envio automático de e-mails para o cliente quando uma reserva é `Confirmada` ou `Cancelada`.
*   **Segurança de Dados:** As informações sensíveis do cliente (e-mail e telefone) são criptografadas no banco de dados.

## 🛠️ Tecnologias Utilizadas

*   **Backend:** PHP 8
*   **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
*   **Framework CSS:** Bootstrap 5
*   **Banco de Dados:** MySQL com PDO para conexões seguras.
*   **Dependências:** PHPMailer para envio de e-mails.

## 🚀 Como Começar

Instruções detalhadas sobre como configurar e executar o seu projeto localmente.

### Pré-requisitos

*   Um ambiente de desenvolvimento local como XAMPP, WAMP ou LAMP.
*   PHP 7.4 ou superior.
*   Banco de dados MySQL ou MariaDB.
*   Composer para gerenciar as dependências do PHP.

### Instalação

Forneça um guia passo a passo sobre como instalar o projeto.

1.  Clone o repositório para o diretório do seu servidor web (ex: `htdocs` no XAMPP):
    ```bash
    git clone https://github.com/seu-usuario/reserva-restaurante.git
    ```
2.  Navegue até o diretório do projeto:
    ```bash
    cd reserva-restaurante
    ```
3.  Instale as dependências do PHP (como o PHPMailer) usando o Composer:
    ```bash
    composer install
    ```
4.  Importe o arquivo `.sql` do banco de dados (você precisará criar este arquivo) para o seu gerenciador de banco de dados (como phpMyAdmin).

## ⚙️ Configuração

Antes de executar o projeto, você precisa configurar as credenciais do banco de dados e do serviço de e-mail.

1.  **Banco de Dados:**
    *   Abra o arquivo `includes/config/database.php`.
    *   Altere as constantes `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASS` com as credenciais do seu banco de dados local.

2.  **Envio de E-mail:**
    *   Abra o arquivo `includes/classes/EmailSender.php`.
    *   Na linha 30, substitua o valor da variável `$mail->Password` pela sua **"Senha de App"** gerada na sua conta Google.
    > **Importante:** Não use a sua senha normal do Gmail. Você precisa gerar uma "Senha de App" específica para esta aplicação. Saiba como aqui.

3.  **Chave de Criptografia:**
    *   Abra o arquivo `includes/config/security.php`.
    *   **É altamente recomendável** que você altere os valores das constantes `ENCRYPTION_KEY` e `ENCRYPTION_IV` para chaves aleatórias e seguras. Você pode usar um gerador online para criar valores seguros.

Após a configuração, acesse `http://localhost/reserva-restaurante/admin/` no seu navegador para ver a tela de login do painel administrativo.

## 🤔 Como Contribuir

1.  Faça um *fork* do projeto.
2.  Crie uma nova *branch* (`git checkout -b feature/nova-funcionalidade`).
3.  Faça o *commit* das suas alterações (`git commit -m 'Adiciona nova funcionalidade'`).
4.  Faça o *push* para a *branch* (`git push origin feature/nova-funcionalidade`).
5.  Abra um *Pull Request*.

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
