<?php

// формирование главной страницы при посещении сайта без авторизации

$Visitor= ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '': checkVisitor($_SESSION['user_priv']);

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Content}/','/{Foot}/']; //определяем массив для замены маркеров в шаблоне
$replaceWhere = file_get_contents($templates[0]); //  в качестве параметра для функции берем файл-шаблон из массива с индексом 0, массив определен в библиотеке tpllib.php

$titlePage = "Объявления";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl," selected","#","","/?page=1","","/?page=3","","/?page=4") : sprintf($navTpl," selected","#","","/?page=1","","/?page=3","","/?page=5");

     
$Footer = sprintf($footTpl,$_SESSION['user_name'], $Visitor );

$content = '
<h1 style="text-align: center;">Последние новости и события</h1><br><hr>
<p><b>12-07-2020</b>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur modi, odio magnam fugiat aliquid laudantium, exercitationem cum nam animi voluptatum culpa? Quam minima, rerum magni!
<ul style="margin-left: 50px;">
    <li>fuga quam, nesciunt delectus</li>
    <li>cum nam animi voluptatum culpa?</li>
    <li>Quam minima, rerum magni!</li>
</ul>
<i>Автор:</i> <span style="font-size:12px;">Имя</span>
</p><hr>
<p><b>11-07-2020</b>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam tenetur accusantium distinctio repellendus quibusdam aut consectetur, aliquam, fuga quam, nesciunt delectus ea qui aperiam vero sapiente cupiditate, eius inventore. Inventore expedita, possimus voluptates. Quas quasi dolorem, soluta mollitia perspiciatis veritatis sunt provident facere.
<ul style="margin-left: 50px;">

</ul>
<br><i>Автор:</i> <span style="font-size:12px;">Имя</span>
</p><hr>
<p><b>11-07-2020</b>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam tenetur accusantium distinctio repellendus quibusdam aut consectetur, aliquam, fuga quam, nesciunt delectus ea qui aperiam vero sapiente cupiditate, eius inventore. Inventore expedita, possimus voluptates. Quas quasi dolorem, soluta mollitia perspiciatis veritatis sunt provident facere.
<ul style="margin-left: 50px;">
    <li>fuga quam, nesciunt delectus</li>
    <li>Quam minima, rerum magni!</li>
</ul>
<i>Автор:</i>  <span style="font-size:12px;">Имя</span>
</p>
';


$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$content,$Footer];

// заполнение шаблона страницы и отправка клиенту
echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>
