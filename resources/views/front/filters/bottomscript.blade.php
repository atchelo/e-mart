<script> 

"use strict";
        
// Define your library strictly...

 $(function () {
    
  $("#xyz").on('change',function() {
    
    var id = $("#xyz").val();
    $.ajax({
      type: 'get',
      dataType: 'html',
      url: '{{ url('details') }}/' + id,
      success: function(data) {
        $('.category-product').html(data);
      }
    });
  });

  if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
        $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Result Found or there is no product in this category !</h3></div>');
  }
  
});



function categoryfilter(cid, sid, chid, first, last) {

  
  
  $('.preL').fadeIn('fast');
  $('.preloader3').fadeIn('fast');

  var conversion_rate = +'{{round($conversion_rate, 4)}}';
  var start = first;
  var start2 = first * conversion_rate;
  start2 = start2.toFixed(2);
  var end2 = last * conversion_rate;
  end2 = end2.toFixed(2);

  var end = last;
  var exist = window.location.href;
  var url = new URL(exist);
  $('input:checkbox.brand_check').each(function() {
    var checkVal = $(this).is(':checked');
    if(checkVal == true) {
      var sThisVal = $(this).val();
      brandsArr.push(sThisVal);
    }
  });
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
  var tag = getUrlParameter('tag');
  var brand_t = getUrlParameter('brands');
  var featured = getUrlParameter('featured');
  var keyword = getUrlParameter('keyword');
  var query_string = url.search;
  var search_params = new URLSearchParams(query_string);
  if(chid != '') {
    search_params.set('category', cid);
    search_params.set('sid', sid);
    search_params.set('chid', chid);
  } else {
    if(sid != '') {
      search_params.set('category', cid);
      search_params.set('sid', sid);
    } else {
      search_params.set('category', cid);
    }
  } 
  search_params.set('start', start2);
  search_params.set('end', end2);
 
  url.search = search_params.toString();
 
  var new_url = url.toString();
  window.history.pushState('page2', 'Title', new_url);
  if(chid == '') {
    var chid1 = getUrlParameter('chid');
    var removechid;
    var indexing = window.location.href.indexOf('?') + 1;
    var chidIndex = window.location.href.indexOf('chid=');
    var urlbrands = getUrlParameter('brands');
    
    if(chidIndex == indexing) {
      removechid = 'sid=' + chid1;
      var exist = window.location.href;
      var new_url = exist.replace(removechid, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removechid = '&chid=' + chid1;
      var exist = window.location.href;
      var new_url = exist.replace(removechid, '');
      window.history.pushState('page2', 'Title', new_url);
    }
    if(sid == '') {
      var sidP = getUrlParameter('sid');
      var chid = getUrlParameter('chid');
      var removeTag;
      var removeSid;
      var removechid;
      var indexing = window.location.href.indexOf('?') + 1;
      var tagIndex = window.location.href.indexOf('tag=');
      var sidIndex = window.location.href.indexOf('sid=');
      var chidIndex = window.location.href.indexOf('chid=');
      var urlbrands = getUrlParameter('brands');
      var rating_find = getUrlParameter('ratings');
      var start_rat_find = getUrlParameter('start_rat');
      var varTypeFind = getUrlParameter('varType');
      var varValueFind = getUrlParameter('varValue');
      var oot = getUrlParameter('oot');
     
      if(sidIndex == indexing) {
        removeSid = 'sid=' + sidP;
        var exist = window.location.href;
        var new_url = exist.replace(removeSid, '');
        window.history.pushState('page2', 'Title', new_url);
      } else {
        removeSid = '&sid=' + sidP;
        var exist = window.location.href;
        var new_url = exist.replace(removeSid, '');
        window.history.pushState('page2', 'Title', new_url);
      }
     
      if(chidIndex == indexing) {
        removechid = 'sid=' + chid;
        var exist = window.location.href;
        var new_url = exist.replace(removechid, '');
        window.history.pushState('page2', 'Title', new_url);
      } else {
        removechid = '&chid=' + chid;
        var exist = window.location.href;
        var new_url = exist.replace(removechid, '');
        window.history.pushState('page2', 'Title', new_url);
      }
    }
    chid = '';
  }
  if(tag == undefined) {} else {
    tag = tag.replace(/,/g, '%2C');
    removeTag = '&tag=' + tag;
    var exist = window.location.href;
    var new_url = exist.replace(removeTag, '');
    window.history.pushState('page2', 'Title', new_url);
    tag = '';
    tagsarray = [];
  }
  var removeBrand;
  if(sid != '') {} else {
    if(urlbrands == undefined) {} else {
      urlbrands = urlbrands.replace(/,/g, '%2C');
      removeBrand = '&brands=' + urlbrands;
      var exist = window.location.href;
      var new_url = exist.replace(removeBrand, '');
      window.history.pushState('page2', 'Title', new_url);
      urlbrands = '';
      brandsArr = '';
      $('input:checkbox.brand_check').each(function() {
        var checkVal = $(this).is(':checked');
        if(checkVal == true) {
          var sThisVal = $(this).removeAttr('checked');
        }
      });
    }
    if(featured == 1) {
      var removeFeatured = '&featured=' + featured;
      var exist = window.location.href;
      var new_url = exist.replace(removeFeatured, '');
      window.history.pushState('page2', 'Title', new_url);
      var checkVal = $('#feapro').is(':checked');
      if(checkVal == true) {
        var sThisVal = $('#feapro').removeAttr('checked');
      }
      featured = 0;
    }
    if(rating_find) {
      var removeRating = '&ratings=' + rating_find;
      var exist = window.location.href;
      var new_url = exist.replace(removeRating, '');
      window.history.pushState('page2', 'Title', new_url);
    }
    if(start_rat_find) {
      var removeStart_rat = '&start_rat=' + start_rat_find;
      var exist = window.location.href;
      var new_url = exist.replace(removeStart_rat, '');
      window.history.pushState('page2', 'Title', new_url);
    }
   
    if(varTypeFind) {
      
      if(varTypeFind === undefined) {} else {
        variantArray = varTypeFind.split(',');
        $(variantArray).each(function(i) {
          $('.var_check_all').each(function(j) {
            $(this).prop('checked', false);
          });
        });
      }
      var removevarTypeFind = '&varType=' + varTypeFind;
      var exist = window.location.href;
      var new_url = exist.replace(removevarTypeFind, '');
      window.history.pushState('page2', 'Title', new_url);
      variantArray = [];
      attrArray = [];
    }
    if(varValueFind) {
      var removevarValueFind = '&varValue=' + varValueFind;
      var exist = window.location.href;
      var new_url = exist.replace(removevarValueFind, '');
      window.history.pushState('page2', 'Title', new_url);
      variantArray = [];
      attrArray = [];
     
    }
   
  }
  $.ajax({
    url: "{{ url('categoryfilter')}}",
    method: 'GET',
    datatype: 'html',
    data: {
      tag: tag,
      catID: cid,
      sid: sid,
      chid: chid,
      start: start2,
      end: end2,
      brandNames: brandsArr,
      variantArray: variantArray,
      attrArray: attrArray,
      featured: featured,
      oot: oot,
      keyword: keyword
    },
    success: function(data) {

      

      if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
        $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Result Found or there is no product in this category !</h3></div>');
      }else{
        $('#updatediv').html(data.product);
      }
      setTimeout(function() {

        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');

      }, 500);
      $('#tags-all').html(' ');
      $('.adbox').html('');
      $('.adbox').append(data.ad);
      $('.brand-checkbox').html('');
      $('.sidebar-custom').html('');
      $.each(data.tagsunique, function(i) {
        $('#tags-all').append('<a onClick="tagfilter(\'' + data.tagsunique[i] + '\',\'' + i + '\')" id="tag' + i + '" name="' + data.tagsunique[i] + '" class="item pro-tags-all"><i>' + data.tagsunique[i] + '</i></a>');
      });
      var ver;
      $.each(data.variantProduct, function(i, provalues) {
        $('.sidebar-custom').append('<div class="sidebar-widget outer-top-vs"><a id="expand' + data.variantProduct[i]['id'] + '" onclick="expand(\'' + data.variantProduct[i]['id'] + '\')" class="pull-right btn btn-xs" data-toggle="collapse" data-target="#attrBox' + data.variantProduct[i]['id'] + '"><i class="fa fa-minus"></i></a><h3 class="section-title"><i>' + data.variantProduct[i]['attr_name'].replace(/_/g, ' ') + '</i></h3><div id="attrBox' + data.variantProduct[i]['id'] + '"class="collapse" class="sidebar-widget-body"></div></div>');
        $.each(data.variantProduct[i].provalues, function(key, val) {
          if(val.values == val.unit_value || val.unit_value == null) {
            $('#attrBox' + data.variantProduct[i]['id']).append('<div class="brand-list-check"><label class="form-check-label">' + val.values + '<input class="var_check_all var_check' + data.variantProduct[i]['id'] + '" type="checkbox" id="variant' + val.id + '" value="' + val.id + '" onclick="getvariantpro(\'' + data.variantProduct[i]['id'] + '\',\'' + val.id + '\')"><span class="checkmark"></span></label></div>')
          } else {
            if(data.variantProduct[i]['attr_name'] == "Color" || data.variantProduct[i]['attr_name'] == "Colour" || data.variantProduct[i]['attr_name'] == "color" || data.variantProduct[i]['attr_name'] == "colour") {
              $('#attrBox' + data.variantProduct[i]['id']).append('<div class="brand-list-check"><label class="form-check-label"><div class="display-inline"><div class="color-options"><ul><li title="' + val.values + '" class="color varcolor active"><a href="#" title=""><i style="color: ' + val.unit_value + '" class="fa fa-circle"></i></a><div class="overlay-image overlay-deactive"></div></li></ul></div></div><span class="tx-color">' + val.values + '</span><input class="var_check_all var_check' + data.variantProduct[i]['id'] + '" type="checkbox" id="variant' + val.id + '" value="' + val.id + '" onclick="getvariantpro(\'' + data.variantProduct[i]['id'] + '\',\'' + val.id + '\')"><span class="checkmark"></span></label></div>')
            } else {
              $('#attrBox' + data.variantProduct[i]['id']).append('<div class="brand-list-check"><label class="form-check-label">' + val.values + ' ' + val.unit_value + '<input class="var_check_all var_check' + data.variantProduct[i]['id'] + '" type="checkbox" id="variant' + val.id + '" value="' + val.id + '" onclick="getvariantpro(\'' + data.variantProduct[i]['id'] + '\',\'' + val.id + '\')"><span class="checkmark"></span></label></div>')
            }
          }
        });
      });
      $.each(data.sidebarbrands, function(i) {
        $('.brand-checkbox').append('<li><div class="brand-list-check"><label class="form-check-label">' + data.sidebarbrands[i] + '<input class="brand_check" type="checkbox" id="br' + i + '" value="' + i + '" onclick="getBrandProducts(\'' + i + '\')"><span class="checkmark"></span></label></div></li>');
      });
      var size_li = $("#tags-all a").length;
      var newsizeli = $('.brand-checkbox li').length;
      var y = 5;
      var brandShow = 5;
      if(y < newsizeli) {
        $('#loadMorebrandsTd').show();
        $('#loadMore').show();
      } else {
        $('#loadMorebrandsTd').hide();
        $('#loadMore').hide();
      }
      loadAndShow();
      var x = 10;
      var startShow = 10;
      if(x < size_li) {
        $('#loadMoretagsTd').show();
        $('#loadMoretags').show();
      } else {
        $('#loadMoretagsTd').hide();
        $('#loadMoretags').hide();
      }
      loadAndShowtags();
      $('#amountstart').val(start2);
      $('#amountend').val(end2);
      $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: Number(start2),
        max: Number(end2),
        values: [Number(start2), Number(end2)],
        step: 0.01,
        slide: function(event, ui) {
          
        },
        stop : function (event,ui){
            if(ui.values[0] == ui.values[1]) {
            return false;
          }
          $("#amountstart").val(ui.values[0].toFixed(2));
          $("#amountend").val(ui.values[1].toFixed(2));
          priceslider(cid, sid, chid);
        }
      });
      
      
    }
  });
}

