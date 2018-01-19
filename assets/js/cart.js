/**
* Выводит сообщение пользователю
* @param text
* @param status
*/
;(function($) {

function setMessage(text, status)
{
	//создаем HTML сообщения, помещаем его в выборку jQuery и сразу скрываем, чтобы потом применить к нему
		
	//эффект появления
	var $messaheHTML = $('<div class="message-' + resp.status + '">' + resp.message + '</div>').hide();
		
	//Добавляем сообщение внутрь блока .content и плавно его показываем
	$messageHTML.prependTo('.content').fadeIn();
		
	//Через 2 секунды удалим сообщение
	setTimeout(function() {
		$messageHTML.slideUp(function() {
			$(this).remove();
		});
	}, 2000);
		
}


//Форма с кнопкой "Купить"
$('.products-list').on('submit', 'form', function(e) {

	var $form = $(this); //текущая форма добавления в корзину
	var formData = $form.serialize(); //данные формы в строку
	
	//POST запрос на сервер
	$.post($form.attr('action'), formData, function(resp) {
	
		//Заменяем HTML корзины на новый
		//$.('cart').replaceWith(resp.cart_html);
		
		//Выводим сообщение на 2 сек и скрываем его
		setMessage(resp.message, resp.status);
		
	});
	
	//Отменяем действие по умолчанию
	e.preventDefault();

});
		
		
})(jQuery);