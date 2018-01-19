<?php
/**
* Шаблон для вывода списка проданных товаров, прибыль
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1><?php echo $title; ?></h1>
<?php if(empty($orders)): //!if ($this->cart->contents()): ?>
	<p>Пока нет проданных товаров</p>
<?php else: ?>

<div style="overflow-x:auto;">
<table id="select-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Наименование</th>
			<th>Прибыль с единицы</th>
			<th>Кол-во</th>
			<th>Прибыль</th>
		</tr>
	</thead>
	<tbody>
		<?php //$i = 1; ?>
		<?php foreach( $orders as $item): //$orders as $row_id => $item?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>

			<td><?php echo $item['product_id']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['unit_profit']); ?></td>
			<td><?php echo $item['quantity']; ?></td>
			<td>$<?php echo $this->cart->format_number($item['profit']); ?></td>
			
		</tr>
		
		<?php //$i++; ?>
		<?php endforeach; ?>
		
	</tbody>
</table>
</div>
<?php endif; ?>



</div>