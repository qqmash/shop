<?php
/**
* Шаблон для вывода списка новостей
*/
?>

<div class="hot-cats white-rad-box  mb-10">

<h1><?php echo $title; ?></h1>

<?php foreach ($news as $news_item): ?>

	<h1><?php echo $news_item['title']; ?></h1>
	<div class="main">
		<?php echo $news_item['text']; ?>
	</div>
	<p><a href="<?php echo site_url('news/'.$news_item['slug']); ?>">Подробнее</a></p>
	
<?php endforeach; ?>

</div>