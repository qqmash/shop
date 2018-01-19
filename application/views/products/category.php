<?php
/**
* Шаблон для вывода списка категорий
*/
?>

<div class="hot-cats white-rad-box  mb-10">

<?php
    //var_dump($category);
    foreach ($category as $item):
?>
    <a style="display: block" href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a>
<?php endforeach; ?>

</div>