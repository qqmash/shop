<?php
/**
* Шаблон вывода сетки товаров
*/
?>

<?php //$this->load->view('cart/cart'); ?>

<div class="hot-cats white-rad-box  mb-10">

<?php //if($category_name): ?>
	<?php //echo $category_name['name']; ?>
<?php //endif; ?>


<?php //if($category_name): ?>
	<?php //echo $category_name; ?>
<?php //endif; ?>

<?php if(empty($products)): //!if ($this->cart->contents()): ?>
	<p>Пока нет товаров в данной категории</p>
<?php else: ?>

<table class="products-list">
	<tbody>
	<tr>
	<?php $i=0; ?>
	<?php foreach ($products as $item)://($data['products'] as $item):// ?>
	
		<td height="160" width="160">
			<img src="<?= base_url(); ?>assets/img/products/<?= $item['image']; ?>" alt="" height="160">
			<header class="product-title"><?= $item['name']; ?><header>
			<p class="price">$<?= $item['price']; ?> / <?= $item['price']*70; ?> сом</p>
			<?php echo form_open('cart/add_to_cart'); ?>
			<input type="hidden" name="product_id" value="<?= $item['id']; ?>">
			<input type="submit" name="add-to-cart" value="Купить">
			<?php echo form_close(); ?>
		</td>
	<?php $i++; ?>
	<?php if($i>3): $i=0; ?> </tr><tr> <?php endif; ?>
	
	<?php endforeach; ?>
	</tr>
	</tbody>
</table>

<?php endif; ?>

</div>