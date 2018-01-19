<?php
/**
* Шаблон для вывода сообщений и формы обратной связи
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1><?php echo $title; ?></h1>

<?php foreach ($posts as $item): ?>

	<h1><?php echo $item['first_name'] . ' ' . $item['last_name'] . ': "' . $item['title'] . '"' ?></h1>
	<div class="main">
		<?php echo  $item['datetime'] . '<br>' . $item['text']; ?>
	</div>
	
<?php endforeach; ?>
</div>

<div class="col-lg-8 col-lg-offset-2">
<h1>Оставить сообщение</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('feedback/create'); ?>
	<div class="form-group">
		<label for="title">Тема</label><br>
		<input type="input" name="title" size = "50" class="form-control"><br>
	</div>
	<div class="form-group">
		<label for="text">Сообщение</label><br>
		<textarea name="text" cols="100" rows = "20" class="form-control"></textarea><br>
	</div>
	
	<input type="submit" name="submit" value="Добавить" class="btn btn-lg btn-primary btn-block">
	
</form>
</div>