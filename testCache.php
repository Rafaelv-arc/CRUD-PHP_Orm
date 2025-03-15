<?php
require 'Cache.php';

// Armazena dados no cache
Cache::set('usuario_1', ['nome' => 'Alice', 'idade' => 28]);

// Obtém dados do cache
$usuario = Cache::get('usuario_1');

if ($usuario) {
    echo "Usuário: " . $usuario['nome'] . ", Idade: " . $usuario['idade'] . "\n";
} else {
    echo "Nenhum dado encontrado no cache.\n";
}

// Remove a chave do cache
Cache::delete('usuario_1');
$usuarioRemovido = Cache::get('usuario_1');

if (!$usuarioRemovido) {
    echo "Dados removidos com sucesso.\n";
} else {
    echo "Falha ao remover os dados.\n";
}



// Teste básico: Salvar uma chave
Cache::set('teste_chave', 'valor_de_teste', 300);

echo "Chave 'teste_chave' salva com sucesso.\n";

?>


