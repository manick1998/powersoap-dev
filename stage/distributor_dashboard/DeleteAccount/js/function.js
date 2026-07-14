//    Order Management
   
   
    function showmodal3(){
    $('#toggle5').hide();
    $('#toggle6').show();
    }  
    function showmodal4(){
    $('#toggle5').hide();
    $('#toggle7').show();
    }  

//Inverntry Managemant
    function hidemodal(){
    $('#toggle4').hide();
    $('#toggle3').show();
    }  
    function hidemodal1(){
    $('#toggle6').hide();
    $('#toggle5').show();
    } 

//Employees
  
    function hidemodal2(){
    $('#daily_summary_view').hide();
    $('#daily_summary').show();
    }   
    function showmodal6() {
    $('#daily_summary').hide();
    $('#daily_summary_view').show();
    }   











// Date
$(function() {
    $('#date_input').datepicker();
    $('#some').click(function() {
          $('#date_input').datepicker('show');
          return false;
    });
    $('input:button').click(function() {
          $('#date_input').datepicker('show');
    });
});