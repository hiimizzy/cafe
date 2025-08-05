<?php
session_start();
if (isset($_GET['trocar']) && $_GET['trocar'] === '1') {
    unset($_SESSION['cliente']);
    header("Location: index.php");
    exit();
  }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $item = $_POST['item'];
  $preco = $_POST['preco'];
  if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho'] = [];
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CatCafe - Cardápio</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#C8E6C9] text-[#4E342E]">
<header class="bg-[#D7CCC8] text-center py-6">
  <img src="src/pancake.jpg" alt="foto" class="w-32 h-32 mx-auto rounded-full shadow-lg" />
  <h1 class="text-4xl font-semibold">CatCafe</h1>
  <p>Olá, <?php echo $_SESSION['cliente'] ?? 'Visitante'; ?>! Faça seu pedido 💚</p>
  <form action="cardapio.php" method="GET" class="mt-2">
    <input type="hidden" name="trocar" value="1">
    <button type="submit" class="text-sm bg-red-400 text-white px-4 py-1 rounded hover:bg-red-500">Trocar nome</button>
  </form>
</header>

  <section class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl text-center mb-6">Nosso Cardápio</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php
      $itens = [
        ['nome' => 'Iced Coffee', 'preco' => 8.00, 'img' => 'icedcoffe.jpg'],
        ['nome' => 'Capuccino', 'preco' => 8.00, 'img' => 'cafe.jpg'],
        ['nome' => 'Café Latte', 'preco' => 8.00, 'img' => 'cafelatte.jpg'],
        ['nome' => 'Panqueca', 'preco' => 16.00, 'img' => 'panqueca.jpg'],
        ['nome' => 'Cookie', 'preco' => 6.00, 'img' => 'cookie.jpg'],
        ['nome' => 'Brownie', 'preco' => 10.00, 'img' => 'brownie.jpg']
      ];
      foreach ($itens as $item): ?>
        <div class="bg-white p-4 rounded-xl shadow">
          <img src="src/<?php echo $item['img']; ?>" class="w-full h-40 object-cover rounded-md mb-4" />
          <h3 class="text-xl font-bold"><?php echo $item['nome']; ?></h3>
          <p class="text-lg">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
          <form action="cardapio.php" method="POST">
            <input type="hidden" name="item" value="<?php echo $item['nome']; ?>">
            <input type="hidden" name="preco" value="<?php echo $item['preco']; ?>">
            <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-1 rounded">Adicionar 🛒</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="max-w-4xl mx-auto px-4">
    <h2 class="text-2xl font-semibold text-center mb-4">Carrinho</h2>
    <table class="w-full bg-white rounded shadow text-center">
      <thead class="bg-[#A1887F] text-white">
        <tr>
          <th class="py-2">Item</th>
          <th>Quantidade</th>
          <th>Preço</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        if (isset($_SESSION['carrinho'])):
          foreach ($_SESSION['carrinho'] as $nome => $dados):
            $subtotal = $dados['quantidade'] * $dados['preco'];
            $total += $subtotal;
        ?>
        <tr class="border-t">
          <td class="py-2"><?php echo $nome; ?></td>
          <td><?php echo $dados['quantidade']; ?></td>
          <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
          <td>
            <a href="cardapio.php?acao=mais&item=<?php echo urlencode($nome); ?>" class="px-2">+</a>
            <a href="cardapio.php?acao=menos&item=<?php echo urlencode($nome); ?>" class="px-2">-</a>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
    <p class="text-right mt-2 font-bold">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
    <div class="text-center mt-4">
      <a href="finalizar.php" class="bg-green-600 text-white px-6 py-2 rounded">Confirmar Pedido</a>
    </div>
  </section>
</body>
</html>
