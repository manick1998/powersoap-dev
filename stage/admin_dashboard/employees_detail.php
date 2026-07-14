<?php
include "config.php";
include "$api_path/config/core.php";
if ($cookie_admin_name == "") {
    header("Location:login.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Power Soaps </title>
        <link rel="shortcut icon" href="assets/favi.png">
        <link rel="stylesheet" href="css/bootstrap-select.min.css<?php echo $js_cache_string; ?>">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">-->
<!--           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">-->
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/employee.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    </head>
    <style>
        a {
            cursor: pointer;
        }

        select {
            appearance: none;
            outline: none;
            background: url(assets/down-arrow.png) no-repeat;
            background-size: 16px;
            background-position: 96% 50%;
            cursor: pointer;
        }

        .selection .select2-selection--multiple {
            border: 1px solid #ced4da;
        }

        .select2-search__field {
            width: 663px !important;
        }

        span#mandatory_icon {
            color: red;
        }
        .custom-table tbody tr td button{
            padding: 6px 18px;
            color: #fff;
            background: #00b9f6;
            border-radius: 4px;
            border: none;
        }
        .reupload{
            color: #00b9f5;
            cursor: pointer;
        }
        .pdf-btn {
            background: #bc87f0 !important;
            padding: 6px 15px;
            border-radius: 4px;
        }
        .attach_img iframe {
            border: 1px solid #ccc;
            margin: 5px;
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
        /* .lb-data .lb-close {
            position: absolute;
            top: -31px;
            transform: translateX(32rem);
        } */
/*
        .imageViewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.8);
            overflow: hidden;
            z-index: 99999;
        }
        .viewer-close__icon {
            position: absolute;
            right: 32px;
            top: 32px;
            width: 32px;
            cursor: pointer;
        }
        .image__container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        .image__container img {
            max-width: 80%;
            max-height: 80%;
        }
*/
        @media only screen and (max-width:1600px) {
            #table_data_wrapper .row:nth-child(2) .col-sm-12 {
                display: block;
            }
            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar {
                display: block;
                background-color: #000;
                height: 4px;
                border-radius: 16px;
            }
            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar-thumb {
                background-color: #232a77;
            }

            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar-track {
                background-color: #cacaca;
            }
        }
    </style>

    <body class = "bodytoken" data-token = "<?php echo $_POST['usertoken'] ?>">
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar44"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height twoback" id="employee_view" >
                <div class="header_container mrgzro">
                    <div class="header-section sep_word">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_employee()" alt=""></span></h1>
                        <input id="update_status_token" type="hidden">
                        <div class="de_activate"></div>
                            <input type="hidden" id="hidedate" value="">
                        
                    </div>
                    <div class="add_new_top bot_line">
                        <div class="col-md-2">
                            <div class="upload_files">
                                <img class="uploadimgs" id="single_employee_view_image" alt="" src="">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 class="name_box" id="single_employee_name"></h2>
                            <div class="row">
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Department : <span id="single_employee_department">kjbkhbsdf</span></p>
                                        <p>Joining Date : <span id="single_employee_join_date">kjbkfbs</span></p>
                                        <p>State : <span id="single_employee_state">kjbskf</span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Distributor Code : <span id="single_employee_code"></span></p>
                                        <p>Mobile Number : <span id="single_employee_number"></span></p>
                                        <p>GST Number: <span id="single_employee_licenseNumber"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Email Address : <span id="single_employee_email"></span></p>
                                        <p>Region : <span id="single_employee_region"></span></p>
                                        <p>Area : <span id="single_employee_area"></span></p>
                                    </div>
                                </div>
                                <div>
                                    <p>Division : </p>
                                    <ol id="single_employee_division_name" style="list-style-position: inside;"></ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="address_field">
                        <div class="col-md-8">
                            <div class="address_note">
                                <h2>Address :</h2>
                                <p id="single_employee_address"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img class="pancard" style="max-width: 100px;" id="single_employee_address_proof_img" alt="" src="">
                            <iframe class="uploadimg1" id="single_employee_address_proof_pdf" frameborder="0"></iframe>
                        </div>
                    </div>
                    <div class="attach">
                        <div class="col-md-12">
                            <h2>Other Attachments :</h2>
                            <div class="attach_img" id="single_other_attachement">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
<!--
        <div class="imageViewer" style="display: flex;">
            <img src="asset/choose-service/close.svg" class="viewer-close__icon" alt="close icon">
            <div class="image__container">
                <img src="https://d1kbhg7ykrtfl2.cloudfront.net/firebase_image/202308241420538.jpg" alt="chat image" id="chat-image">
            </div>
        </div>
-->
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Upload CSV File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <label class="upload_filed" for="file_csv">
                                <input type="file" id="file_csv" accept="application/pdf" hidden>
                                <img alt="" src="assets/csvfile.png" class="csvfile">
                                <h2>Upload Files</h2>
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                        <button type="button" class="savebtn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <form class = "orangeline" id= "formsend" action="stocks.php" method="post">



        </form> -->
        
        <!-- Modal -->
        <div id="myModalImages" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="fileContent"></div>
<!--
                        <embed src="~/Content/Article List.pdf"
                               frameborder="0" width="100%" height="400px">
-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="samples">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sampe CSV File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <label class="upload_filed" for="file_csv">
                                <input type="file" id="file_csv" accept="application/pdf" hidden>
                                <img alt="" src="assets/csvfile.png" class="csvfile">
                                <h2>Upload Files</h2>
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>

<!--            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>-->
        <!-- datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> -->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="js/select2.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script>
            // var pdfjsLib = window['pdfjs-dist/build/pdf'];
            // pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>
        <script>
        
             $('#add_employee_joindate').datepicker({
                 autoclose: true,
                 todayHighlight: true,
                 maxDate: new Date(),
                 changeYear: true,
                 yearRange: '1970:2060',
                 defaultDate: 'today'
             });
             $('#edit_employee_joindate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: new Date(),
                changeYear: true,
                yearRange: '1970:2060',
                defaultDate: 'today'
             });

            function show_employee() {
                $('#employee_add').show();
                $('#employee').hide();
            }

            function back_view_employee() {
                window.location ="employees.php";
            }

            function back_add_employee() {
                $('#employee').show();
                $('#employee_add').hide();
            }

            function back_edit_employee() {
                $('#employee').show();
                $('#employee_edit').hide();
            }
        </script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            $(document).ready(function() {

                let distributorToken = $(".bodytoken").attr("data-token");
                console.log("distri",distributorToken);
                localStorage.setItem("distributor_token", distributorToken);
                view_employee(distributorToken);
            });

            // $(document).ready(function(){
            //     $(".orangeline").click(function(e){
            //         e.preventDeafualt();
            //         alert(distributorToken);
            //     //     $("#formsend").append(`<input type="hidden" name="usertoken" value="${distributorToken}" >`);
            //     // $(".orangeline").submit();
            //     });
            // });

            
            //select view
            function view_employee(token) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single",
                    employee_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/employeeDetails.php",
                    data: json_data,
                }).done(function(data) {
                    console.log(data);
                    var emp_data = data.data;
                    $("#single_employee_name").html(emp_data[0].employee_name);
                    $("#single_employee_department").html(emp_data[0].employee_deparment_name);
                    $("#single_employee_join_date").html(emp_data[0].employee_join_date);
                    $("#single_employee_state").html(emp_data[0].state_name);
                    $("#single_employee_number").html(emp_data[0].employee_mobile_number);
                    $("#single_employee_code").html(emp_data[0].employee_code);
                    $("#single_employee_email").html(emp_data[0].employee_email_id);
                    $("#single_employee_licenseNumber").html(emp_data[0].employee_license_number);
                    $("#single_employee_region").html(emp_data[0].employee_region_name);
                    $("#single_employee_area").html(emp_data[0].employee_area_name);
                    $("#single_employee_address").html(emp_data[0].employee_address_full);
                    $("#single_employee_view_image").attr("src", emp_data[0].profile_image);
                    var imageURL = emp_data[0].employee_address_proof;
                    var extension = imageURL.split(".").pop();
                    if(extension == 'pdf'){
                         $("#single_employee_address_proof_img").attr("src", "");
                         $("#single_employee_address_proof_img").css("display", "none");
                         $("#single_employee_address_proof_pdf").css("display", "block");
                         $("#single_employee_address_proof_pdf").attr("src", emp_data[0].employee_address_proof); 
                    }else{
                         $("#single_employee_address_proof_pdf").attr("src", "");
                         $("#single_employee_address_proof_pdf").css("display", "none");
                         $("#single_employee_address_proof_img").css("display", "block");
                         $("#single_employee_address_proof_img").attr("src", emp_data[0].employee_address_proof); 
                    }
                    li_html = '';
                    var division_name1 = emp_data[0].division_name;
                    var division_token = emp_data[0].employee_division;
                    console.log('division_token',division_token);
                    $("#hidedate").val(division_token);
                    for (var key2 in division_name1) {
                        li_html += '<li>' + division_name1[key2] + '</li>';
                    }
                    $("#single_employee_division_name").html(li_html);
                    var html = "";
                    var attachement_data = emp_data[0].employee_attachment;
                    for (var key1 in attachement_data) {
                        var attachImageUrl = attachement_data[key1].attachment
                        var attachImgExten = attachImageUrl.split(".").pop();
                        if(attachImgExten == 'pdf'){
                             html += '<iframe class="uploadimg1" src="'+ attachement_data[key1].attachment +'" frameborder="0"></iframe><span onclick="viewFile(\''+ attachement_data[key1].attachment +'\')">View PDF</span>';
                        }else{
                             html += '<img onclick="viewFile(\''+ attachement_data[key1].attachment +'\')" src="' + attachement_data[key1].attachment + '" alt="a">';
                            //  <div class="item"><a href="' + attachement_data[key1].attachment + '" data-lightbox="photos"><img class="img-fluid" src="' + attachement_data[key1].attachment + '"></a></div>
                        }
                    }
                    $("#update_status_token").val(token);
                    if (emp_data[0].block_status == 1) {
                        $(".de_activate").html('<a class="view_link" onclick="deactivate()">Deactivate Distributor</a>');
                        $(".de_activate > a").css('color', 'red');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    } else {
                        $(".de_activate").html('<a class="view_link" onclick="activate()">Activate Distributor</a>');
                        $(".de_activate > a").css('color', 'green');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    }
                    $("#single_other_attachement").html(html);
                    $('#employee_view').show();
                    $('#employee').hide();
                    $(".se-pre-con").hide();
                });
            }