function tagfilter($d, tagid) {
  
  var tagcheck = $('#tag' + tagid).attr('class');
  $('input:checkbox.brand_check').each(function() {
    var checkVal = $(this).is(':checked');
    if(checkVal == true) {
      var sThisVal = $(this).val();
      brandsArr.push(sThisVal);
    }
  });
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
  if(tagcheck == 'item pro-tags-all active') {
    for(var i = tagsarray.length; i--;) {
      if(tagsarray[i] === $d) tagsarray.splice(i, 1);
    }
    var d = "";
    $('#tag' + tagid).removeClass('active');
  } else {
    tagsarray.push($d);
    var d = $d;
    $('#tag' + tagid).addClass('active');
  }
  var tags = getUrlParameter('tag');
  var exist = window.location.href;
  var url = new URL(exist);
  var query_string = url.search;
  var search_params = new URLSearchParams(query_string);
  search_params.set('tag', tagsarray);
  url.search = search_params.toString();
  var new_url = url.toString();
  window.history.pushState('page2', 'Title', new_url);
  var removeTag;
  if(tagsarray.length == 0) {
    removeTag = '&tag=';
    var exist = window.location.href;
    var new_url = exist.replace(removeTag, '');
    window.history.pushState('page2', 'Title', new_url);
  } else {}
  var tag = getUrlParameter('tag');
  var start = getUrlParameter('start');
  var end = getUrlParameter('end');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var featured = getUrlParameter('featured');
  var ratings = getUrlParameter('ratings');
  var start_rat = getUrlParameter('start_rat');
  var oot = getUrlParameter('oot');
  var keyword = getUrlParameter('keyword');
  var tag_check = "yes";
  $.ajax({
    url: "{{ url('categoryfilter')}}",
    method: 'GET',
    datatype: 'html',
    data: {
      tag: tagsarray,
      catID: catID,
      sid: sid,
      chid: chid,
      tag_check: tag_check,
      start: minVal,
      end: maxVal,
      brandNames: brandsArr,
      variantArray: variantArray,
      attrArray: attrArray,
      featured: featured,
      ratings: ratings,
      start_rat: start_rat,
      oot: oot,
      keyword: keyword
    },
    success: function(data) {
      
      $('#updatediv').html(data.product);

      if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
        $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Result Found or there is no product in this category !</h3></div>');
      }

      var minVal2 = getUrlParameter('start');
      var maxVal2 = getUrlParameter('end');

      
    $("#slider-range").slider({
          range: true,
          orientation: "horizontal",
          min: Number(minVal2),
          max: Number(maxVal2),
          values: [Number(start), Number(end)],
          step: 0.1,
          slide: function(event, ui) {
           
        },
        stop : function(event,ui){
             if(ui.values[0] == ui.values[1]) {
              return false;
            }
            $("#amountstart").val(ui.values[0].toFixed(2));
            $("#amountend").val(ui.values[1].toFixed(2));
            priceslider(category, sid, chid);
        }
    });

    }
  });
}

