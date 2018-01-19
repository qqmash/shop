$(document).ready(function()
{
	var link = "/index.php/";
	//Урл моего приложения (включая индекс.пхп)
	
	$("ul.products form").submit(function()
	{
		// Получаем ид товара и количество
		var id = $(this).find('input[name=product_id]').val();
		var qty = $(this).find('input[name=quantity]').val();
			
		//alert('ID:' + id + '\n\rQTY:' + qty);
		//alert('ИДИТЕ ВСЕ НАХУЙ Я НЕ РАБОТАЮ');

		$.post(link + "cart/add_cart_item", { product_id: id, quantity: qty, ajax: '1' },
  				function(data)
				{	
 		 			// Interact with returned data
					if(data == 'true')
					{
						$.get(link + "cart/show_cart", function(cart) //Получаем контент урла шоу_карт
						{
							
							$("#cart_content").html(cart); //Заменяем инфу в диве карт_контент полученной
							
						});
					}
					
					else
					{
						alert("Товар не существует");
					}
				});		
		
		
		return false;
		// Stop the browser of loading the page defined in the form "action" parameter.
	
	});
	
	
});