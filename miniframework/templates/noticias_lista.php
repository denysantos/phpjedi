<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFrameWork</title>
</head>
<body>
    <h1>Notícias</h1>

    <!--Teste-->
    <!--<pre><?php print_r($data['news']); ?></pre>-->

    <?php foreach($data['news'] as $new): ?>
    <ul>
        <a href="./noticias/<?php echo $new['id']; ?>"><li><?php echo $new['titulo']; ?></li></a>
    </ul>
    <?php endforeach; ?>


    <form method="POST">
        <input type="text" name="nome">
        <input type="submit" value="Enviar">
    </form>
    
</body>
</html>