function priceslider(cid,sid,chid) {
 
  var slider = 'yes';
  $('input:checkbox.brand_check').each(function() {
    var checkVal = $(this).is(':checked');
    if(checkVal == true) {
      var sThisVal = $(this).val();
      brandsArr.push(sThisVal);
    }
  });

  var amountstart = $("#amountstart").val();
  var amountend = $("#amountend").val();
  var exist = window.location.href;
  var url = new URL(exist);
  var conversion_rate = +'{{round($conversion_rate, 4)}}';
  var amountstart = amountstart;
  var amountend = amountend;
  var query_string = url.search;
  var search_params = new URLSearchParams(query_string);
  search_params.set('start', amountstart);
  search_params.set('end', amountend);
  url.search = search_params.toString();
  var new_url = url.toString();
  window.history.pushState('page2', 'Title', new_url);
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
  var tag = getUrlParameter('tag');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var featured = getUrlParameter('featured');
  var oot = getUrlParameter('oot');
  var keyword = getUrlParameter('keyword');
  var start_price = 1;
  var catId = getUrlParameter('category');
    $('.preL').fadeIn('fast');
    $('.preloader3').fadeIn('fast');
  setTimeout(function() {
    $.ajax({
      url: "{{ url('categoryfilter')}}",
      method: 'GET',
      datatype: 'html',
      data: {
        start: amountstart,
        end: amountend,
        catID: cid,
        sid: sid,
        chid: chid,
        tag: tagsarray,
        brandNames: brandsArr,
        variantArray: variantArray,
        attrArray: attrArray,
        slider: slider,
        start_price: start_price,
        featured: featured,
        oot: oot,
        keyword: keyword
      },
      success: function(data) {
        $('#updatediv').html(data.product);
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
        }
        
        setTimeout(function() {
            $('.preL').fadeOut('fast');
            $('.preloader3').fadeOut('fast');
          }, 500)
      },
      error: function(error) {
        console.log('error; ' + eval(error));
      }
    });
  }, 1000);
} 
  $('#brand_query').on('input propertychange paste', function() {
    
    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
      for(i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if(sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    };
    var getcatid = getUrlParameter('category');
    var brandname = $('#brand_query').val();
    var categoryId = getcatid;
    $.ajax({
      method: 'GET',
      url: '{{ url('filter/brand/') }}',
      datatype: "json",
      data: {
        categoryId: categoryId,
        brand: brandname
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
      },
      success: function(data) {
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
        }
        $('.brand-checkbox').html("");
        if(data == '') {
          $('.brand-checkbox').html("<li>No Brand Found !</li>");
        } else {
          var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
              sURLVariables = sPageURL.split('&'),
              sParameterName,
              i;
            for(i = 0; i < sURLVariables.length; i++) {
              sParameterName = sURLVariables[i].split('=');
              if(sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
              }
            }
          };
          var brandsVal = getUrlParameter('brands');
          if(brandsVal === undefined) {} else {
            brandsArr = brandsVal.split(',');
          }
          $.each(data, function(i) {
            $('.brand-checkbox').append("<li><div class='brand-list-check'><label class='form-check-label'>" + data[i]['name'] + "<input class='brand_check' type='checkbox' id='br" + data[i]['id'] + "' value='" + data[i]['id'] + "' onclick=getBrandProducts('" + data[i]['id'] + "')><span class='checkmark'></span></label></div></li>");
          });
          var xyzzzz = new Array();
          var x2 = new Array();
          $(brandsArr).each(function(i) {
            $('.brand_check').each(function(j) {
              var bVal = $(this).val();
              var namsC = $(this).parent().text();
              if(bVal == brandsArr[i]) {
                $(this).prop('checked', true);
              }
            });
          });
        }
        $('.brand_check').each(function(k) {
          var bVal = $(this).val();
          var namsC = $(this).parent().text();
          var bChecked = $(this).is(':checked');
          if(bChecked == true) {
            var htmlT = "<li><div class='brand-list-check'><label class='form-check-label'>" + namsC + "<input class='brand_check' checked type='checkbox' id='br" + bVal + "' value='" + bVal + "' onclick=getBrandProducts('" + bVal + "')><span class='checkmark'></span></label></div></li>"
            xyzzzz.push(htmlT);
          } else {
            var htmlT2 = "<li><div class='brand-list-check'><label class='form-check-label'>" + namsC + "<input class='brand_check' type='checkbox' id='br" + bVal + "' value='" + bVal + "' onclick=getBrandProducts('" + bVal + "')><span class='checkmark'></span></label></div></li>"
            x2.push(htmlT2);
          }
        });
        var arr3 = $.merge(xyzzzz, x2);
        var myNewArray = arr3.filter(function(elem, index, self) {
          return index === self.indexOf(elem);
        });
        $('.brand-checkbox').html('');
        $(arr3).each(function(l) {
          $('.brand-checkbox').append(arr3[l]);
        });
        loadAndShow();
        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');
      }
    });
  });
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
var brandsVal = getUrlParameter('brands');
if(brandsVal === undefined) {} else {
  brandsArr = brandsVal.split(',');
}

