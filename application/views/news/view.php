<?php
/**
* Шаблон для вывода новости
*/
?>

<div class="hot-cats white-rad-box  mb-10">
	<?php
	echo '<h1>'.$news_item['title'].'</h1>';
	echo $news_item['text'];
	?>
</div>