<?php
/**
* Шаблон для вывода списка заказов
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1><?php echo $title; ?></h1>
<?php if(empty($orders)): //!if ($this->cart->contents()): ?>
	<p>Пока нет активных заказов</p>
<?php else: ?>

<div style="overflow-x:auto;">
<table id="select-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Заказчик</th>
			<th>Телефон</th>
			<th>Адрес</th>
			<th>Наименование</th>
			<th>Цена</th>
			<th>Кол-во</th>
			<th>Скидка</th>
			<th>Сумма</th>
			<th>Дата</th>
			<th>Статус</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php //$i = 1; ?>
		<?php foreach( $orders as $item): //$orders as $row_id => $item?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>

			<td><?php echo $item['order_id']; ?></td>
			<?php //echo $item['product_id']; ?>
			<td><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></td>
			<td><?php echo $item['phone_number']; ?></td>
			<td><?php echo $item['address']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['unit_price']); ?></td>
			<td><?php echo $item['quantity']; ?></td>
			<td><?php echo $item['discount']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['subtotal']); ?></td>
			<td><?php echo $item['order_date']; ?></td>
			<td><?php echo $item['order_status']; ?></td>
			
			<td>
				<?php //echo form_input(array('name'=>'qty[]', 'value'=>$items['qty'], 'maxlength'=>'3', 'size'=>'5')); ?>
				<?php if ($item['order_status']=='not_sent'): ?>
					<?php echo form_open('cart/complete_order/' . $item['order_id']); ?>
					<input type="submit" value="Оформить">
					<input type="hidden" name="rowid" value="<?php //echo $row_id; ?>">
					<?php echo form_close(); ?>
				<?php endif; ?>
			</td>
			
		</tr>
		
		<?php //$i++; ?>
		<?php endforeach; ?>
		
	</tbody>
</table>
</div>
<?php endif; ?>



</div>