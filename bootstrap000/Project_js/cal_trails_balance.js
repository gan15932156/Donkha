$(document).ready(function(){
    var cal_status = true; //not cal - new cal
    var cal_capital_status = true;

    $("#sum_asset").hide();
    $("#sum_capital").hide();
    
    $("#cal_asset").click(function(){
        if(cal_status){        
           if(
               $("#cash_asset").val() != '' || 
               $("#bank_cash_asset").val() != '' ||
               $("#deposit_member_asset").val() != '' || 
               $("#bank_interest_asset").val() != '' ||
               $("#interest_member_asset").val() != ''
            ){
                $("#sum_asset").val(
                    parseFloat($("#cash_asset").val()) +
                    parseFloat($("#bank_cash_asset").val()) +
                    parseFloat($("#deposit_member_asset").val()) +
                    parseFloat($("#bank_interest_asset").val()) +
                    parseFloat($("#interest_member_asset").val()) 
                );
           }
           $("#sum_asset").show("dadasdasd");
           $(this).hide();
           cal_status = false;  
        }     
     });
     $("#sum_asset").click(function(){
        if(!cal_status){
            $("#sum_asset").val(null);
            $("#cal_asset").show("Asd");
            $(this).hide();
            cal_status = true;
        }
     });
    $("#cal_capital").click(function(){
        if(cal_capital_status){        
            if(
                $("#cash_capital").val() != '' || 
                $("#bank_cash_capital").val() != '' ||
                $("#deposit_member_capital").val() != '' || 
                $("#bank_interest_capital").val() != '' ||
                $("#interest_member_capital").val() != ''
             ){
                 $("#sum_capital").val(
                     parseFloat($("#cash_capital").val()) +
                     parseFloat($("#bank_cash_capital").val()) +
                     parseFloat($("#deposit_member_capital").val()) +
                     parseFloat($("#bank_interest_capital").val()) +
                     parseFloat($("#interest_member_capital").val()) 
                 );
            }
            $("#sum_capital").show("dadasdasd");
            $(this).hide();
            cal_capital_status = false;  
         }     
     });
     $("#sum_capital").click(function(){
        if(!cal_capital_status){
            $("#sum_capital").val(null);
            $("#cal_capital").show("Asd");
            $(this).hide();
            cal_capital_status = true;
        }
     });
});