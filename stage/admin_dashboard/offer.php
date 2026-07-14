<?php
    include "config.php";
    include "$api_path/config/core.php";
    if($cookie_admin_name ==""){
        header("Location:login.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Soap | Offer</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    <style>
        .form-control {
            margin: 20px 0;
        }
        .form-control p {
            margin: 0;
            color: #798893;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            text-align:left;
        }
        .input-field {
            border: none;
            color: #333;
            width: 100%;
            font-size: 16px;
            line-height: 20px;
            outline:none;
        }
        .delete-cls{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="se-pre-con" style="display: block;"></div>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar7"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div>
                    <h1 class="header_main">Offer List </h1>
                    <span class="table_count">Total Offer - <span id="total_offer_count"></span></span>
                    <div class="cred-btn-box">
                        <button class="primary-btn" data-toggle="modal" data-target="#exampleModal">Add Offer</button>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Offer Name</th>
                            <th>State_Name</th>
                            <th>Division</th>
                            <th>Offer</th>
                            <th>Minimum Purchase amount</th>
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add Offer</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="banner-option-box">
                            <div class="popup-image-box">
                                <div class="form-control offer_name_box">
                                    <p for="offer_name" class="input-field offer_name">Offer Name</p>
                                    <input type="text" class="input-field" id="offer_name" required placeholder="Please Enter Offer Name">
                                </div>
                                <div class="form-control offer_division_box">
                                    <p for="offer_division" class="input-field offer_division">Division</p>
                                    <select class="input-field" id="offer_division">
                                    </select>
                                </div>
                                <div class="form-control offer_state">
                                    <p for="offer_state" class="input-field offer_division">State</p>
                                    <select class="input-field" id="offer_state">
                                    </select>
                                </div>
                                <div class="form-control offer_percentage_box">
                                    <p for="offer_percentage" class="input-field offer_percentage">Offer Percentage</p>
                                    <input type="text" id="offer_percentage" class="input-field floatonly" placeholder="Please Enter offer value" maxlength="4">
                                </div> 
                                <div class="form-control purchase_amount_box">
                                    <p for="purchase_amount" class="input-field purchase_amount">Purchase Amount</p>
                                    <input type="text" id="purchase_amount" class="input-field floatonly" placeholder="Please Enter minimum purchase amount" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button class="create-btn" id="add_offer_button" onclick="add_offer()">Create</button>
                </div>
            </div>
        </div>
    </div>
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var gl_admin_token = "<?php echo $token; ?>";
</script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<!--    datepicker-->
<!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
<script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
<!-- jquery CDN -->
<script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
<!-- datatable -->
<script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
<script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
<!-- js file -->
<script src="js/header.js<?php echo $js_cache_string; ?>"></script>
<script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
<script src="js/select.js<?php echo $js_cache_string; ?>"></script>
<script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
<script>
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var admin_state_id = "<?php echo $cookie_admin_state; ?>";
   
    var table;
    $(document).ready(function () {
        console.log("jjjjjjjj",admin_state_id);
        var datas = {
            dashboard_code: verfication_code,
            type: "count_check"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/offerDetails.php",
            data: json_data,
        }).done(function(datas) {
            var count = datas.Count;
            $("#total_offer_count").html(numberWithCommas(count));
        });
        var datas = {
            dashboard_code: verfication_code,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/singleDivisionDetails.php",
            data: json_data,
        }).done(function(datas) {
            console.log("hello",datas);
            var data = datas.data;
            var html_text = '<option value="">Select Division</option>';                
            for (var key in data) {
                 html_text+= '<option value="'+data[key].division_token+'">'+data[key].division_name+'</option>';
            }
            $("#offer_division").html(html_text);
        });
    });
    $(document).ready(function () {
        $(".se-pre-con").hide();
        table = $('#table_data').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 6 ] }, 
            ],
            'ajax': {'url':api_path+"/admin/serverOfferList.php?v_id="+verfication_code+"&&state_id="+admin_state_id},
            "order": [[0, "DESC" ]],
            'columns': [
                { data: 'token' },
                { data: 'name' },
                {data: 'state_name'},
                { data: 'division' },
                { data: 'offer' },
                { data: 'amount' },
                { data: 'date' },
                { data: 'action' }
            ],
            // dom: 'Bfrltip',
            pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10,25,100,500,1000,5000,10000,100000],
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
            }
        });
        table.column(0).visible(false);
        //$('.dataTables_length').css("display","none");
    });
    function add_offer(){
        var offer_name      = $("#offer_name").val();
        var val1            = value_check('offer_name',offer_name,'text_box');
        var offer_state     =$("#offer_state").val();
        var val2           = value_check('offer_state',offer_state,'text_box');
        var offer_division  = $("#offer_division").val();
        var val3            = value_check('offer_division',offer_division,'text_box');
        var offer_percentage= $("#offer_percentage").val();
        var val4            = value_check('offer_percentage',offer_percentage,'text_box');
        var purchase_amount = $("#purchase_amount").val();
        var val5            = value_check('purchase_amount',purchase_amount,'text_box');
        if(val1==true && val2==true && val3==true && val4==true && val5==true){
            $('#add_offer_button').prop('disabled', true);
            setTimeout(function () {  
                $(".se-pre-con").show();
            }, 5);
            var datas ={
                'offer_name':offer_name,
                'offer_state':offer_state,
                'offer_division':offer_division,
                'offer_percentage':offer_percentage,
                'purchase_amount':purchase_amount,
                'dashboard_code':verfication_code,
                'admin_token':gl_admin_token
            }
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/addOffer.php",
                data: json_data,
            }).done(function(data) {
                $(".se-pre-con").hide();
                if(data.code=="201"){
                    swal("Offer added successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                }else{
                    $('#add_offer_button').prop('disabled', false);
                    swal(data.message);
                }
            });   
        }else{
            swal("Please enter all details!");
        }
    }
    $('#table_data tbody').on( 'click', '.delete-cls', function () {
        var td_div = $(this).parent().parent();
        var table_data = table.row( td_div ).data();
        var token = table_data.token;
        swal({
            title: "Are you sure?",
            text: "You want to delete this offer?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".se-pre-con").show();
                var datas ={
                    'token':token,
                    'type':"delete",
                    'dashboard_code':verfication_code,
                    'admin_token':gl_admin_token
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url : api_path+"/admin/offerDetails.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if(data.code==503){
                        swal("Something happened!");
                    }else if(data.code==201){
                        swal("Offer deleted successfully!", {icon: "success",}).then((value) => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
    // state option
    $(document).ready(function(){
                //get option
                var datas={
                    'state_id':admin_state_id     
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                
                $.ajax({
                    type: "POST",
                    url: api_path + "/admin/state_list.php",
                    dataType: "json",
                    data: json_data,
                    success: function(response) {
                        console.log("haii",response);
                        let options = "";
                                options += `<option value="" >Select State</option>`;
                            response.forEach(function(item, index) {
                                options += `<option value="${item.state_token}" >${item.state_name}</option>`;
                            });
                        $("#offer_state").html(options); 
                    }
                });
            });
</script>
</body>
</html>
<?php
}
mysqli_close($link);
?>