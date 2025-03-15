<?php
require_once "product.php";

// Definições iniciais
$product = null;
$message = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["save"])) { // Criar ou atualizar produto
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock']
        ];
        
        if (!empty($_POST["id"])) { // Atualizar
            Product::update($_POST["id"], $data);
            $message = "Produto atualizado com sucesso!";
        } else { // Criar novo
            Product::create($data);
            $message = "Produto criado com sucesso!";
        }
    }
}

// Excluir produto
if (isset($_GET["delete"])) {
    Product::delete($_GET["delete"]);
    $message = "Produto excluído!";
}

// Editar produto (preenche o formulário com dados do produto)
if (isset($_GET["edit"])) {
    $product = Product::find($_GET["edit"]);
}

// Obter todos os produtos para listar na página
$products = Product::all();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
        .message { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Gerenciamento de Produtos</h1>

    <!-- Exibe mensagens de sucesso -->
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <!-- Formulário de Cadastro e Edição -->
    <form method="post">
        <input type="hidden" name="id" value="<?= $product['id'] ?? '' ?>">
        <label>Nome:</label>
        <input type="text" name="name" value="<?= $product['name'] ?? '' ?>" required>
        <label>Preço:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?? '' ?>" required>
        <label>Estoque:</label>
        <input type="number" name="stock" value="<?= $product['stock'] ?? '' ?>" required>
        <button type="submit" name="save">Salvar</button>
    </form>

    <!-- Tabela de Produtos -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['name'] ?></td>
                <td>R$ <?= number_format($p['price'], 2, ',', '.') ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a href="?edit=<?= $p['id'] ?>">Editar</a> |
                    <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
