 "use strict";    
   
  $(function () {
     
     $(document).on('click','#btn-more',function(){
         var id = $(this).data('id');
         var postid = $(this).data('postid');
         $("#btn-more").html("Loading....");
         $.ajax({
             url : loadmorecommenturl,
             method : "POST",
             data : {proid: postid, id:id, _token: $('meta[name="csrf-token"]').attr('content') },
             dataType : "html",
             success : function (data)
             {
                if(data != '') 
                {
                    $('#remove-row').remove();
                    $('#blogComments').append(data);
                }
                else
                {
                    $('#btn-more').html("No More Comments...");
                }
             }
         });
     });  
  }); 

  $("#blogsearch").autocomplete({
  source: function(request, response) {
                $.ajax({
                url: url,
                data: {
                      search : request.term
                 },
                dataType: "json",
                success: function(data){
                    
                    var resp = $.map(data,function(obj){

                    return {
                               
                               label: obj.value,
                               value: obj.value,
                               img: obj.img,
                               url: obj.slug
                               
                           }

                   });


                   response(resp);
                   
                }
            });


        },
        select: function(event, ui) {

          if(ui.item.value !='No Result found')
                {
                  event.preventDefault();
                  location.href= blogpost+'/'+ui.item.url;
                }else{
                  // $('#search-field').val() = '';
                  return false;

                }

        }
  }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li><div><img src='"+item.img+"'><span>"+item.value+"</span></div></li>" ).appendTo( ul );
};;