function getBrandProducts(id) {
  
  var brandEnable = $('#br' + id).is(':checked');
  if(brandEnable == true) {
    var sThisVal = $('#br' + id).val();
    brandsArr.push(sThisVal);
  } else {
    brandsArr = jQuery.grep(brandsArr, function(value) {
      return value != id;
    });
  }
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
  var tag = getUrlParameter('tag');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var brnd = getUrlParameter('brands');
  var featured = getUrlParameter('featured');
  var ratingsVal = getUrlParameter('ratings');
  var start_ratVal = getUrlParameter('start_rat');
  var oot = getUrlParameter('oot');
  var keyword = getUrlParameter('keyword');
  if(brandsArr.length == 0) {
    brnd = getUrlParameter('brands');
    var removebrnd;
    var indexing = window.location.href.indexOf('?') + 1;
    var brndIndex = window.location.href.indexOf('brands=');
    if(brndIndex == indexing) {
      removebrnd = 'brands=' + brnd;
      var exist = window.location.href;
      var new_url = exist.replace(removebrnd, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removebrnd = '&brands=' + brnd;
      var exist = window.location.href;
      var new_url = exist.replace(removebrnd, '');
      window.history.pushState('page2', 'Title', new_url);
    }
  } else {
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set('brands', brandsArr);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState('page2', 'Title', new_url);
  }
  var lprices = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprices = lprices.toFixed(2);
  var hprices = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprices = hprices.toFixed(2);
  if(lprices == hprices) {
    lprices = 0.00;
  }
  $.ajax({
    url: "{{ url('categoryfilter')}}",
    method: 'GET',
    datatype: 'html',
    data: {
      tag: tagsarray,
      catID: catID,
      sid: sid,
      chid: chid,
      start: lprices,
      end: hprices,
      brandNames: brandsArr,
      variantArray: variantArray,
      attrArray: attrArray,
      featured: featured,
      oot: oot,
      ratings: ratingsVal,
      start_ratVal: start_ratVal,
      keyword: keyword
    },
    beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
    },
    success: function(data) {
      $('#updatediv').html(data.product);
      if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
      }
      var getUrlParameter2 = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;
        for(i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');
          if(sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
        }
      };
      var tag2 = getUrlParameter2('tag');
      var catID2 = getUrlParameter2('category');
      var sid2 = getUrlParameter2('sid');
      var chid2 = getUrlParameter2('chid');
      var minVal2 = getUrlParameter2('start');
      var maxVal2 = getUrlParameter2('end');
      $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: Number(minVal2),
        max: Number(maxVal2),
        values: [Number(minVal2), Number(maxVal2)],
        step: 0.01,
        slide: function(event, ui) {
          
        },
        stop : function(event,ui){
            if(ui.values[0] == ui.values[1]) {
            return false;
          }
          $("#amountstart").val(ui.values[0].toFixed(2));
          $("#amountend").val(ui.values[1].toFixed(2));
          priceslider(catID2, sid2, chid2);
        }
      });

      $('.preL').fadeOut('fast');
      $('.preloader3').fadeOut('fast');
    }
  });
} 
function loadAndShowtags() {
  var size_li = $("#tags-all a").length;
  var x = 10;
  var startShow = 10;
  if(x <= size_li) {
    $('#loadMoretags').show();
  }
  $('#tags-all a').not(':lt(' + x + ')').hide();
  if(x == startShow) {
    $('#showLesstagsTd').fadeOut(1000);
  }
  $('#loadMoretags').on('click',function() {
    x = (x + 10 <= size_li) ? x + 10 : size_li;
    if(x > startShow) {
      $('#showLesstagsTd').fadeIn(1000);
      $('#showLesstags').fadeIn(1000);
    }
    $('#tags-all a:lt(' + x + ')').fadeIn('fast');
    if(x == size_li) {
      $('#loadMoretagsTd').fadeOut(1000);
      $('#loadMoretags').fadeOut(1000);
    }
  });
  $('#showLesstags').on('click',function() {
    if(x == size_li) {
      $('#loadMoretagsTd').fadeIn(1000);
      $('#loadMoretags').fadeIn(1000);
    }
    x = (x - 10 < 0) ? 10 : x - 10;
    if(x == startShow) {
      $('#showLesstagsTd').fadeOut(1000);
      $('#showLesstags').fadeOut(1000);
    }
    if(x >= startShow) {
      $('#tags-all a').not(':lt(' + x + ')').fadeOut('fast');
    } else {
      x = startShow;
      $('#tags-all a').not(':lt(' + x + ')').fadeOut('fast');
      $('#showLesstagsTd').fadeOut(1000);
      $('#showLesstags').fadeOut(1000);
    }
  });
};

