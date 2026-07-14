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

        .scrollbar
        {	
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

        #divLargerImage
        {
        display: none;
        width: 500px;
        height: 500px;
        position: absolute;
        top: 35%;
        left: 35%;
        z-index: 99;
        }

        #divOverlay
        {
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
        div.dataTables_wrapper div.dataTables_info {
            padding-top: 0.85em;
            white-space: nowrap;
            padding-right: 20px;
            padding-top: 20px !important;
            padding-bottom: 50px;
        }
        .dataTables_scroll{
            overflow-x: scroll;
            display: block;
        }
        @media only screen and (max-width:1200px) {
        .main-contents {
        width: calc(100% - 60px);
        }
        }
        @media only screen and (max-width:1600px) {
        .custom-table.dataTable.no-footer {
        display: block;
        overflow-x: scroll;
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
                            <h1 class="header_main"><span class="twoinspace">Product Log</span></h1>
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
                                            <th>old_productname</th>
                                            <th>new_productname</th>
                                            <th>old_item_code</th>
                                            <th>new_item_code</th>
                                            <th>old_net_weight</th>
                                            <th>new_net_weight</th>
                                            <th>old_mrp</th>
                                            <th>new_mrp</th>
                                            <th>old_per_unit_price</th>
                                            <th>new_per_unit_price</th>
                                            <th>old_piece_count	</th>
                                            <th>new_piece_count</th>
                                            <th>created_by</th>
                                            <th>date_time</th>
                                            <th>delete_status</th>
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
                type :'product_log'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                type:"POST",
                dataType : 'json',
                url : api_path +"/admin/logReports.php",
                data:json_data,
            }).done(function(data){
                console.log('data',data);
                var html = '';
                data.data.forEach(function(item,index){
                    console.log(item);
                    html += `<tr>`
                    html += `<td>${item.old_productname}</td>`
                    html += `<td>${item.new_productname}</td>`
                    html += `<td>${item.old_item_code}</td>`
                    html += `<td>${item.new_item_code}</td>`
                    html += `<td>${item.old_net_weight}</td>`
                    html += `<td>${item.new_net_weight}</td>`
                    html += `<td>${item.old_mrp}</td>`
                    html += `<td>${item.new_mrp}</td>`
                    html += `<td>${item.old_total_cost}</td>`
                    html += `<td>${item.new_total_cost}</td>`
                    html += `<td>${item.old_piece_count}</td>`
                    html += `<td>${item.new_piece_count}</td>`
                    html += `<td>${item.created_by}</td>`
                    html += `<td>${item.date_time}</td>`
                    html += `<td>${item.status}</td>`
                    '</tr>'
                 });
                $("#problam_table").html(html);
                $("#table_data").DataTable({
                        "scrollX": true,
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