/**
 * Javascrpt code for Bin
 */
function close_p()
{
	$('#opaco').addClass('hidden');
        if(! $('#popup').hasClass('hidden')){
            $('#popup').toggleClass('hidden');
        }
}

$(function(){
    $('.buy-button, .buy').click(function(){
        $.ajax({
            url: $(this).attr('href'),
            success: function(data){
                if (data['error'] == 0 ){
                    $('#opaco').removeClass('hidden');
                    $('#popup')
                        .html(data['msg'])
                        .alignCenter()
                        .toggleClass('hidden');
                    $('#bin-product').empty().html(data['bin']);
					setTimeout("close_p()",3000);
                }else{
                    $('#opaco').removeClass('hidden');
                    $('#popup')
                        .html(data['msg'])
                        .alignCenter()
                        .toggleClass('hidden');
//                        .removeClass('hidden'); //Berdimurat Masaliev 
					setTimeout("close_p()",3000);
                }
            }
        }).fail(function(e){alert('Error');});
        return false;
    });

    $('.bin-arrow').click(function(){
        $("#bin-content").empty().html('<img src="'+baseUrl+'/images/ajax-loader.gif" />');
        $('#bin-content').toggle('fast', chkVisible);
        return false;
    });

    function chkVisible(){
        if ($(this).is(":visible")) {
            $('.bin-arrow').removeClass('bin-arrow-down').addClass('bin-arrow-up');
            $.ajax({
                url: $('#bin-get').attr('href'),
                success: function(html){
                    $('#bin-content').empty().html(html);
                    if (html == 'Ваша корзина пуста'){
                        $('#bin-product').empty().html(html);
                    }
                }
            }).fail(function(){alert('Error');});
        }else{
            $('.bin-arrow').removeClass('bin-arrow-up').addClass('bin-arrow-down');
        }
    }

    $('.bin-pop-close, .del_item').live('click', function(){
        var obj = $(this);
        $.ajax({
            url: obj.attr('href'),
            success: function(data){
                if (data['error'] == 0){
                    $('#bin-product').empty().html(data['bin']);
                    $('#item_'+obj.attr('id')).remove();
                    if (data['count'] <= 0){
                        $('#bin-content').empty().html('Корзина пуста');
                    }
                    $('#total').empty().html(data['t']);
                }else{
                    alert("Что то ни то...");
                    $('#bin-content').hide();
                    $('.bin-arrow').removeClass('bin-arrow-up').addClass('bin-arrow-down');
                }
            }
        }).fail(function(){alert('Error');});

        return false;
    });

});