//             //deactivate

            function deactivate(key) {
                var token = $("#update_status_token").val();
                var name = $("#single_employee_name").html();
                var mobile_numbr = $("#single_employee_number").html();
                var gmail = $("#single_employee_email").html();
                var licens = $("#single_employee_licenseNumber").html();
                var division_token1 = $("#hidedate").val();
                var division_token =  division_token1.split(',')
                console.log('division_token',division_token);
                
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this employee?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'employee_token': token,
                            'name':name,
                            'mobile_numbr':mobile_numbr,
                            'gmail':gmail,
                            'licens':licens,
                            'division_token':division_token,
                            'admin_token':admin_token,
                            'employee_status': 2,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        console.log('json_data',json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Distributor deactivated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    view_employee(token);
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }

            //activate
            function activate() {
                var token = $("#update_status_token").val();
                var name = $("#single_employee_name").html();
                var mobile_numbr = $("#single_employee_number").html();
                var gmail = $("#single_employee_email").html();
                var licens = $("#single_employee_licenseNumber").html();
                var division_token1 = $("#hidedate").val();
                var division_token =  division_token1.split(',')
                console.log('division_token',division_token);
                swal({
                    title: "Are you sure?",
                    text: "You want to activate this employee?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'employee_token': token,
                            'name':name,
                            'mobile_numbr':mobile_numbr,
                            'gmail':gmail,
                            'licens':licens,
                            'division_token':division_token,
                            'admin_token':admin_token,
                            'employee_status': 1,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Distributor activated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    view_employee(token);
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }
            
            function viewFile(fileSrc){
                fileExtension = fileSrc.split('.').pop();
                if(fileExtension == 'pdf'){
                   $("#fileContent").html(`<embed src="${fileSrc}"
                               frameborder="0" width="100%" height="400px">`);
                    $("#myModalImages").modal('show');
                }else{
                    $("#fileContent").html(`<embed src="${fileSrc}"
                               frameborder="0" width="100%" height="400px">`); 
                    $("#myModalImages").modal('show');
                }
            }
            
        // Image Viewer from Chat Box
//            const chatBody = document.querySelector('.chat-body');
//            const imageViewer = document.querySelector('.imageViewer');
//            const imageViewerClose = document.querySelector('.viewer-close__icon');
//            let uploadedChatImage;
//            chatBody.addEventListener('click', function(e) {
//                const clickedImgBox = e.target.closest('.attachments_img-box');
//                if(clickedImgBox) {
//                    const chatImage = document.getElementById('chat-image');
//                    uploadedChatImage = e.srcElement;
//
//                    chatImage.src = uploadedChatImage.src;
//                    imageViewer.style.display = "flex";
//                }
//            });
//            imageViewerClose.addEventListener('click', function() {
//                imageViewer.style.display = "none";
//            });

        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>