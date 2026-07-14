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
        
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/support.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    </head>
    <style>
        /* new */
        .atach_img {
            /* display: flex; */
            max-width: 383px;
            overflow: hidden;
            gap: 3px;
            overflow-x: scroll;
        }
        .atach_img img {
            width: 200px;
            cursor: pointer;
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)} 
            to {-webkit-transform:scale(1)}
        }
        @keyframes zoom {
            from {transform:scale(0)} 
            to {transform:scale(1)}
        }
        .select__status {
            outline: none;
            padding: 6px;
            border-radius: 2px;
            width: 107px;
            border: 1px solid #11a14a;
            background-color: #11a14a;
            color: #fff;
            background-image: url(assets/Down--Arrow@2x.svg)  !important;
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: 96% 50%;
            
        }
        .custom-file {
            display: block;
            width: 180px;
            height: 40px;
            border: #00b9f5 1px solid;
            color: #00b9f5;
            border-radius: 4px;
                margin: 4px 0px
        }
        .custom-file h5 {
            text-align: center;
            line-height: 35px;
            font-size: 18px;
            
        }
        .custom-file span {
            padding-top: 20px;
        }
        .custom-textarea {
            height: 207px;
            border: none;
            width: 100%;
            box-sizing: border-box;
            resize: none;
            padding: 12px;
            border-radius: 12px;
        }
        .custom-boxss {
            border: 1px solid #6f6e6e8f;
            position: relative;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .custom-boxss label {
            position: absolute;
            top: -8px;
            left: 9px;
            font-size: 13px;
            background: #fff;
            color:#9ca9bb;
        }
        .span{
            color: #787878;
        }
        .controler__box_set {
            padding: 23px 71px;
        }
        a {
            cursor: pointer;
        }
        .main-contents {
            width: calc(100% - 300px);
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

        .custom-nav{
            border-bottom: 1px solid #D9D9D9;
            display:flex;
            align-items: center;
            flex-wrap: nowrap;
            white-space: nowrap;
            /* overflow: auto; */
        }

        .scrollbar {	
            overflow-x: scroll;
        }
        
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 0;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar
        {
            height: 10px;
            background-color: #F5F5F5;
            display: block !important;
        }

        #style-1::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #c9c9c9;
        }
        .custom-nav__item{
            padding: 8px 6px;
            border-bottom:1px solid transparent;
            cursor: pointer;
            color: var(--light-gray);
            font: 15px var(--medium-font);
        }
        .custom-nav__item:hover {
            background-color: #f3f7fa;
        }
        .custom-nav__item a {
            padding: 7px 15px;
            color: #000;
            text-transform: capitalize;
        }
        .custom-nav__item a.active {
            background-color: #f3f7fa;
            border-bottom: 2px solid #04bcf4;
        }
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
        .floatonly {
            padding: 10px;
            width: 100%;
            border: 1px solid #aeaeae;
            border-radius: 5px;
        }
        p.input-field.admin_mobilenumber {
            margin-bottom: 7px;
        }

        #divLargerImage {
            display: none;
            width: 500px;
            height: 500px;
            position: absolute;
            top: 35%;
            left: 35%;
            z-index: 99;
        }

        #divOverlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #CCC;
            opacity: 0.5;
            width: 100%;
            height: 100%;
            z-index: 98;
        }
        @media only screen and (max-width:1200px) {
            .main-contents {
                width: calc(100% - 60px);
            }
        }
    </style>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar18"></div>
        <!-- main-contents //id="style-1"-->
        <main class="main-contents">
            <!-- <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;">
            <div class="scrollbar" id="style-1">
                <ul class="custom-nav nav nav-pills statewise force-overflow">
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="active show">Tamil Nadu</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Kerala</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Andthra</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Mumbai</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Mumbai</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Mumbai</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Andthra</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Andthra</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Andthra</a></li>
                    <li class="custom-nav__item"><a href="#" data-toggle="tab" class="">Andthra</a></li>
                </ul>

            </div>
            </section> -->
            <!-- tab method -->
            <div class="tab-content clearfix" id="employee">

                <div class="tab-pane active" id="state1">
                    <section class="bg-white brad-4 full-height" >
                        <div class="product_header_container">
                            <div class="header-details ">
                            <h1 class="header_main"><span class="twoinspace">Support Log</span></h1>
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <!-- <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button  class="empshow nav-link active"  type="button" data-toggle="modal" data-target="#myModal">Create Ticket</button>
                            </li> -->
                            
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                                <div id="divLargerImage"></div>
                                <div id="divOverlay"></div>
                            <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                            <th>User</th>
                                            <th>Date & Time</th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody id='problam_table'>
                                        
                                       
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                
        </div>


        </main>
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Create Ticket</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body controler__box_set">
                        <div class="row">
                            <div class="custom-boxss">
                               <label for="description">Description:</label>
                              <textarea id="description" name="description" class="custom-textarea" placeholder="250 Letters Only"></textarea>
                              
                            </div>
                            <div style="width: 100%;">
                                <p for="purchase_amount" class="input-field admin_mobilenumber">Phone Number</p>
                                <input type="text" id="admin_mobilenumber" class="input-field floatonly" placeholder="Please Enter Phone Number" maxlength="10">
                            </div>
                        </div>
                        <p style="margin: 0;     margin-top: 9px;" class="Attac">Attachment</p>
                        <label for="support_image_upload" style="text-align: start;">
                            <div class="custom-file">
                                <input id="support_image_valid" type="hidden" value="">    
                                <input id="support_image_upload" onchange="file_upload_support('support_image','support_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                <h5><span><img id='img' class="fa-upload" src="assets/upload_image_arrow_icon.png"></span> Upload Image</h5>
                            </div>
                            <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="support_view_image_url"/>
                            <span>Image format should be in jpg/png/</span>
                        </label>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="add_issue()" class="create-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
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
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
        <script src="js/select2.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
        <script>
            // var pdfjsLib = window['pdfjs-dist/build/pdf'];
            // pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>
        <script>

