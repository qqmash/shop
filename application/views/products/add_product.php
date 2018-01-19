<?php
/**
* Шаблон для формы добавления товара
*/
?>

<div class="col-lg-8 col-lg-offset-2">
<h1><?php echo $title; ?></h1>

<?php echo validation_errors(); ?>

<?php echo form_open('cart/add_product'); ?>
	<div class="form-group">
		<label for="name">Наименование товара</label><br>
		<input type="input" name="name" size = "50" class="form-control"><br>
	</div>

	<div class="form-group">
		<label for="category">Категория</label><br>
		<select class="form-control" name="category" size="1">
			<?php foreach ($category as $item): ?>
			<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="prime_cost">Себестоимость</label><br>
		<input type="input" name="prime_cost" size = "50" class="form-control"><br>
	</div>
	<div class="form-group">
		<label for="price">Цена</label><br>
		<input type="input" name="price" size = "50" class="form-control"><br>
	</div>
	<div class="form-group">
		<label for="description">Описание товара (не обязательно)</label><br>
		<textarea name="description" cols="100" rows = "20" class="form-control"></textarea><br>
	</div>
	<div class="form-group">
		<label for="image">Изображение (не обязательно)</label><br>
		<input type="input" name="image" size = "50" class="form-control"><br>
	</div>

	<input type="submit" name="submit" value="Добавить" class="btn btn-lg btn-primary btn-block">
	
</form>
</div>


