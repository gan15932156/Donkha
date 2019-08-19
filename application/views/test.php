<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 ?>
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>ธนาคารโรงเรียนดอนคาวิทยา</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/js/jquery.min.js"></script>

     <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/popper.min.js"></script>

     <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/bootstrap.min.js"></script>

     <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">

      <style type="text/css">
         

          html,body { 
               background: 
                    url("<?php  echo base_url()."picture/school.jpg"; ?>") no-repeat center center fixed; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                    height: 100%;
                
          } 

        .container-fluid{
          background-color: rgba(199, 223, 255,.9);
               width:90%;
               opacity: ;
               filter: alpha(opacity=40); /* For IE8 and earlier */
          }
          
                  
      </style>
     
      <script type="text/javascript">
        $(function () {
          $("#btnSubmit2").click(function () {
              var Rate = 0.1;
              var Deposit_Amt = 0;
              var interestRate = $("#Interest_Rate").val();
              var depositAmt = replaceAllString($("#Deposit_Amt").val(), ",", "");
              var y1 = $("#sy1").val();
              var m1 = $("#sm1").val();
              var d1 = $("#sd1").val();
              var y2 = $("#sy2").val();
              var m2 = $("#sm2").val();
              var d2 = $("#sd2").val();
              var Rate = 0;
              if ((interestRate != "") && !(isNaN(interestRate))) {
                  Rate = parseFloat(interestRate) / 100;
              } else {
                  showAlert($("#Interest_Rate"));
                  return;
              }
              if ((depositAmt != "") && !(isNaN(depositAmt))) {
                  Deposit_Amt = parseFloat(depositAmt);
              } else {
                  showAlert($("#Deposit_Amt"));
                  return;
              }
              if ($("#friendName1").val() == "") {
                  showAlert($("#friendName1"));
                  return;
              }
              if ($("#friendName2").val() == "") {
                  showAlert($("#friendName2"));
                  return;
              }

              m1 = m1 - 1;
              m2 = m2 - 1;
              var start_date = new Date(y1, m1, d1);
              var end_date = new Date(y2, m2, d2);
              var dif_date = (end_date.getTime()) - (start_date.getTime());
              var count_date = (dif_date / (86400000));
              var tot_date = (Math.round(count_date));
              var Interest1 = 0;
              var TempDep = depositAmt;
              while (tot_date > 180) {
                  tot_date = tot_date - 180;
                  TempInterest = (((TempDep * Rate) * 180) / 365);
                  Interest1 = Interest1 + TempInterest;
                  TempDep = Deposit_Amt + Interest1;
              }
              if (tot_date > 0) {
                  TempInterest = (((TempDep * Rate) * tot_date) / 365);
                  Interest1 = Interest1 + TempInterest;
              }
              Interest1 = Math.round(Interest1 * 100) / 100;
              $("#Interest")[0].innerHTML = addCommas(Interest1);
              if (Interest1 > 20000) {
                  Tax1 = (Interest1 * 0.15);
                  Tax1 = (Math.round(Tax1 * 100)) / 100;
                  Net = Interest1 - Tax1;
                  Net = (Math.round(Net * 100)) / 100;
                  $("#Tax")[0].innerHTML = addCommas(Tax1);
                  $("#Net_Interest")[0].innerHTML = addCommas(Net);
              } else {
                  $("#Tax")[0].innerHTML = 0;
                  $("#Net_Interest")[0].innerHTML = addCommas(Interest1);
              }
              return false;
          });
        });        
      </script>

 </head>
 <body>
    <h1 class="text-center" style="margin-top: 1%;"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="100px" height="120px">ธนาคารโรงเรียนดอนคาวิทยา</h1>

     <div class="container-fluid h-100" >
         
               
          
     </div>

     <!--<footer class="page-footer">
               <div class="footer-copyright py-3 text-center">
                    <marquee behavior="alternate"><font  color="black">ธนาคารโรงเรียน โรงเรียนดอนคาวิทยา ต.ดอนคา อ.อู่ทอง จ.สุพรรณบุรี 72160 &nbsp;</font></marquee>
               </div>
     </footer>-->

     </div>




 </body>
 </html>
