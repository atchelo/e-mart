"use strict";

$(function () {

  $('.loaderT').fadeOut('fast');
  $('.preL').fadeOut('fast');

  $('body').attr('scroll', 'yes');
  $('body').css('overflow', 'auto');
  $('form').on('submit', function () {
    $('.preL').fadeIn('fast');
    $('.loaderT').fadeIn('fast');
    $('body').attr('scroll', 'no');
    $('body').css('overflow', 'hidden');
  });
});

tinymce.init({
  selector: '#editor1',
  height: 350,
  menubar: 'edit view insert format tools table tc',
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste wordcount'
  ],
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});