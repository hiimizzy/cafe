<?php
$conn = new mysqli("localhost", "root", "", "catcafe");
$pedido = $conn->query("SELECT * FROM pedidos WHERE finalizado = 0 ORDER BY data_hora ASC LIMIT 1")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $conn->query("UPDATE pedidos SET finalizado = 1 WHERE id = $id");
  header("Location: admin.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#C8E6C9] p-6 text-[#4E342E] min-h-screen flex items-center justify-center">
  <div class="max-w-xl w-full bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Painel do Admin</h1>
    <?php if ($pedido): ?>
      <div class="bg-[#F5F5F5] p-4 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-2">Pedido de <?php echo htmlspecialchars($pedido['nome_cliente']); ?></h2>
        <ul class="mb-4 list-disc list-inside">
          <?php
          $itens = $conn->query("SELECT * FROM itens_pedido WHERE pedido_id = {$pedido['id']}");
          while ($item = $itens->fetch_assoc()): ?>
            <li><?php echo "{$item['nome_item']} - {$item['quantidade']} x R$ " . number_format($item['preco'], 2, ',', '.'); ?></li>
          <?php endwhile; ?>
        </ul>
        <form method="POST">
          <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Finalizar Pedido</button>
        </form>
      </div>
    <?php else: ?>
      <p class="text-center text-lg">Sem pedidos no momento.</p>
    <?php endif; ?>
  </div>
</body>
</html>