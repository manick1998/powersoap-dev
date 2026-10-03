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
    <title>Power Soap | Notification List</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/notification_list.css<?php echo $js_cache_string; ?>">

    <style>
        .custom-table tbody tr td {
            white-space:none;
        }
        .form__label {
            color: #333;
        }
        div.dataTables_wrapper div.dataTables_filter {
            text-align: left;
            float: right;
        }
        .dataTables_filter label {
            top: 20px;
        }
        #State_id {
            width: 100%;
            /* max-width: 320px; */
            height: 120px; /* Gives enough room to see multiple rows */
            padding: 8px;
            font-weight: 600;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 15px;
            color: #1f2937;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            }

            /* Focused active state */
            #State_id:focus {
            border-color: #04bcf4; /* Modern Purple/Blue focus ring */
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            }

            /* Individual list options styling */
            #State_id option {
            padding: 8px 12px;
            margin-bottom: 2px;
            border-radius: 6px;
            cursor: pointer;
            text-transform: capitalize; /* Forces 'tamil nadu' to show as 'Tamil Nadu' */
            transition: background-color 0.15s, color 0.15s;
            }

            /* Hover state for options */
            #State_id option:hover {
            background-color: #f3f4f6;
            }

            /* Highlight color for selected items */
            #State_id option:checked {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
            }
    </style>
