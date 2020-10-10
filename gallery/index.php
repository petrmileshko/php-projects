<?php
  include_once 'models/config.php';
  include_once 'models/photo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Работа с файлами</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>ГАЛЕРЕЯ ФОТО</h1>
  </header>


  <div class="images">
    <?php for ($i=0; $i < count($images); $i++) : ?>
      <a href="image.php?photo=<?=$images[$i] ?>">
        <img src="<?=PHOTO_SMALL.$images[$i] ?>">
      </a>
    <?php endfor; ?>
  </div>

  <div class="add_foto">
    <form action="" method="POST" enctype="multipart/form-data">
      <span> <b>Добавить файл: </b> </span>
      <input type="file" name="userfile"> 
      <button type="submit" name="send">ЗАГРУЗИТЬ</button> <br>
      <span><?=$message?></span>
    </form>
  </div>    
  
</body>
</html>
