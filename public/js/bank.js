function preloadFunc()
{
  $('body').attr('scroll','no');
  $('body').css('overflow','hidden');
}
window.onpaint = preloadFunc();

$(function(){
  $('body').css({'overflow' : 'auto'});
});