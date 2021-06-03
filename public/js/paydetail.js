"use strict";

$("#txn_fee").on('change',function(){

    var oldamount = oldamountsent;
    var actualamount = $('#actualamount').val();
    var fee = $('#txn_fee').val();
    var newamount = actualamount-fee;
    var newamount = newamount.toFixed(2);
    $('#actualamount').val(newamount);
    $('#amounttotal').text(newamount);

    if(fee == '' || fee == 0.00 || fee == 0.0 || fee == 0){
        $('#actualamount').val(oldamount);
        $('#amounttotal').text(oldamount);
        
    }

});

$("#txn_fee2").on('change',function(){

    var oldamount = oldamountsent;
    var actualamount = $('#actualamount2').val();
    var fee = $('#txn_fee2').val();
    var newamount = actualamount-fee;
    var newamount = newamount.toFixed(2);
    $('#actualamount2').val(newamount);

    if(fee == '' || fee == 0.00 || fee == 0.0 || fee == 0){
        $('#actualamount2').val(oldamount);
        
    }

});