function loadAndShow() {
  var size_li = $("#myList li").length;
  var x = 5;
  var startShow = 5;
  if(x <= size_li) {
    $('#loadMore').show();
  }
  if(x == startShow) {
    $('#showLessbrandsTd').fadeOut(1000);
  }
  $('#myList li').not(':lt(' + x + ')').hide();
  $('#loadMore').on('click',function() {
    x = (x + 10 <= size_li) ? x + 10 : size_li;
    if(x > startShow) {
      $('#showLessbrandsTd').fadeIn(1000);
      $('#showLess').fadeIn(1000);
    }
    $('#myList li:lt(' + x + ')').fadeIn('fast');
    if(x == size_li) {
      $('#loadMorebrandsTd').fadeOut(1000);
      $('#loadMore').fadeOut(1000);
    }
  });
  $('#showLess').on('click',function() {
    if(x == size_li) {
      $('#loadMorebrandsTd').fadeIn(1000);
      $('#loadMore').fadeIn(1000);
    }
    x = (x - 10 < 0) ? 5 : x - 10;
    if(x == startShow) {
      $('#showLessbrandsTd').fadeOut(1000);
      $('#showLess').fadeOut(1000);
    }
    if(x >= startShow) {
      $('#myList li').not(':lt(' + x + ')').fadeOut('fast');
    } else {
      x = startShow;
      $('#myList li').not(':lt(' + x + ')').fadeOut('fast');
      $('#showLessbrandsTd').fadeOut(1000);
      $('#showLess').fadeOut(1000);
    }
  });
};

