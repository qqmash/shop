<?php
/**
* Форма для оформления заказа
*/
?>

<div class="col-lg-8 col-lg-offset-2">
<h1><?php //echo $title; ?>Оформление заказа</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('cart/add_order'); ?>
	<div class="form-group">
		<label for="first_name">Имя</label><br>
		<input type="input" name="first_name" size = "50" class="form-control"><br>
	</div>

	<div class="form-group">
		<label for="last_name">Фамилия</label><br>
		<input type="input" name="last_name" size = "50" class="form-control"><br>
	</div>
	
	<div class="form-group">
		<label for="phone_number">Номер телефона</label><br>
		<input type="input" name="phone_number" size = "50" class="form-control"><br>
	</div>
	<div class="form-group">
		<label for="address">Адрес доставки</label><br>
		<input type="input" name="address" size = "50" class="form-control"><br>
	</div>

	<input type="submit" name="submit" value="Оформить заказ" class="btn btn-lg btn-primary btn-block">
	
</form>
</div>


