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
    <title>About Us</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/terms-condition.css<?php echo $js_cache_string; ?>">
     <link rel="stylesheet" href="css/About_us.css<?php echo $js_cache_string; ?>">

     <style>
         @media screen and (max-width:500px) {
                 .About_us_text h2 {  font-size: 17px;}
                  .About_us_text p {
                font: 16px/30px var(--regular-font);
            }
            }
     </style>

</head>
<body>
  <header id="main-dash-header" class="dash-header">      
    </header>
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar10"></div>
    <div class="se-pre-con"></div>

    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div>
                    <h1 class="header_main" data-i18n="about_us">About Us</h1>
                </div>
            </div>
            <!-- <div class="form-group pad20">
                <textarea class="form-control text_field" placeholder="Type something..."></textarea>
                <div class="update-btn-box">
                    <button class="btn-update">Update</button>
                </div>
            </div> -->

            <div class="form-group pad20">
                <div class="About_us_text">
                    <p>M/sAbirami Soap Works LLP once a small-sized manufacturing company has now transformed into a 250 crore FMCG manufacturing unit. Manufacturing and marketing a wide range of products including detergent cake, detergent powder, bath soap, shampoo, liquid detergent, talcum powder and dish wash bar/round and Gel. Allthis in just over 3 decades with 600 employees.</p>
                    
                    <p>A dream unfolds started in the 1970s. M/s Abirami soap works LLP was established as Gold Soap Company and operated with
                    single unit at Kodai Road, Dindigul, Tamilnad. It was founded by Shri Krishna Nadar, a visionary entrepreneur who believed that
                    there were a great demand for quality yet affordable detergent. His sharp business acumen and astute strategies paved the
                    way for the rapid growth of the brand. He built the business on the strong foundation of ethics and building enduring
                    customer relationship,</p>

                    <p>After Krishna Nadar's regime, the mantle was taken over by his son K. Dhanapal who took it to newer heights and the
                    company expanded. In 1998, detergent powder was introduced and this proved an extremely successful vênture. In 1994, he
                    renamed the brand name as "POWER".</p>

                    <p>"POWER" has become a household name in south India. The company owns it own raw material manufacturing units that caters 80% of its requirement. The rest of the basic raw materials are imported from Countries like Malaysia, Saudi Arabia, Indonesia, Qatar, China and Singapore.</p>

                    <p>By 2020, Mr. K. Dhanapal all sets to increase turnover to more than Rs. 1000 Crore. "We have set ourselves strong goals and stiff targets. We want to penetrate all segment of FMCG market and attain the magic figure of 1000 crore.</p>

                    <p>The company has procured fully-automated machines and equipments which have already been commissioned and are producing quality products. The plants are also in process of having fully automated.</p>

                    <p>After strive hard to manufacture quality products at an affordable price got grand success and there were 3 more manufacturing units M/s Power soaps Ltd Chennai and Puducherry, M/s Abirami Soap works, Puducherry and M/s Praveen chem Industry, Karaikal were added to meet the increasing demand for Power Products. However, a recent development is, new manufacturing unit which has been set up in SILVASSA near Maharashtra.</p>
                    
                    <p>Today the company has ventured into the personal care industry too. With hair care products like "NATURE POWER" range of shampoo and skin care products like "NATURE POWER" range of Beauty and Herbal bathing Soaps.</p>

                    <h2 data-i18n="state_art_infrastructure">State Art Infrastructure</h2>

                    <p>M/s Abirami soap works LP has always stayed at the forefront of technology, innovation and quality built on a backbone of a strong infrastructure. State of art and technology and equipment are the norm at every plant. Quality processes and
                    the best practices ensure that what reaches each customer is world class quality
                    at an affordable cost.</p>


                    <h2 data-i18n="research_development">Research and Development</h2>


                    <p>R&D is ongoing initiative and we have a full-fledged centre. A quality team of
                    scientists works consistently to innovate and add value to the product line. The
                    products are driven by innovation and technology and it's this trait that endears us
                    to our customers and helps us deliver product that are a cut above the rest.</p>
                     


                    
                </div>
            </div>
        </section>
    </main>
      <script>
        var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
        var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
        var notiCount = "<?php echo $notiCount; ?>";
     </script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script> 
    <script>
        const myTimeout = setTimeout(stopLoader, 1000);

            function stopLoader() {
                $(".se-pre-con").hide();
                clearTimeout(myTimeout);
            }
    </script>
</body>
</html>
<?php
}
?>