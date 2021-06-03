"use Strict";

$('.link_by').on('click',function(){
    var getvalue = $(this).val();

    if(getvalue == 'cat'){

        $('.advertiseoption').hide('fast');
        $('.show_image').prop('checked',false);
        $('.category_id').attr('required','required');
        $('.categorybox').show('fast');
        $('.pagebox').hide('fast');
        $('.urlbox').hide('fast');
        $('.categoryboxoption').show('fast');
        $('.subcategoriesoption').show('fast');
        $('.pageselector').removeAttr('required');
        $('.url').removeAttr('required');
    }

    if(getvalue == 'page'){

        $('.advertiseoption').hide('fast');
        $('.show_image').prop('checked',false);
        $('.category_id').removeAttr('required');
        $('.url').removeAttr('required');
        $('.pageselector').attr('required','required');
        $('.show_cat_in_dropdown').prop('checked',false);
        $('.show_child_in_dropdown').prop('checked',false);
        $('.pagebox').show('fast');
        $('.categorybox').hide('fast');
        $('.urlbox').hide('fast');
        $('.maincat').hide('fast');
        $('.categoryboxoption').hide('fast');
        $('.subcategoriesoption').hide('fast');
        $('.imgBanner').hide('fast');
        $('.subcat').hide('fast');
        $('.imgBanner').hide('fast');
    }

    if(getvalue == 'url'){

       $('.advertiseoption').hide('fast');
       $('.show_image').prop('checked',false);
       $('.url').attr('required','required');
       $('.category_id').removeAttr('required');
       $('.show_cat_in_dropdown').prop('checked',false);
       $('.show_child_in_dropdown').prop('checked',false);
       $('.categorybox').hide();
       $('.pagebox').hide('fast');
       $('.maincat').hide('fast');
       $('.subcat').hide('fast');
       $('.categoryboxoption').hide('fast');
       $('.subcategoriesoption').hide('fast');
       $('.urlbox').show('fast');
       $('.imgBanner').hide('fast');
       $('.pageselector').removeAttr('required');
    }

});

$('.category_id').on('change',function(){

    $('.show_child_in_dropdown').prop('checked',false);
    $('.subcat').hide('fast');

});

$('.menu_tag').on('change',function(){

  if($(this).is(':checked')){
    $('.tagcolor').show('fast');
    $('.tagtextcolor').show('fast');
    $('.tagbgcolor').show('fast');
    $('.tagtext').attr('required','required');
  }else{
    $('.tagcolor').hide('fast');
    $('.tagtextcolor').hide('fast');
    $('.tagbgcolor').hide('fast');
    $('.tagtext').removeAttr('required');
  }

});

$('.show_cat_in_dropdown').on('change',function(){

    if($(this).is(':checked')){

      $('.advertiseoption').show('fast');
      $('.categorybox').hide('fast');
      $('.category_id').removeAttr('required','required');
      $('.category_id').hide('fast');
      $('.maincat').show('fast');
      $('.subcat').hide('fast');
      $('.show_child_in_dropdown').prop('checked',false);

    }else{

      $('.advertiseoption').hide('fast');
      $('.categorybox').show('fast');
      $('.category_id').attr('required','required');
      $('.category_id').show('fast');
      $('.maincat').hide('fast');
      $('.imgBanner').hide('fast');
      $('.subcat').hide('fast');
      $('.show_child_in_dropdown').prop('checked',false);
      $('.show_image').prop('checked',false);
      $('.imgBanner').hide('fast');

    }

});

var urlget = baseUrl + '/admindesk/onload/subcat';

$('.show_child_in_dropdown').on('change',function(){

   if($(this).is(':checked')){

     
      $('.categorybox').show('fast');
      $('.category_id').attr('required','required');
      $('.s_cat').attr('required','required');
      $('.c_cat').attr('required','required');

      
       var cat_id = $('.category_id').val();

       if(cat_id == undefined || cat_id == ''){
         $('.show_cat_in_dropdown').prop('checked',false);
          $(this).prop('checked',false);
          $('.maincat').hide('fast');
          $('.show_image').prop('checked',false);
          $('.imgBanner').hide('fast');
          alert('Please select a category!');
          return false;
       }else{
            makechildcatbox(cat_id);
            $('.advertiseoption').show('fast');
            $('.imgBanner').hide('fast');
       }

   }else{

      $('.advertiseoption').hide('fast');
      $('.subcat').hide('fast');
      $('.s_cat').removeAttr('required');
      $('.c_cat').removeAttr('required');
      $('.show_image').prop('checked',false);
      $('.imgBanner').hide('fast');
   }

   
    
});

$('.show_image').on('change',function(){

    if($(this).is(':checked')){

      $('.imgBanner').show('fast');  

    }else{

      $('.imgBanner').hide('fast');

    }

});

function makechildcatbox(cat_id,menuid){
  $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlget,
            data: {
              catId: cat_id,
              menuid : menuid
            },
            success: function(data) {
              $('.subcat').show('fast');
              $('.show_cat_in_dropdown').prop('checked',false);
              $('.maincat').hide('fast');
              $('.subcat').html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
  });
}



var menutable = $("table").is('#menu_table'); 


    $(function () {

      if(customcatid != undefined){
          makechildcatbox(customcatid,menuid);
      }

      if(menutable){
        var table = $('#menu_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'multicheck', name: 'multicheck', searchable : false, orderable : false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
                {data : 'title', name : 'title'},
                {data : 'adtl', name : 'adtl'},
                {data : 'action', name : 'action'},
            ],
            dom : 'lBfrtip',
            buttons : [
              'csv','excel','pdf','print','colvis'
            ],
        });
       
        
        $( "#menu_table" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
          });
          function sendOrderToServer() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
              order.push({
                id: $(this).attr('data-id'),
                position: index+1
              });
            });
            $.ajax({
              type: "POST", 
              dataType: "json", 
              url: sorturl,
              data: {
                 order: order,
                _token: token
              },
              success: function(response) {
                  if (response.status == "success") {
                    console.log(response);
                  } else {
                    console.log(response);
                  }
              }
            });
          }
        }
  });



