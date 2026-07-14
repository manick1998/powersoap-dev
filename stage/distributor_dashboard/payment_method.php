<?php
include "config.php";
include "$api_path/config/core_distributor.php";
session_start();
if (!$_SESSION['distributor_token'] || $_SESSION["verification_code"] != $verification_code) {
    header("Location:login.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/payment_method.css<?php echo $js_cache_string; ?>">


<style>
.brad-4{
    overflow: hidden;
}
table     {border-collapse: separate;}
</style>
    </head>
    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar15"></div>
        <div class="se-pre-con"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height">
                <div class="header_container">
                    <div>
                        <h1 class="header_main">Bank Details</h1>
                        <p class="stack_total_amount">Payment method Details</p>
                    </div>   
                </div>
         <div class="payment_methode">
            <div class="payment_methode-btn">
            <button class="primary-btn"  data-toggle="modal" data-target="#form" type="button">Add New</button>
            </div>

            <div class="payment--dedails">
                <div class="payment--cont">
                    <h5>UPI Transaction</h5>

                    <div class="payment-pramry">
                        <div class="payment_account-detail">
                            <ul>
                                <li>
                                    <table>
                                    <tbody id="PaymentUPI">
                                    </tbody>
                                </table>
                                </li>
                            </ul>
                            <br><br>
                        <h5>Bank Transaction</h5>

                            <ul>
                                <li>
                                    <table>
                                        <tbody id="paymentBank">
                                        </tbody>
                                    </table>
                                </li>
                            </ul>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            </section>


            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add New</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="pop_btn--flex bank-account__fields" id="model1">
                                    <div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Bank Name</p>
                                            <input class="input-field"  placeholder="Enter Bank Name" id="bank_name">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">IFSC Code</p>
                                            <input class="input-field"  placeholder="Enter IFSC Code" id="bank_code">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Account Number</p>
                                            <input class="input-field"  placeholder="Enter Account Number" id="account_number">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Account Holder Name</p>
                                            <input class="input-field"  placeholder="Enter Holder Name" id="holder_name">
                                        </div>
                                    </div>
                                    <div>
                                    <div class="form-control shop_name_box">
                                            <p class="shop_name">Google pay</p>
                                            <input class="input-field"  placeholder="Enter Google pay number" id="pay">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">PayTm</p>
                                            <input class="input-field"  placeholder="Enter Paytm Number" id="paytm">
                                        </div>
                                   </div>
                                </div>
                            </div>  
                            
                            <div class="modal-footer">
                                    <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Cancel</a>
                                    <button onclick="paymentDetails()" type="button" class="primary-btn"  id="update_button">Add</button>
                           </div>
                        </div>
                </div>
            </div>

            <div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Edit</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="pop_btn--flex bank-account__fields" id="model1">
                                    <div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Bank Name</p>
                                            <input class="input-field"  placeholder="Enter Bank Name" id="edit_bank_name">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">IFSC Code</p>
                                            <input class="input-field"  placeholder="Enter IFSC Code" id="edit_bank_code">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Account Number</p>
                                            <input class="input-field"  placeholder="Enter Account Number" id="edit_account_number">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">Account Holder Name</p>
                                            <input class="input-field"  placeholder="Enter Holder Name" id="edit_holder_name">
                                        </div>
                                    </div>
                                    <div>
                                    <div class="form-control shop_name_box">
                                            <p class="shop_name">Google pay</p>
                                            <input class="input-field"  placeholder="Enter Google pay number" id="edit_pay">
                                        </div>
                                        <div class="form-control shop_name_box">
                                            <p class="shop_name">PayTm</p>
                                            <input class="input-field"  placeholder="Enter Paytm Number" id="edit_paytm">
                                        </div>
                                   </div>
                                </div>
                              </div>  
                            
                            <div class="modal-footer">
                                    <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Cancel</a>
                                    <button onclick="editpaymentDetails()" type="button" class="primary-btn"  id="update_button">update</button>
                           </div>
                        </div>
                </div>
            </div>
        </main>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> -->
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        </script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
            const myTimeout = setTimeout(stopLoader, 1000);

            function stopLoader() {
                $(".se-pre-con").hide();
                clearTimeout(myTimeout);
            }
            $(document).ready(function(){
                $("#model2").hide();
                $('#shop_type').on('change', function(){
                    var demovalue = $(this).val(); 
                    if(demovalue =="bank" ){
                        $("#model2").hide();
                        $("#model1").show();
                    }else{
                        $("#model1").hide();
                        $("#model2").show();
                    }
                });

            });
        </script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
            var api_path = "<?php echo $api_path; ?>";
           function paymentDetails() {
            var bank_name=$("#bank_name").val();
            var bank_code=$("#bank_code").val();
            var account_number=$("#account_number").val();
            var holder_name=$("#holder_name").val();
            var gpay=$("#pay").val();
            var paytm=$("#paytm").val();
            var datas={
                'dashboard_code': verfication_code,
                'distributor_token': distributor_token,
                'bank_name':bank_name,
                "bank_code":bank_code,
                "account_number":account_number,
                "holder_name":holder_name,
                "gpay":gpay,
                "paytm":paytm
            };
            var json_data=JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/payment_bank.php",
                    data: json_data,
                }).done(function(data) {
                    console.log(data);
                    if(data.code=="200"){
                        swal("Payment Details Added Successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                        $('.primary-btn').hide();
                        $('.payment--dedails').show();
                    });
                    }else{
                        $('#update_button').prop('disabled', false);
                        swal(data.message);
                    }
                })
            }
            $(document).ready(function(){
                var datas={
               'distributor_token': distributor_token
            };
            var json_data=JSON.stringify(datas);
            //console.log(json_data);
            $.ajax({
                    type: "POST",
                    url: api_path + "/distributor/selectPaymentDetails.php",
                    dataType : "json",
                    data: json_data,
                    success: success,
                });
            });

            var table_data;

            function success(data) {
                table_data = data;
                for(key in table_data){
                var html_text = "";
                    html_text += '<tr>';
                    html_text += '<td><span class="light_color">Bank Name : ' + table_data[key].bank_name + '</span></td>';
                    html_text += '</tr>';
                    html_text += '<tr>';
                    html_text += '<td><span class="light_color">Account Number : ' + table_data[key].account_number + '</span></td>';
                    html_text += '</tr>';
                    html_text += '<tr>';
                    html_text += '<td><span class="light_color">Bank Code : ' + table_data[key].bank_code + '</span></td>';
                    html_text += '</tr>';
                    html_text += '<tr>';
                    html_text += '<td><span class="light_color">Holder Name : ' + table_data[key].holder_name + '</span></td>';
                    html_text += '</tr>';
                    html_text += '<tr>';
                    html_text += '<td><button class="edite_btn mt-3" data-toggle="modal" data-target="#edit_form"  onclick="edit_payment('+key+')" >Edit</button></td>';
                    html_text += '</tr>';

                $("#paymentBank").html(html_text);
                $(".se-pre-con").hide();
                setTimeout(() => {
                    $('.primary-btn').hide();
                }, 35);

                var html_text1 = "";
                    html_text1 += '<tr>';
                    html_text1 += '<td><span class="light_color">Gpay number : ' + table_data[key].gpay + '</span></td>';
                    html_text1 += '</tr>';
                    html_text1 += '<tr>';
                    html_text1 += '<td><span class="light_color">Paytm Number : ' + table_data[key].paytm + '</span></td>';
                    html_text1 += '</tr>';
                $("#PaymentUPI").html(html_text1);
                $(".se-pre-con").hide();
                }  
                
            }
            function edit_payment(key){
            $("#edit_bank_name").val(table_data[key].bank_name);
            $("#edit_bank_code").val(table_data[key].bank_code);
            $("#edit_account_number").val(table_data[key].account_number);
            $("#edit_holder_name").val(table_data[key].holder_name);
            $("#edit_pay").val(table_data[key].gpay);
            $("#edit_paytm").val(table_data[key].paytm);
            }
            function editpaymentDetails(){
            var bank_name=$("#edit_bank_name").val();
            var bank_code=$("#edit_bank_code").val();
            var account_number=$("#edit_account_number").val();
            var holder_name=$("#edit_holder_name").val();
            var gpay=$("#edit_pay").val();
            var paytm=$("#edit_paytm").val();
            var datas={
                'dashboard_code': verfication_code,
                'distributor_token': distributor_token,
                'bank_name':bank_name,
                "bank_code":bank_code,
                "account_number":account_number,
                "holder_name":holder_name,
                "gpay":gpay,
                "paytm":paytm
            };
            var json_data=JSON.stringify(datas);
           console.log(json_data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/editpayment_bank.php",
                    data: json_data,
                }).done(function(data) {
                    console.log(data);
            if(data.code=="200"){
                 swal("Payment Details Added Successfully!", {icon: "success",}).then((value) => {
                location.reload();
            });
            }else{
                $('#update_button').prop('disabled', false);
                swal(data.message);
            }
                })
            }
            
    </script>

    </body>

    </html>
<?php
}
?>