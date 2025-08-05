<?php
session_start();
if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $item = $_POST['item'];
  $preco = $_POST['preco'];
  if (!isset($_SESSION['carrinho'][$item])) {
    $_SESSION['carrinho'][$item] = ['quantidade' => 1, 'preco' => $preco];
  } else if ($_SESSION['carrinho'][$item]['quantidade'] < 99) {
    $_SESSION['carrinho'][$item]['quantidade']++;
  }
}

if (isset($_GET['acao'], $_GET['item'])) {
  $item = $_GET['item'];
  if ($_GET['acao'] === 'mais') {
    if ($_SESSION['carrinho'][$item]['quantidade'] < 99)
      $_SESSION['carrinho'][$item]['quantidade']++;
  } elseif ($_GET['acao'] === 'menos') {
    $_SESSION['carrinho'][$item]['quantidade']--;
    if ($_SESSION['carrinho'][$item]['quantidade'] <= 0)
      unset($_SESSION['carrinho'][$item]);
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#C8E6C9] p-6">
  <h1 class="text-2xl font-bold mb-4">Carrinho de Compras</h1>
  <ul class="mb-4">
    <?php $total = 0; foreach ($_SESSION['carrinho'] as $nome => $dados): 
      $subtotal = $dados['quantidade'] * $dados['preco'];
      $total += $subtotal;
    ?>
      <li>
        <?php echo "$nome - {$dados['quantidade']} x R$ {$dados['preco']}"; ?>
        <a href="?acao=mais&item=<?php echo urlencode($nome); ?>" class="ml-2">[+]</a>
        <a href="?acao=menos&item=<?php echo urlencode($nome); ?>" class="ml-1">[-]</a>
      </li>
    <?php endforeach; ?>
  </ul>
  <p>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
  <div class="mt-4 space-x-4">
    <a href="cardapio.php" class="bg-gray-500 text-white px-4 py-2 rounded">← Voltar</a>
    <a href="finalizar.php" class="bg-green-600 text-white px-4 py-2 rounded">Confirmar Pedido</a>
  </div>
</body>
</html>