<?php
/**
* Шаблон для вывода списка ролей
*/
?>

<div class="hot-cats white-rad-box  mb-10">
<h1>Список ролей</h1>
<?php if(empty($roles)): ?>
	<p>Ролей пока нет</p>
<?php else: ?>

<table id="select-table">
	<thead class="select-table-items">
		<tr class="select-table-items">
			<th>ID</th>
			<th>Роль</th>
			<th>Выводимое имя</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody class="select-table-items">
		<?php foreach( $roles as $item): ?>

		<tr <?php //if($i&1){ echo 'class="alt"'; }?>>

			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['role']; ?></td>
			<td><?php echo $item['role_name']; ?></td>
			
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

		<?php endforeach; ?>
		
	</tbody>
</table>

<?php endif; ?>


<br>
<br>
<div class="col-lg-8 col-lg-offset-2">
<h1><?php //echo $title; ?>Добавить роль</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('user/add_role'); ?>
	<div class="form-group">
		<label for="name">Роль</label><br>
		<input type="input" name="role" size = "50" class="form-control"><br>
	</div>
	
	<div class="form-group">
		<label for="name">Выводимое имя</label><br>
		<input type="input" name="role_name" size = "50" class="form-control"><br>
	</div>
	
	<input type="submit" name="submit" value="Добавить" class="btn btn-lg btn-primary btn-block">
	
</form>

</div>