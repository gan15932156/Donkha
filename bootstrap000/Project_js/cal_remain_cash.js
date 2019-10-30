$(document).ready(function(){
   var cal_status = true; //not cal - new cal
   $("#cash_total").hide();
   
   $("#b1000").change(function(){
      $("#cal1000").val($(this).val()*1000);
   });
   $("#b500").change(function(){
      $("#cal500").val($(this).val()*500);
   });
   $("#b100").change(function(){
      $("#cal100").val($(this).val()*100);
   });
   $("#b50").change(function(){
      $("#cal50").val($(this).val()*50);
   });
   $("#b20").change(function(){
      $("#cal20").val($(this).val()*20);
   });
   $("#c10").change(function(){
      $("#cal10").val($(this).val()*10);
   });
   $("#c5").change(function(){
      $("#cal5").val($(this).val()*5);
   });
   $("#c2").change(function(){
      $("#cal2").val($(this).val()*2);
   });
   $("#c1").change(function(){
      $("#cal1").val($(this).val()*1);
   });
   $("#c0_5").change(function(){
      $("#cal0_5").val($(this).val()*0.5);
   });
   $("#c0_25").change(function(){
      $("#cal0_25").val($(this).val()*0.25);
   });

   var cal1000 = 0.0;
   var cal500 = 0.0;
   var cal100 = 0.0;
   var cal50 = 0.0;
   var cal20 = 0.0;
   var cal10 = 0.0;
   var cal5 = 0.0;
   var cal2 = 0.0;
   var cal1 = 0.0;
   var cal0_5 = 0.0;
   var cal_25 = 0.0;
   $("#cal_total").click(function(){
      if(cal_status){
         cal1000 = parseFloat($("#cal1000").val());
         cal500 = parseFloat($("#cal500").val());
         cal100 = parseFloat($("#cal100").val());
         cal50 = parseFloat($("#cal50").val());
         cal20 = parseFloat($("#cal20").val());
         cal10 = parseFloat($("#cal10").val());
         cal5 = parseFloat($("#cal5").val());
         cal2 = parseFloat($("#cal2").val());
         cal1 = parseFloat($("#cal1").val());
         cal0_5 = parseFloat($("#cal0_5").val());
         cal_25 = parseFloat($("#cal0_25").val());
         var total =  cal1000 
         + cal500
         + cal100
         + cal50
         + cal20
         + cal10
         + cal5
         + cal2
         + cal1
         + cal0_5
         + cal_25 
         ;
         $("#cash_total").val(total);
         if($("#account_st_total").val() != ''){
            $("#diff_total").val(total - $("#account_st_total").val());
         }
         $("#cash_total").show("dadasdasd");
         $(this).hide();
         cal_status = false;  
      }     
   });
   $("#cash_total").click(function(){
      if(!cal_status){
         $("#cash_total").val(null);
         $("#diff_total").val(null);
         $("#cal_total").show("Asd");
         $(this).hide();
         cal_status = true;
      }
   });
});