const options = {
	keyboard: true,
	size: 'sm'
};

document.querySelectorAll('.my-lightbox-toggle').forEach((el) => el.addEventListener('click', (e) => {
	e.preventDefault();
	const lightbox = new Lightbox(el, options);
	lightbox.show();
}));
        </script>
        
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            $(".se-pre-con").hide();
            var data = {
                type :'support_log'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                type:"POST",
                dataType : 'json',
                url : api_path +"/admin/log.php",
                data:json_data,
            }).done(function(data){
                var html = '';
                data.data.forEach(function(item,index){
                    html += `<tr>`
                    html +=     `<td> ${item.employees_name == null ? "Admin":item.employees_name}</td>`
                    html +=`<td> ${item.deparment_name}</td>`
                    html +=`<td> ${item.description}</td>`
                    if (item.status_code == 0) {
                        html +=`<td><button class="nav-link active mapbtn" style="color: #fff; background-color: #fca605 !important; border: 1px solid #fca605;border-radius: 12px;">Pending</button></td>`
                    }else if(item.status_code == 1){
                        html +=`<td><button class="nav-link active mapbtn" style="color: #fff; background-color: #0aa602 !important; border: 1px solid #0aa602;border-radius: 12px;">Approved</button></td>`
                    }else{
                        html +=`<td><button class="nav-link active mapbtn" style="color: #fff; background-color: #fc1f0f !important; border: 1px solid #fc1f0f;border-radius: 12px;">Rejected</button></td>` 
                        }
                    html +=`<td>${item.created_by_person}</td>`
                    html +=`<td>${item.date_time}</td>`
                            '</tr>'
                });
                $("#problam_table").html(html);
                $("#table_data").DataTable({
                        "scrollX": false,
                        lengthChange:true,
                        dom: 'Bfrltip',
                        lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                        "ordering": false,
                        buttons: [],
                        language: {
                            searching: false,
                            search: '<img src="assets/svg/Search_icon.svg">',
                            searchPlaceholder: "Search",
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
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