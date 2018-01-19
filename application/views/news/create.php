<?php
/**
* Шаблон для формы создания новости
*/
?>

<div class="hot-cats white-rad-box  mb-10">
	<h1><?=$title;?></h1>
	<a href="<?=$link;?>"><?=$text;?></a>
</div><div class="col-lg-8 col-lg-offset-2">
<h1><?php echo $title; ?></h1>

<?php echo validation_errors(); ?>

<?php echo form_open('news/create'); ?>
	<div class="form-group">
		<label for="title">Заголовок</label><br>
		<input type="input" name="title" size = "50" class="form-control"><br>
	</div>
	<div class="form-group">
		<label for="text">Текст новости</label><br>
		<textarea name="text" cols="100" rows = "20" class="form-control"></textarea><br>
	</div>
	
	<input type="submit" name="submit" value="Добавить" class="btn btn-lg btn-primary btn-block">
	
</form>
</div>


