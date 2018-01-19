<?php
/**
* Шаблон для вывода корзины покупок
*/
?>

<div class="cart">
<h1>Ваша корзина</h1>
<?php if(empty($cart_items)): //!if ($this->cart->contents()): ?>
	<p>В корзине пока нет товаров</p>
<?php else: ?>

<?php
	//Если сумма заказа больше 50 долларов, скидка 5%
	$discount = 0;
	if($this->cart->total()>50)
	{
		$discount = 0.05;
	}
?>

<table class="cart-items">
	<thead>
		<tr>
			<th></th>
			<th>Наименование</th>
			<th>Цена</th>
			<th>Количество</th>
			<th>Сумма</th>
		</tr>
	</thead>
	<tbody>
		<?php //$i = 1; ?>
		<?php foreach( $cart_items as $row_id => $item): //$this->cart->contents()?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>
			<td>
				<?php //echo form_input(array('name'=>'qty[]', 'value'=>$items['qty'], 'maxlength'=>'3', 'size'=>'5')); ?>
				<?php echo form_open('cart/delete_item/' . $item['id']); ?>
				<input type="submit" value="Удалить">
				<input type="hidden" name="rowid" value="<?php echo $row_id; ?>">
				<?php echo form_close(); ?>
			</td>

			<td><?php echo $item['name']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['price']); ?></td>
			<td><?php echo $item['qty']; ?></td>
			<td>$<?php
				$subtotal=$item['subtotal'];
				//Если есть скидка, выводим конечную сумму
				if($discount>0) 
				{
					$subtotal=$subtotal*(1-$discount);
				}
					
				echo $this->cart->format_number($subtotal);
				//echo $subtotal;
				?></td>
			
		</tr>
		
		<?php //$i++; ?>
		<?php endforeach; ?>
		
		<tr>
			<td></td>
			<td></td>

			<td colspan="2"><strong>Общая сумма:</strong></td>
			<td>$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
		</tr>
		
		<?php if($discount>0): //Если есть скидка, выводим конечную сумму ?>
		<tr>
			<td></td>
			<td></td>

			<td colspan="2"><strong>C учетом скидки 5%:</strong></td>
			<td>$<?php echo $this->cart->format_number($this->cart->total()*(1-$discount)); ?></td>
		</tr>
		<?php endif; ?>
		
		<tr>
			<td>
			<div class="controls">
				<?php print form_open('cart/cart_empty'); ?>
				<input type="submit" value="Очистить корзину">
				<?php print form_close(); ?>

			</div>
			</td>
			<td></td>
			<td></td>

			<td>
			<div class="controls">
				<?php print form_open('cart/add_order'); ?>
				<input type="submit" value="Оформить заказ">
				<?php print form_close(); ?>
			</div>
			</td>
		</tr>
		
	</tbody>
</table>

<?php endif; ?>



</div>