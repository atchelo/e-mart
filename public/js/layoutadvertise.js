"use strict";
        
// Define your library strictly...

 $(function () {
     
      var table = $('#adTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: advindexurl,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searhable : false},
              {data : 'layout', name : 'layout'},
              {data : 'pos', name : 'pos', searhable : false},
              {data : 'status', name : 'status',   searhable : false},
              {data : 'action', name : 'action',   searhable : false},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
    });

$('#img1linkby').on('change',function(){

      var opt = $(this).val();

      if(opt == 'linkbycat'){
        $('#catbox1').show('fast');
        $('#probox1').hide('fast');
        $('#urlbox1').hide('fast');
      }else if(opt == 'linkbypro'){
        $('#probox1').show('fast');
        $('#catbox1').hide('fast');
        $('#urlbox1').hide('fast');
      } 
      else if(opt == 'linkbyurl'){
        $('#urlbox1').show('fast');
        $('#catbox1').hide('fast');
        $('#probox1').hide('fast');
      }


    });

    $('#img2linkby').on('change',function(){

      var opt = $(this).val();

      if(opt == 'linkbycat'){
        $('#catbox2').show('fast');
        $('#probox2').hide('fast');
        $('#urlbox2').hide('fast');
      }else if(opt == 'linkbypro'){
        $('#probox2').show('fast');
        $('#catbox2').hide('fast');
        $('#urlbox2').hide('fast');
      } 
      else if(opt == 'linkbyurl'){
        $('#urlbox2').show('fast');
        $('#catbox2').hide('fast');
        $('#probox2').hide('fast');
      }

    });

    $('#img3linkby').on('change',function(){

      var opt = $(this).val();

      if(opt == 'linkbycat'){
        $('#catbox3').show('fast');
        $('#probox3').hide('fast');
        $('#urlbox3').hide('fast');
      }else if(opt == 'linkbypro'){
        $('#probox3').show('fast');
        $('#catbox3').hide('fast');
        $('#urlbox3').hide('fast');
      } 
      else if(opt == 'linkbyurl'){
        $('#urlbox3').show('fast');
        $('#catbox3').hide('fast');
        $('#probox3').hide('fast');
      }

    });
  
    $("#image1").on('change',function() {
      readURL1(this);
    });

    $("#image2").on('change',function() {
      readURL2(this);
    });

    $("#image3").on('change',function() {
      readURL3(this);
    });

    function readURL1(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#preview1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    function readURL2(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#preview2').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    function readURL3(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#preview3').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

