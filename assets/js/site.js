/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);
/* Manage Action */
function is_numeric(value){
    var reg = /^\d+$/ig;
    return reg.test(value);
}
function getDay()
{
	var now=new Date();
	day=now.getDay();
	iday=NDays[day];
	return iday;
}
function count( mixed_var, mode ) {	// Count elements in an array, or properties in an object
	
	var key, cnt = 0;

	if( mode == 'COUNT_RECURSIVE' ) mode = 1;
	if( mode != 1 ) mode = 0;

	for (key in mixed_var){
		cnt++;
		if( mode==1 && mixed_var[key] && (mixed_var[key].constructor === Array || mixed_var[key].constructor === Object) ){
			cnt += count(mixed_var[key], 1);
		}
	}

	return cnt;
}

function close_p()
{
	$('#opaco').addClass('hidden');$('#popup').toggleClass('hidden');
}
$(document).ready(function(){

    $('.form-serials').submit(function(){
        var f = true;
        $(this).find('.serkey').each(function(a, b){
            if ($(this).val() == ''){
                f = false;
                alert("Серийные номер товара еще не записан");
                return f;
            }
        });
        return f;
    });
	
	
	
    $('.product-title').live('click',function(){
        var param = $(this).attr('href').split('/');
        var id = param[param.length - 1];
        var retail = parseFloat($("#retail_"+id).text());
        var cat = $(this).attr('cat');
        var catVal = parseFloat($("#cat"+cat).val());
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function(href){
                if (href == 'overflow'){
                    alert("Такого товара в магизен больше нет");
                }else{
                    $('#bin').html(href);
                    $("#cat"+cat).val(catVal+retail);
                }
            }
        });
        return false;
    });

    $('#form-total').live('submit', function(){
        var obj = $(this);
        var type = $(this).attr('type');
        var id = $('#prid').val();
        $.post(obj.attr('action'), obj.serialize(),
            function(res){
                if (res == '1'){
                    alert("Товар добавлен");
                    $('#ex_product_'+id).removeClass('noexist-product').addClass('exist-product');
                    closePopup();
                }
            }).error(function() { alert("error"); });
        return false;
    });

    $('#checkproduct').live('submit', function(){
        var obj = $(this);
        var intRegex = /^\d+$/;
        if (!intRegex.test(obj[0]['prid']['value'])){
            alert('Введите число больше нуля');
            return false;
        }
        $.post(obj.attr('action'), obj.serialize(),
            function(html){
                $('#popup').empty().html(html);
            }).error(function() { alert("error"); });
        return false;
    });
	
	
    // AddBin
    $('#remove').live('click',function(){
        var param = $(this).attr('href').split('/');
        var prId = param[param.length - 1];
        var cat = $("#prod_"+prId).attr('cat');
        $.ajax({
            url: $(this).attr('href'),
            success: function(href){
                $('#bin').html(href);
                $("#cat"+cat).val($('#bin-total').text());
            }
        });
        return false;
    });
	
	// OrderCall
    $('#order_call').live('click',function(){
        var prId = $("#product_id").attr("value");
		if ($("#call_number").attr("value")=='')
		{
			$("#call_number").css("border","1px solid #FF6633");
			alert("Напишите Ваш телефон");
			return false;
		}
		if (!is_numeric($("#call_number").attr("value")))
		{
			$("#call_number").css("border","1px solid #FF6633");
			alert("Введите корректный Ваш телефон");
			return false;
		}
		$.ajax({
            url: "/index/order-call",
			data:"prid=" + prId + "&number=" + $("#call_number").attr("value"),
            success: function(href){
				NDays=new Array ("воскресенье","понедельник","вторник","среда","четверг","пятница","суббота");
				var now=new Date();
				var hour=now.getHours();
				if (getDay()=="воскресенье")
				{
					msg = "Извините, но сегодня у нас выходной. С вами свяжется менеджер в понедельник.";
				}
				else if ((getDay()=="суббота" && hour>15) || (hour>18))
				{
					$("#error_message").html("Ваш заказ будет готов в понедельник до 13 00.");
				}
				else
				{
					msg = "Заказ на звонок принят, менеджер оповещен и в скором времени свяжется с Вами.";
				}
				
                $('#opaco').removeClass('hidden');
                $('#popup')
                        .html(msg)
                        .alignCenter()
                        .toggleClass('hidden');
				 setTimeout("close_p()",3000);
            }
        });
    });

    $('#form-order').live('submit', function(){
        var $inputs = $('#form-order :input');
        var f = true;

        var values = {};
        $inputs.each(function() {
            if ((this.name == 'fl_name' || this.name == 'phone') && $(this).val() == ''){
                alert("ФИО или телефон не должно быть пустым");
                f =  false;
                return false;
            }
        });
        if (f)
            return true;
        else return false;
    });

    // Clear Bin
    $('#clear-bin').live('click', function(){
        var $inputs = $('.left_content :input');
        $.ajax({
            url: $(this).attr('href'),
            success: function(href){
                $('#bin').html(href);
                $inputs.each(function() {
                    $(this).val(0);
                });
            }
        });
        return false;
    });

    //hide or show dealer price
    $('#hide-dealer').click(function(){
        $('.dealer-row').toggle();
        $('#dealer-total').toggle();
    });

    $('#sold-leader').click(function(){
        $('.leader-row').toggle();
    });

    $('#span-product, #span-site').click(function(){
        if ($('#product').attr('checked') == 'checked'){
            $('#site').attr('checked', 'checked');
            $('#product').attr('checked', false);
            $('#span-product').removeClass('span-active');
            $('#span-site').addClass('span-active');
        }
        else{
            $('#site').attr('checked', false);
            $('#product').attr('checked', 'checked');
            $('#span-site').removeClass('span-active');
            $('#span-product').addClass('span-active');
        }
    });

    $('.thumb_img').click(function(){
        if($('.main_img').length > 1){
            $('.main_img').css('display', 'none');
            $('#m_'+$(this).attr('id')).css('display', 'block');
            $('.thumb_img').removeClass('active');
            $(this).addClass('active');
        }
    });

    /* Услуги */
    $('#add-service > dl > #serkey-element').css('display', 'none');
    $('#add-service > dl > #serkey-label').css('display', 'none');
    $('#add-service > dl > #printnak-label').css('display', 'none');
    $('#add-service > dl > #printnak-element').css('display', 'none');
    $('#add-service > dl > dd > #type').live('change', function(){
        if ($(this).val() == 'Компьютеры'){
            $('#add-service > dl > #serkey-label').css('display', 'block');
            $('#add-service > dl > #serkey-element').css('display', 'block');
            $('#add-service > dl > #printnak-label').css('display', 'block');
            $('#add-service > dl > #printnak-element').css('display', 'block');
        }else{
            $('#add-service > dl > #serkey-element').css('display', 'none');
            $('#add-service > dl > #serkey-label').css('display', 'none');
            $('#add-service > dl > #printnak-label').css('display', 'none');
            $('#add-service > dl > #printnak-element').css('display', 'none');
        }
    });

    $('#add-service > dl > dd > #printnak').live('click', function(){
        if ($('#add-service > dl > dd > #type').val() == 'Компьютеры' && $('#add-service > dl > dd > #serkey').val() != ''){
            var $inputs = $('#add-service :input');
            var f = true, e;
            $inputs.each(function() {
                if (this.name != 'add' && this.name != 'printnak' && $(this).val() == ''){
                    f = false;
                    e = $(this).attr('n');
                }
            });
            if (f){
                window.open($(this).attr('href')+'?'+$('#add-service').serialize(), '_blank');
            }else{
                alert('Поле ' + e + ' не заполнено.');
            }
        }else{
            alert('Все поля обязательны для заполнения');
        }
        return false;
    });

    /*  -ARTICLE */
    $('#article #photo').after($('#main-photo'));

    $('#article #del-main-photo').live('click', function(){
        $.ajax({
            url: $(this).attr('href'),
            success: function(href){
                $('#main-photo').remove();
            }
        });
        return false;
    });

    $('#article-rss').submit(function(){
        var mail = $('#email').val();
        if(IsEmail(mail)){
            $.post($(this).attr('action'), $(this).serialize(),
                function(res){
                    alert(res);
                }).error(function() { alert("error"); });
        }
        else
            alert('Не верный email');
        return false;
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    /* -------------- */

    $('.close-call').click(function(){
        var obj = $(this);
        $.ajax({
            url: obj.attr('href'),
            success: function(data){
                if (data['error'] == 0 && data['t'] != ''){
                    $('#'+data['t']+'_'+obj.attr('id')).remove();
                }
            }
        }).fail(function(){alert('error');});
        return false;
    });
	
	$('.close-balans').click(function(){
        var obj = $(this);
        $.ajax({
            url: obj.attr('href'),
            success: function(data){
               
                    $('#balans_tr_'+obj.attr('id')).remove();
                
            }
        }).fail(function(){alert('error');});
        return false;
    });

});
var visible_part;
var cat_array = [];
var checked_item;
var exchange_rate;
function part_click(cat_id,cat_title)
{
	if (visible_part)
	{
		$("#part_" + visible_part).css("border","1px solid #b8bec2");
	}
	$("#part_" + cat_id).css("border","1px solid #FF9107");
	visible_part = cat_id;
	
	$("#part_block").html("<img src='/public/images/ajax-loader.gif' class='mt-10' alt='Loading' title='Loading'/>");
	$.ajax({
		type: "POST",
		url: "/index/click-part",
		data:"cat_id=" + cat_id,
		success: function(data){
			width_prod_cont = count(data) * 300;
			var html_div = "";
			html_div = "<h3 class='mt-10 mb-15'>" + cat_title + ":</h3>";
			html_div+="<div class='all_prods' id='scroll_block'><div  style='padding-bottom:10px;width:" + width_prod_cont + "px'>";
			jQuery.each(data,function() {
				if (this["title"])
				{
					html_div+="<div class='prod_cont'";
					if (this["checked"])
					{
						html_div+="style='background:#eee;border:1px solid rgb(255, 145, 7);'";
						checked_item = this["product_id"];
					}
					html_div+="id='prod_cont_" + this["product_id"] + "'><a href='/product/" + this["product_id"] + "/" + this["title"] + "' target='_blank'>" + this["title"] +"</a><img style='display:block;max-width: 200px;max-height:100px;margin: auto;margin-top: 10px;' src='/public" + this["image_path"] + "' alt='" + this["title"] + "' class='mt-10' title='" + this["title"] + "'/><div class='mt-10'>" + this["display_price"] +"</div><div class='mt-10 mb-10'><img src='/public/images/check.png' id='prod_check_" + this["product_id"] + "' onclick='product_click(" + this["product_id"] + "," + this["cat_id"] + ")' style='cursor:pointer;'/></div></div>";
				}
			});
			html_div+="<div class='clr'></div></div></div>";
			$("#part_block").html(html_div);
			jQuery("#scroll_block").scrollTo('#prod_cont_' + checked_item, 1000, {axis:'x'});
		}
	});
}
function product_click(pr_id,cat_id)
{
	if (cat_array[cat_id])
	{
		$("#prod_cont_" + cat_array[cat_id]).css("background","#FFF");
		$("#prod_cont_" + cat_array[cat_id]).css("border","1px solid #fff");
		$("#prod_check_" + cat_array[cat_id]).attr("src","/public/images/check.png");
	}
	cat_array[cat_id] = pr_id;
	$("#prod_cont_" + pr_id).css("border","1px solid rgb(255, 145, 7)");
	$("#prod_cont_" + pr_id).css("background","#eee");
	$("#prod_check_" + pr_id).attr("src","/public/images/check_active.png");
	$("#sb_block").html("<img src='/public/images/ajax-loader.gif' class='mt-10' alt='Loading' title='Loading'/>");
	$.ajax({
		type: "POST",
		url: "/index/click-product",
		data:"cat_id=" + cat_id + "&pr_id=" + pr_id,
		success: function(data){
			$("#active_" + cat_id).css("display","block");
			update_sb();
		}
	});
}

