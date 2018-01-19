<?php
/**
* Шаблон для вывода списка продаж
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1><?php echo $title; ?></h1>
<?php if(empty($orders)): //!if ($this->cart->contents()): ?>
	<p>Пока нет продаж</p>
<?php else: ?>

<div style="overflow-x:auto;">
<table id="select-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Заказчик</th>
			<th>Наименование</th>
			<th>Цена</th>
			<th>Кол-во</th>
			<th>Скидка</th>
			<th>Сумма</th>
			<th>Дата</th>
		</tr>
	</thead>
	<tbody>
		<?php //$i = 1; ?>
		<?php foreach( $orders as $item): //$orders as $row_id => $item?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>

			<td><?php echo $item['order_id']; ?></td>
			<?php //echo $item['product_id']; ?>
			<td><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['unit_price']); ?></td>
			<td><?php echo $item['quantity']; ?></td>
			<td><?php echo $item['discount']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['subtotal']); ?></td>
			<td><?php echo $item['order_date']; ?></td>	
		</tr>
		
		<?php //$i++; ?>
		<?php endforeach; ?>
		
	</tbody>
</table>
</div>
<?php endif; ?>



</div>