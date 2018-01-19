<?php
/**
* Шаблон меню категорий товаров
*/
?>

		<ul class="menu" style="margin-top:13px;">

		<?php //МЕНЮ 1 - НОУТЫ-ПЛАНШЕТЫ ?>
	
			<li>
                <div class="menu-link-left"></div>
                <div class="menu-link">
                    <a href="javasscript://void(0)">Ноутбуки/Планшеты</a>
                </div>
                <div class="menu-link-right"></div>
                <div class="dropdown-content" style="width:333px;">
					<table class="sub_menu_table">
						<tbody><tr>
							<td width="150" valign="top">
								<?php foreach ($nouts as $item): ?>
								<div class="mb-5"><a href="<?=base_url();?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							
							<td valign="top">
								<div class="mb-5">Ищем поставщика. <a href="<?=base_url();?>index.php/about">Контакты</a></div>
							</td>
								
							<?php /*	
							//<div class="sub"> <a href="">Apple</a></div> ?>
							*/?>
						</tr>
					</tbody>
					</table>
                </div>
            </li>
			
			<?php //МЕНЮ 2 - КОМПЫ ?>

            <li class="menu-second">
                <div class="menu-link-left"></div>
                <div class="menu-link">
                    <a href="javasscript://void(0)">Компьютерная/офисная техника</a>
                </div>
                <div class="menu-link-right"></div>
                <div class="dropdown-content" style="width:786px;">
					<table class="sub_menu_table">
						<tbody><tr>
							<td valign="top" style="padding-right:20px;">
								<div class="sub_title">Компьютерные комплектующие</div>
								<?php foreach ($complect as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							<td valign="top" style="padding-right:20px;">
								<div class="sub_title">Компьютерная техника</div>
								<?php foreach ($tech as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							<td valign="top" style="padding-right:20px;">
								<div class="sub_title">Аудио техника</div>
								<?php foreach ($audio as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							<td valign="top" style="padding-right:20px;">
								<div class="sub_title">Офисная техника</div>
								<?php foreach ($office as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							<td valign="top">
								<div class="sub_title">Сетевое оборудование</div>
								<?php foreach ($net as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
						</tr>
					</tbody></table>
                </div>
            </li>
	
			<?php //МЕНЮ 3 - СМАРТФОНЫ ?>
			
			<li class="menu-second">
                <div class="menu-link-left"></div>
                <div class="menu-link">
                    <a href="javasscript://void(0)">Смартфоны</a>
                </div>
                <div class="menu-link-right"></div>
				<div class="dropdown-content" style="width:192px;">
					<table class="sub_menu_table">
						<tbody><tr>
							<td valign="top" style="padding-right:20px;">
							<?php foreach ($phones as $item): ?>
									<div class="mb-5"><a href="<?= base_url(); ?>index.php/cart/catalog/<?= $item['id'] ?>"><?= $item['name'] ?></a><sup class="sub"></sup></div>
								<?php endforeach; ?>
							</td>
							<td valign="top">
								<div class="mb-5"> Ищем поставщика. <a href="<?=base_url();?>index.php/about">Контакты</a> </div>
							</td>
						</tr>
					</tbody></table>
                </div>
            </li>

        </ul>