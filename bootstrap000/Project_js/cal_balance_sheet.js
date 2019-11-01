$(document).ready(function(){
    var cal_status = true; //not cal - new cal
    $("#sum_asset").hide();

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
            $("#cash").val(null);
            $("#bank_cash").val(null);
            $("#sum_asset").val(null);
            $("#cal_asset").show("Asd");
            $(this).hide();
            cal_status = true;
        }
     });




    /*$("#cash").change(function(){
        var total = parseFloat($(this).val())+parseFloat($("#bank_cash").val());
        $("#sum_asset").val(total);
    });
    $("#bank_cash").change(function(){
        var total = parseFloat($(this).val())+parseFloat($("#cash").val());
        $("#sum_asset").val(total);
    });*/
});