$(function () {
  loadAndShow();
  loadAndShowtags();
}); 

  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;
    for(i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');
      if(sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
var newarr = new Array();

function getvariantpro(attrid, variantid) {
  var varType = getUrlParameter('varType');
  var varValue = getUrlParameter('varValue');
  var variantEnable = $('#variant' + variantid).is(':checked');
  var count_checkbox = +($('.var_check' + attrid + ':checkbox:checked').length);
  if(variantEnable == true) {
    var sThisVal = $('#variant' + variantid).val();
    variantArray.push(sThisVal);
  } else {
    variantArray = jQuery.grep(variantArray, function(value) {
      return value != variantid;
    });
  }
  if(count_checkbox > 0) {
    if(jQuery.inArray(attrid, attrArray) == -1) {
      attrArray.push(attrid);
    } else {
      var index = attrArray.indexOf(attrid);
      if(index !== -1) {
        attrArray[index] = attrid;
      }
    }
  } else {
    var removeItem = attrid;
    attrArray = jQuery.grep(attrArray, function(value) {
      return value != removeItem;
    });
  }
  if(variantArray == null) {
    attrArray = [];
    variantArray = [];
  }
  if(variantArray.length == 0) {
    var removevarType;
    var indexing = window.location.href.indexOf('?') + 1;
    var varTypeIndex = window.location.href.indexOf('varType=');
    if(varTypeIndex == indexing) {
      removevarType = 'varType=' + varType;
      var exist = window.location.href;
      var new_url = exist.replace(removevarType, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removevarType = '&varType=' + varType;
      var exist = window.location.href;
      var new_url = exist.replace(removevarType, '');
      window.history.pushState('page2', 'Title', new_url);
    }
    var removevarValue;
    var indexing = window.location.href.indexOf('?') + 1;
    var varValueIndex = window.location.href.indexOf('varValue=');
    if(varValueIndex == indexing) {
      removevarValue = 'varValue=' + varValue;
      var exist = window.location.href;
      var new_url = exist.replace(removevarValue, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removevarValue = '&varValue=' + varValue;
      var exist = window.location.href;
      var new_url = exist.replace(removevarValue, '');
      window.history.pushState('page2', 'Title', new_url);
    }
  } else {
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set('varType', attrArray);
    search_params.set('varValue', variantArray);
    url.search = search_params.toString();
    var new_url = url.toString();
  
    window.history.pushState('page2', 'Title', new_url);
  }
  var tag = getUrlParameter('tag');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var brnd = getUrlParameter('brands');
  var ratingsVal = getUrlParameter('ratings');
  var featured = getUrlParameter('featured');
  var oot = getUrlParameter('oot');
  var start_ratVal = getUrlParameter('start_rat');
  var keyword = getUrlParameter('keyword');
  var lprices = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprices = lprices.toFixed(2);
  var hprices = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprices = hprices.toFixed(2);
  if(lprices == hprices) {
    lprices = 0.00;
  }
  $.ajax({
    url: "{{ url('categoryfilter') }}",
    method: 'GET',
    datatype: 'html',
    data: {
      tag: tagsarray,
      catID: catID,
      start: minVal,
      end: maxVal,
      sid: sid,
      chid: chid,
      brandNames: brandsArr,
      attrArray: attrArray,
      variantArray: variantArray,
      ratings: ratingsVal,
      start_rat: start_ratVal,
      featured: featured,
      oot: oot,
      keyword: keyword
    },
    beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
    },
    success: function(data) {
      $('#updatediv').html(data.product);

      if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
      }

      $('.preL').fadeOut('fast');
      $('.preloader3').fadeOut('fast');
    }
  });
}

function getratingproduct(rating) {
  $('.rt_chk').each(function() {
    $(this).prop('checked', false);
  });
  var ratings;
  var start_rat;
  var tag = getUrlParameter('tag');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var brnd = getUrlParameter('brands');
  var ratingsVal = getUrlParameter('ratings');
  var start_ratVal = getUrlParameter('start_rat');
  var featured = getUrlParameter('featured');
  var oot = getUrlParameter('oot');
  var keyword = getUrlParameter('keyword');
  if(ratingsVal != rating) {
    $('#rat_pro' + rating).prop('checked', true);
  }
  if($('#rat_pro' + rating).is(':checked')) {
    ratings = rating;
    start_rat = ratings - 20;
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set('ratings', rating);
    search_params.set('start_rat', start_rat);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState('page2', 'Title', new_url);
  } else {
    ratings = 0;
    start_rat = 0;
    var removevarRatings;
    var removeStrRatings;
    var indexing = window.location.href.indexOf('?') + 1;
    var varRatingsIndex = window.location.href.indexOf('ratings=');
    var varStrRatingsIndex = window.location.href.indexOf('start_rat=');
    if(varRatingsIndex == indexing) {
      removevarRatings = 'ratings=' + ratingsVal;
      var exist = window.location.href;
      var new_url = exist.replace(removevarRatings, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removevarRatings = '&ratings=' + ratingsVal;
      var exist = window.location.href;
      var new_url = exist.replace(removevarRatings, '');
      window.history.pushState('page2', 'Title', new_url);
    }
    if(varStrRatingsIndex == indexing) {
      removeStrRatings = 'start_rat=' + start_ratVal;
      var exist = window.location.href;
      var new_url = exist.replace(removeStrRatings, '');
      window.history.pushState('page2', 'Title', new_url);
    } else {
      removeStrRatings = '&start_rat=' + start_ratVal;
      var exist = window.location.href;
      var new_url = exist.replace(removeStrRatings, '');
      window.history.pushState('page2', 'Title', new_url);
    }
  }
  var lprices = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprices = lprices.toFixed(2);
  var hprices = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprices = hprices.toFixed(2);
  if(lprices == hprices) {
    lprices = 0.00;
  }
  var url404 = "{{ url('images/nocart.jpg') }}";
  if($('#rat_pro' + rating).is(':checked')) {
    $.ajax({
      url: "{{ url('categoryfilter') }}",
      method: 'GET',
      datatype: 'html',
      data: {
        tag: tagsarray,
        catID: catID,
        start: minVal,
        end: maxVal,
        sid: sid,
        chid: chid,
        ratings: ratings,
        start_rat: start_rat,
        brandNames: brandsArr,
        attrArray: attrArray,
        variantArray: variantArray,
        featured: featured,
        oot: oot,
        keyword: keyword
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
      },
      success: function(data) {

        $('#updatediv').html(data.product);
        
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
        }

        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');

        
      }
    });
  } else {
    $.ajax({
      url: "{{ url('categoryfilter') }}",
      method: 'GET',
      datatype: 'html',
      data: {
        tag: tagsarray,
        catID: catID,
        start: minVal,
        end: maxVal,
        sid: sid,
        chid: chid,
        ratings: ratings,
        start_rat: start_rat,
        brandNames: brandsArr,
        attrArray: attrArray,
        variantArray: variantArray,
        keyword: keyword
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
      },
      success: function(data) {
        $('#updatediv').html(data.product);
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
        }

        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');

      }
    });
  }
} 

function getfeaturedpro(featured) {
  var tag = getUrlParameter('tag');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var brnd = getUrlParameter('brands');
  var ratingsVal = getUrlParameter('ratings');
  var start_ratVal = getUrlParameter('start_rat');
  var keyword = getUrlParameter('keyword');
  var oot = getUrlParameter('oot');
  var lprices = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprices = lprices.toFixed(2);
  var hprices = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprices = hprices.toFixed(2);
  if(lprices == hprices) {
    lprices = 0.00;
  }


  var url404 = "{{ url('images/nocart.jpg') }}";
  if($('#feapro').is(':checked')) {
    featured = 1;
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    
    search_params.set('featured', featured);
  
    url.search = search_params.toString();
    var new_url = url.toString();
    
    window.history.pushState('page2', 'Title', new_url);
  } else {
    featured = 0;
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    
    search_params.set('featured', featured);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState('page2', 'Title', new_url);
  }
  $.ajax({
    url: "{{ url('categoryfilter') }}",
    method: 'GET',
    datatype: 'html',
    data: {
      tag: tagsarray,
      catID: catID,
      start: minVal,
      end: maxVal,
      sid: sid,
      chid: chid,
      ratings: ratingsVal,
      start_rat: start_ratVal,
      brandNames: brandsArr,
      attrArray: attrArray,
      variantArray: variantArray,
      featured: featured,
      oot: oot,
      keyword: keyword
    },
    beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
    },
    success: function(data) {
      $('#updatediv').html(data.product);
      if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');
      }

        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');

    }
  });
} 

