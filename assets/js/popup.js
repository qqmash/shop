/* PopUp */
function closePopup(){
    $('#popup').addClass('hidden');
    $('#opaco').addClass('hidden');
    return false;
}
function callPopup(id){
    showPopup('total');
    $('#prid').val(id);
}
//open pop-up
function showPopup(popup_type)
{
    $('#opaco').removeClass('hidden');
    $('#popup').empty()
        .html($('#popup-' + popup_type).html())
        .alignCenter()
        .toggleClass('hidden');

    return false;
}
$.fn.alignCenter = function() {
    //get margin left
    var marginLeft = Math.max(40, parseInt($(window).width()/2 - $(this).width()/2)) + 'px';
    //get margin top
    var marginTop = Math.max(5, parseInt($(window).height()/2 - $(this).height()/2)) + 'px';
    //return updated element
    return $(this).css({'left':marginLeft, 'top':marginTop});
};