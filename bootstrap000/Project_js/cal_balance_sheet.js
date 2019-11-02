$(document).ready(function(){
    var cal_status = true; //not cal - new cal
    var cal_capital_status = true;
    $("#sum_asset").hide();
    $("#sum_capital").hide();
    $("#cal_asset").click(function(){
        if(cal_status){        
           if($("#cash").val() != '' || $("#bank_cash").val() != ''){
                $("#sum_asset").val(parseFloat($("#cash").val())+parseFloat($("#bank_cash").val()));
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
           if($("#cash_2").val() != '' || $("#bank_cash_2").val() != ''){
                $("#sum_capital").val(parseFloat($("#cash_2").val())+parseFloat($("#bank_cash_2").val()));
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