</head>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <div class="se-pre-con"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar11"></div> 
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle5" >
            <div class="product_header_container">
                <div class="header-details ">
                        <h1 class="header_main">Notification List</h1>
                        <p class="table_count notify">Total Notification - <span id="project_count"></span></p>
                </div> 
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="dialog">
                <li class="nav-item " role="presentation">
                <button onclick="" class="nav-link active" id="" data-toggle="modal" data-target="#NotifyPop" type="button" role="btn" aria-controls="NotifyPop" aria-selected="true">Create Notification</button>
                </li>
            </ul>
            <div class="tab-content" id="" >
                <div class="tab-pane active fade show" id="" role="" aria-labelledby="">
                    <table class="custom-table" id="dataTables_filter21">
                        <thead>
                            <tr>
                                <th>SI.No</th>
                                <th>Notification Title</th>
                                <th>Description</th>
                                <th>For State</th>
                                <th>Created Date</th>
                                <th>Created Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_notification">
                         
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="notification_create_box">
            <!-- Modal -->
                <div class="modal fade" id="NotifyPop" tabindex="-1" role="dialog" aria-labelledby="NotifyPopModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered notifi-dialog-modal" role="document">
                    <div class="modal-content notifi-modal-content">
                        <div class="notifi-modal-header">
                        <h5 class="notfi-modal-title" id="exampleModalLongTitle">New Notification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="notify-close" aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">

                            <div class="modal-notify-body">
                                <div class="form__detail notify-form">
                                    <input type="text" id="notification_title" class="form__input" placeholder=" ">
                                    <label for="user_email" class="form__label">Notification Title</label>
                                </div>

                                <div class="form__detail notify-form">
                                    <!-- <label for="user_email" class="form__label">Notification Title</label> -->
                                    <select id="State_id" multiple></select>
                                </div>

                                <div class="form__detail notify-form notify-textarea">
                                    <textarea class="form__input notify-input" id="notification_content" name="usrtxt" wrap="hard"></textarea>
                                    <label for="NfnMsg" class="form__label">Message</label>
                                </div>
                               
                            </div>
                        
                        </div>
                        <div class="modal-footer modal-notify-footer">
                        <button type="button" class="notify-cancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn-create" id="notification_button" onclick="createNotification()">Create</button>
                        </div>
                    </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    </script>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script>
          var verfication_code = "<?php echo $verification_code; ?>";
          var api_path = "<?php echo $api_path; ?>";
       
        /* Radion button box */ 
        $('.ratio-btn-selecter').on('click',function(){
            var quickcheck = $(this).attr('data-value');
           if(quickcheck == "image"){
               $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
               $('.popup-image-box').removeClass('hidden');
               $('.popup-video-box').addClass('hidden');
           }
           else{
              $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
              $('.popup-image-box ').addClass('hidden');
               $('.popup-video-box').removeClass('hidden');
           }
        });

        document.getElementById('State_id').onmousedown = function(e) {
            e.preventDefault();
            var scroll = this.scrollTop;
            e.target.selected = !e.target.selected;
            this.focus();
            setTimeout(() => { this.scrollTop = scroll; }, 0);
        };
        
        $(document).ready(function(){
            var datas1 = {
                'dashboard_code':verfication_code,
                   'type':'selectAll_notify'
            }
            var json_data1 = JSON.stringify(datas1);
            $.ajax({
                type: "POST",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                url: api_path+"/admin/notification.php", 
                data: json_data1,
                success: success
            });
        });
        var notify_data;
        var table;
        function success(data){
          notify_data = data.data;
         var notify_data1 = data.state_data;
          html_text = '';
          html_text1 = '';
          slno = 0;    
          for(var key in notify_data){
              slno++;
               html_text += '<tr>';
                  html_text += '<td>'+slno+'</td>';
                  html_text += '<td>'+notify_data[key].notification_title+'</td>';
                  html_text += '<td>'+notify_data[key].notification_description+'</td>';
                  html_text += '<td>'+(notify_data[key].state_name == null ? '-' : notify_data[key].state_name)+'</td>';
                  html_text += '<td>'+notify_data[key].onlyDate+'</td>';
                  html_text += '<td>'+notify_data[key].onlyTime+'</td>';
                  html_text += '<td class="notify_Delete" onclick="deleteNotification('+notify_data[key].notification_token+')">Delete</td>';
               html_text += '</tr> ';
            }
            notify_data1.forEach(function(key,value){
                html_text1 += `<option value=${key.state_id}>${key.state_name}</option>`;
            });
            $("#State_id").html(html_text1);
            $("#table_body_notification").html(html_text);
            $("#project_count").text(slno);
            table = $("#dataTables_filter21").DataTable({
                dom: 'Bfrltip',
                pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                buttons: [
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                        }
                }
            });
            $(".se-pre-con").hide();
        }
        
        // function createNotification(){
        //   var noti_title = $("#notification_title").val();
        //   var noti_content = $("#notification_content").val();
        //     if(noti_title != '' && noti_content != ''){
        //         $("#notification_button").prop("disabled", true);
        //         $("#NotifyPop").modal('hide');
        //        var datas = {
        //            'noti_title': noti_title,
        //            'noti_content': noti_content,
        //            'dashboard_code': verfication_code,
        //            'type': 'create_new_notify'
        //        };
        //        var json_data = JSON.stringify(datas);      
        //         $.ajax({
        //            type: "POST",
        //            dataType: "json",
        //            contentType: "application/json; charset=utf-8",
        //            url: api_path+"/admin/notification.php", 
        //            data: json_data    
        //         }).done(function(data){
        //            if(data.code=="201"){
        //                 swal("Notification Created successfully!", {icon: "success"}).then((value) => {
        //                     location.reload();
        //                 });
        //             }else{
        //                 $('#notification_button').prop('disabled', false);
        //                 swal(data.message);
        //             } 
        //         });
        //     }else{
        //         swal('Please Enter the Details in Notification!');
        //     }
        // }


        function createNotification(){
          var noti_title = $("#notification_title").val();
          var noti_content = $("#notification_content").val();
          var state_id = $("#State_id").val();
          
          
            if(noti_title != '' && noti_content != ''){
                $("#notification_button").prop("disabled", true);
                $("#NotifyPop").modal('hide');
               var datas = {
                    'type': 'create_new_notify',
                   'noti_title': noti_title,
                   'noti_content': noti_content,
                   'dashboard_code': verfication_code,
                   'state_id':state_id
               };
               var json_data = JSON.stringify(datas);      
               console.log(json_data);
               
                $.ajax({
                   type: "POST",
                   dataType: "json",
                   contentType: "application/json; charset=utf-8",
                   url: api_path+"/admin/notification.php", 
                   data: json_data    
                }).done(function(data){
                   if(data.code=="201"){
                        swal({
                            title: "Notification Created successfully!",
                            text: "Do you want to share this message on WhatsApp?",
                            icon: "success",
                            buttons: ["No, Thanks", "Share to WhatsApp"],
                        }).then((willShare) => {
                            if (willShare) {
                                var whatsappMessage = "*" + noti_title + "*\n\n" + noti_content;
                                var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(whatsappMessage);
                                window.open(whatsappUrl, '_blank');
                            }
                            location.reload();
                        });
                    }else{
                        $('#notification_button').prop('disabled', false);
                        swal(data.message);
                    } 
                });
            }else{
                swal('Please Enter the Details in Notification!');
            }
        }
        
        function deleteNotification(token){
            var noti_id = token;
              swal({
                    title: "Are you sure?",
                    text: "You want to delete notification?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
               if (willDelete) {
                var datas = {
                       dashboard_code: verfication_code,
                       notification_token: noti_id,
                       type: 'delete_notify'
                   };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    url : api_path+"/admin/notification.php", 
                    data: json_data
                }).done(function(data) {
                    swal("Notification Deleted successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                });
               }
            });
        }
    </script>
</body>
</html>
<?php
}
mysqli_close($link);
?>