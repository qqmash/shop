<?php
/**
* Шаблон правой колонки сайта
*/
?>


</div>

</td>
<?php //width="200px" valign="top" ?>
<td>

<div class="right-content">
	<?php /*
	 <div>
        <a href="/configurator" class="money-button big-button" style="color:#174d91;">
            <div>
                <span>Конфигуратор</span>
                <h3>Компьютеров</h3>
            </div>
            <img src="<?= base_url()?>assets/img/site/configurator.png" width="54">
        </a>
    </div>
	*/ ?>
	<div>
        <a href="<?=base_url()?>assets/price/price.xlsx" class="money-button big-button" style="color:#174d91;">
            <div>
                <span>СКАЧАТЬ</span>
                <h3>прайс</h3>
            </div>
            <img src="<?= base_url()?>assets/img/site/configurator.png" width="54">
        </a>
    </div>
	
    <div>
        <a href="<?=base_url()?>index.php/feedback/index" class="consultant-button big-button" style="color:#174d91;">
            <div>
                <span>ЗАДАЙТЕ</span>
                <h3>вопрос</h3>
            </div>
            <img src="<?= base_url()?>assets/img/site/consultant.png">
        </a>
    </div>
	
    <div class="contact-block">
        <span class="org-header">Менеджеры по продажам:</span>
        <ul class="contact-list">
            <li id="icq">icq: 647309722, 406752106 </li>
			<li id="skype">skype: Mytech</li>
            <li id="email">mail: mytech-kg@mail.ru</li>
        </ul>
        <span class="org-header">Техподдержка:</span>
        <ul class="contact-list">
            <li id="icq">icq: 595780461</li>
            
        </ul>
    </div>
	
	    <div class="articles  white-rad-box">
           <div class="article"><h3>Последняя новость</h3></div><div class="cat-head-tal"></div>

            <div class="articles-content">
                <div class="article-item btm-dotted">
					<div>
						<a class="art-title" href="<?=base_url()?>index.php/news/Khiti-nedeli">Хиты недели!</a>
						 <p id="article-date">20 июня 2016</p>
					</div>
					&nbsp;
					Акция: Хиты недели!
					&nbsp;
					&nbsp;
					Описание и условия акции: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

					Уважаемые, покупатели! Мы проводим еженедельную акцию «Хиты неде...
				</div>
                <a style="float:right;margin-right:4px;" href="<?=base_url()?>index.php/news">Читать все новости</a>
				<div class="clr"></div>
            </div>
        </div>
		
		 <div class="articles  white-rad-box mt-5">
           <div class="article"><h3>Последняя продажа</h3></div><div class="cat-head-tal"></div>
            <div class="articles-content">
				<div style="width:200px;text-align:center;margin-bottom:10px;">
					<div style="margin-bottom:10px;text-align:left;"><a href="<?=base_url()?>index.php/cart/catalog/11">GEFORCE GT630 2GB DDR3 128bit PCI-E DVI HDMI RETAI</a>
					</div>
					<a href="<?=base_url()?>index.php/cart/catalog/11">
					<img src="<?= base_url()?>assets/img/products/14421_68_1354543730.jpg" style="max-width:150px;margin-bottom:5px;max-height:150px;" align="center">
					</a>
					<p style="margin-bottom:8px;">$60 / 4200 сом</p>
					<div align="center">	<a class="buy-button" href="<?=base_url()?>index.php/cart/catalog/11">Купить</a></div>
				</div>
			</div>
        </div>
		
		<?php /*
		<div class="articles  white-rad-box mt-5">
			<div class="article"><h3>Мы на Facebook</h3> </div><div class="cat-head-tal"></div>
			<iframe src="./Shop.kg - Интернет магазин Электроники._files/likebox.htm" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:203px; height:345px;" allowtransparency="true"></iframe>
		
		</div>
		*/ ?>
	
</div>


<?php // ?>
</td> 
</tr>
</table>