function excludeoot(value) {
  if($('#exoot').is(':checked')) {
    value = 1;
  } else {
    value = 0;
  }
  var tag = getUrlParameter('tag');
  var catID = getUrlParameter('category');
  var sid = getUrlParameter('sid');
  var chid = getUrlParameter('chid');
  var minVal = getUrlParameter('start');
  var maxVal = getUrlParameter('end');
  var brnd = getUrlParameter('brands');
  var ratingsVal = getUrlParameter('ratings');
  var start_ratVal = getUrlParameter('start_rat');
  var featured = getUrlParameter('featured');
  var keyword = getUrlParameter('keyword');
  var lprices = +'{{$first_cat * round($conversion_rate, 4)}}';
  lprices = lprices.toFixed(2);
  var hprices = +'{{$last_cat * round($conversion_rate, 4)}}';
  hprices = hprices.toFixed(2);
  if(lprices == hprices) {
    lprices = 0.00;
  }
  var url404 = "{{ url('images/nocart.jpg') }}";
  if($('#exoot').is(':checked')) {
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set('oot', value);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState('page2', 'Title', new_url);
    $.ajax({
      url: "{{ url('categoryfilter') }}",
      method: 'GET',
      datatype: 'html',
      data: {
        tag: tagsarray,
        catID: catID,
        start: minVal,
        end: maxVal,
        sid: sid,
        chid: chid,
        ratings: ratingsVal,
        start_rat: start_ratVal,
        brandNames: brandsArr,
        attrArray: attrArray,
        variantArray: variantArray,
        featured: featured,
        oot: value,
        keyword: keyword
      },
      beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
      },
      success: function(data) {
        $('#updatediv').html(data.product);
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');

         
        }

        $('.preL').fadeOut('fast');
        $('.preloader3').fadeOut('fast');
      }
    });
  } else {
    value = 0;
    var exist = window.location.href;
    var url = new URL(exist);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set('oot', value);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState('page2', 'Title', new_url);
    $.ajax({
      url: "{{ url('categoryfilter') }}",
      method: 'GET',
      datatype: 'html',
      data: {
        tag: tagsarray,
        catID: catID,
        start: minVal,
        end: maxVal,
        sid: sid,
        chid: chid,
        ratings: ratingsVal,
        start_rat: start_ratVal,
        brandNames: brandsArr,
        attrArray: attrArray,
        variantArray: variantArray,
        featured: featured,
        oot: value,
        keyword: keyword
      },
       beforeSend : function(){
        $('.preL').fadeIn('fast');
        $('.preloader3').fadeIn('fast');
      },
      success: function(data) {
        
        $('#updatediv').html(data.product);
        if($('#updatediv').children().length == 1 || $('#updatediv').children().length == 3) {
          $('#updatediv').html('<div class="mx-auto"><img src="' + url404 + '" alt="404 Not Found" title="No Matching Result Found or there is no product in this category !"><h3>No Matching Product Found or there is no product in this category !</h3></div>');

          
        }

          $('.preL').fadeOut('fast');
          $('.preloader3').fadeOut('fast');
      }
    });
  }
}



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    $('.lazy').lazy({

      effect: "fadeIn",
      effectTime: 1500,
      scrollDirection: 'both',
      threshold: 0,
      afterLoad: function(element) {
          console.log(element+' loaded successfully !');
      }

  });
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  attributes: true
  //...
});

</script>
