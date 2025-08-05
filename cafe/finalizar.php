<?php
session_start();
$cliente = $_SESSION['cliente'] ?? 'Cliente';
$conn = new mysqli("localhost", "root", "", "catcafe");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

$conn->query("INSERT INTO pedidos (nome_cliente) VALUES ('$cliente')");
$id = $conn->insert_id;

foreach ($_SESSION['carrinho'] as $nome => $dados) {
  $qtd = $dados['quantidade'];
  $preco = $dados['preco'];
  $conn->query("INSERT INTO itens_pedido (pedido_id, nome_item, quantidade, preco) VALUES ($id, '$nome', $qtd, $preco)");
}

unset($_SESSION['carrinho']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Pedido Finalizado</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#C8E6C9] min-h-screen flex items-center justify-center text-[#4E342E]">
  <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full">
    <h1 class="text-2xl font-bold mb-4">Pedido confirmado! 🎉</h1>
    <p class="mb-6">Obrigado, <span class="font-semibold"><?php echo htmlspecialchars($cliente); ?></span>. Seu pedido foi registrado com sucesso.</p>
    <a href="cardapio.php" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Fazer novo pedido</a>
  </div>
</body>
</html>
