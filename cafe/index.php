<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['cliente'] = $_POST['nome'];
  // Redirecionamento removido, cliente permanece na mesma página
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CatCafe - Bem-vindo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#C8E6C9] text-[#4E342E] min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-xl p-9 max-w-md w-full text-center space-y-4">
    <img src="src/cat.jpeg" alt="Logo CatCafe" class="w-40 h-40 mx-auto rounded-full shadow" />
    <h1 class="text-3xl font-bold">Bem-vindo ao CatCafe!</h1>
    <p>Diga seu nome para prepararmos sua experiência!</p>
    <form method="POST" class="space-y-4">
      <input type="text" name="nome" placeholder="Digite seu nome..." required class="w-full px-4 py-2 border rounded-md" />
      <button type="submit" class="bg-[#A1887F] hover:bg-[#8D6E63] text-white font-semibold px-4 py-2 rounded w-full">Realizar Pedido</button>
    </form>
    <?php if (isset($_SESSION['cliente'])): ?>
      <p class="mt-4">Olá, <?php echo htmlspecialchars($_SESSION['cliente']); ?>! <a href="cardapio.php" class="text-blue-700 underline">Ir para o cardápio</a></p>
    <?php endif; ?>
  </div>
</body>
</html>