function delete_pr(pr_id,cat_id)
{
	$.ajax({
		type: "POST",
		url: "/index/delete-product",
		data:"pr_id=" + pr_id + "&cat_id=" + cat_id ,
		success: function(data){
			if (cat_array[cat_id])
			{
				$("#prod_cont_" + cat_array[cat_id]).css("background","#FFF");
				$("#prod_cont_" + cat_array[cat_id]).css("border","1px solid #fff");
				$("#prod_check_" + cat_array[cat_id]).attr("src","/public/images/check.png");
				$("#active_" + cat_id).css("display","none");
				cat_array[cat_id] = [];
			}
			update_sb(1);
		}
	});
}

function update_sb(first)
{
	var all_price = 0;
	$.ajax({
		type: "POST",
		url: "/index/update-sb",
		data: "first=" + first,
		success: function(data){
			if (data[0])
			{
				html_div = "<table cellpadding='7' cellspacing='7'><tbody><tr><td style='padding-bottom:10px;'><b>Категория</b></td><td style='padding-bottom:10px;'><b>Название</b></td><td style='padding-bottom:10px;'><b>Цена</b></td><td style='padding-bottom:10px;'></tr></tr>";
				jQuery.each(data,function() {
					if (first)
					{
						$("#active_" + this["cat_id"]).css("display","block");
						cat_array[this["cat_id"]] = this["product_id"];
					}
					html_div+="<tr><td valign='top'>" + this.cat_title + "</td><td style='padding-bottom:10px;' valign='top'>" + this.title + "</td><td valign='top' align='center'>" + this.display_price + "</td><td valign='top'><span style='padding-left:10px;cursor:pointer;color:#EA6903;font-size:14px;' onclick='delete_pr(" + this.product_id +"," + this.cat_id + ")'>X</span> </td></tr>";
					all_price+=this["coast"];
					exchange_rate = this["exchange_rate"];
				});
					html_div+="<tr><td colspan='4' align='right'><b>Итого: " + all_price + "$ (" + all_price*exchange_rate + "сом)</b></td></tr>";
					html_div+="<tr><td colspan='4' align='right' style='padding-top:10px;'><a href='javascript://' onclick='sb_add_bin()' class='big-button'>Заказать</a><a href='/print_sb' class='big-button' target='_blank' style='margin-right:10px;'>Версия для печати</a><td></tr>";
				html_div+="</table>";
			}
			else
			{
				html_div = "Добавьте что нибудь...";
			}
			$("#sb_block").html(html_div);
		}
	});
}

function sb_add_bin()
{
	$.ajax({
		type: "POST",
		url: "/bin/ajax/sb",
		success: function(data){
			window.location.href="/bin/index/order";
		}
	});
}
