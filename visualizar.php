<!-- Digite aqui (visualizar.php) -->
<!-- 2º Arquivo a ser digitado -->

<?php

// Incluir a conexao com banco de dados
include_once "conexao.php";

// Receber oo UD via método GET
$id = filter_input(INPUT_GET, ' id', FILTER_SANITIZE_NUMBER_INT);

// Verifica se o ID não está vazio
if (!empty($id)) {
    // Query para selecionar informações do usuáruo e endereço associado
    $query_usuario = "SELECT usr.id, usr.nome, usr.email,
    ende.logadouro, ende.numero
    FROM usuarios AS usr
    LEFT JOIN enderecos AS ende ON ende.usuario_id=usr.id
    WHERE usr.id=:id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id);
    $result_usuario->execute();

    // Verifica se a consulta foi bem sucedida  e se há registros
    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        // Recupera os dados do usuário e endereço associado
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        $retorna = ['status' => true, 'dados' => $row_usuario];
    } else {
        // Senão houver regitros, retorna uma mensage de erro
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontardo!</div>"];
    }
} else {
    // Se o ID estiver vazio, retorna uma mensagem de erro
    $retorna = ['status' =>false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuario encontrado!</div>"];

}

// Retorna o resultado em JSON
echo json_encode($retorna);
