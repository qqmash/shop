<?php
/**
* Шаблон для вывода списка пользователей
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1>Список пользователей</h1>
<?php if(empty($users)): //!if ($this->cart->contents()): ?>
	<p>Пользователей пока нет</p>
<?php else: ?>

<table id="select-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Email</th>
			<th>Роль</th>
			<th>Последний раз заходил</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php //$i = 1; ?>
		<?php foreach( $users as $item): //$orders as $row_id => $item?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>

			<td><?php echo $item['id']; ?></td>
			<?php //echo $item['product_id']; ?>
			<td><?php echo $item['first_name']; ?></td>
			<td><?php echo $item['last_name']; ?></td>
			<td><?php echo $item['email']; ?></td>
			<td><?php echo $item['role_name']; ?></td>
			<td><?php echo $item['last_login']; ?></td>
			
			<td>
				<?php //echo form_input(array('name'=>'qty[]', 'value'=>$items['qty'], 'maxlength'=>'3', 'size'=>'5')); ?>
				<?php //echo form_open('cart/delete_item/' . $item['id']); ?>
				<input type="submit" value="Редактировать">
			</td>
			<td>
				<input type="submit" value="Удалить">
				<input type="hidden" name="rowid" value="<?php //echo $row_id; ?>">
				<?php echo form_close(); ?>
			</td>
			
		</tr>
		
		<?php //$i++; ?>
		<?php endforeach; ?>
		
	</tbody>
</table>

<?php endif; ?>



</div>