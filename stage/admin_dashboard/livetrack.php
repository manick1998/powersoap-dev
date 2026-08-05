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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Tracking</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/live.css?v=aski1">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <style>
        /* Modern Page Enhancements */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .header_container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 14px 24px;
            border-radius: 14px;
            margin-bottom: 12px;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
            position: relative;
            overflow: hidden;
        }

        .header_container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: headerShine 8s ease-in-out infinite;
        }

        @keyframes headerShine {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .header_main {
            color: white;
            font: 700 26px/1.2 'Poppins', sans-serif;
            margin: 0;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .bg-white {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 18px;
            padding: 16px 18px;
            box-shadow: 0 10px 36px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .main-contents {
            padding: 10px 12px !important;
        }

        .full-height {
            min-height: calc(100vh - 70px);
        }

        /* Compact track layout - map takes most space */
        .trackpage {
            display: flex !important;
            flex-direction: row !important;
            gap: 12px !important;
            align-items: stretch !important;
            min-height: calc(100vh - 140px);
        }

        .statevise {
            flex: 0 0 260px !important;
            max-width: 260px !important;
            width: 260px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            overflow: hidden !important;
        }

        .mapapikeys {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .listofstate h2,
        .detailofdealer h2,
        .dealerdetail h2 {
            font: 700 16px/1.3 'Poppins', sans-serif !important;
            margin: 0 0 8px 0 !important;
            padding-bottom: 6px !important;
            border-bottom: 2px solid #667eea !important;
            color: #2d3748 !important;
        }

        .listofstate,
        .detailofdealer,
        .dealerdetail {
            background: #fff;
            border-radius: 12px;
            padding: 10px 12px !important;
            border: 1px solid #e8ecf1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .detailofdealer {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .delearlist {
            flex: 1 1 auto;
            overflow-y: auto !important;
            max-height: none !important;
            min-height: 120px;
        }

        .dealerdetail {
            max-height: 220px;
            overflow-y: auto;
        }

        .dealerdetail #details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Sidebar Modern Styling */
        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.12);
            border-right: 2px solid #e2e8f0;
        }

        .sidebar-header {
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .side-togglebar {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .side-togglebar:hover {
            transform: scale(1.1);
        }

        .project-head {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 14px;
            font: 700 20px/1.3 'Poppins', sans-serif;
            margin: 0;
            text-align: center;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 10px 8px;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .project-menu {
            margin: 4px 0;
        }

        .sidebar-link {
            display: block;
            padding: 10px 16px !important;
            border-radius: 10px;
            margin: 3px 0;
            text-decoration: none;
            color: #4a5568;
            font: 500 14px/1.4 'Poppins', sans-serif;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.3s;
        }

        .sidebar-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            transform: translateX(6px);
            box-shadow: 0 4px 14px rgba(102, 126, 234, 0.35);
            padding-left: 22px !important;
        }

        .sidebar-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar-link.active-sidemenu {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            box-shadow: 0 4px 14px rgba(102, 126, 234, 0.45);
            font-weight: 600;
        }

        .sidebar-link.active-sidemenu::before {
            transform: scaleY(1);
        }

        .sidebar-link span {
            position: relative;
            z-index: 1;
        }

        .delearlist ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .delearlist ul li {
            text-transform: capitalize;
            font: 500 14px/1.4 'Poppins', sans-serif;
            padding: 10px 12px;
            margin: 4px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            border-radius: 10px;
            background: #f7fafc;
            border: 1px solid #edf2f7;
            transition: all 0.25s ease;
        }

        .delearlist ul li:hover {
            background-color: #edf2ff;
            border-color: #c3dafe;
            transform: translateX(4px);
        }

        .detailofdealer {
            display: none;
        }

        .dealerdetail {
            display: none;
        }

        /* Stats row - compact */
        .dateflex {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: stretch;
        }

        #overall_data {
            display: flex !important;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 0 !important;
        }

        .dateval {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 8px 14px;
            flex-wrap: nowrap;
            gap: 8px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin: 0 !important;
            flex: 1 1 auto;
            min-width: 160px;
        }

        .dateval p {
            margin: 0 !important;
            font: 500 13px/1.3 'Poppins', sans-serif;
            color: #4a5568;
            white-space: nowrap;
        }

        .dateval h5 {
            margin: 0 !important;
            font: 700 14px/1.3 'Poppins', sans-serif;
            color: #2d3748;
        }

        .dateval p span {
            margin: 0 2px;
        }

        /* BIG MAP */
        #map-canvas {
            width: 100% !important;
            height: calc(100vh - 220px) !important;
            min-height: 520px !important;
            border-radius: 14px !important;
            overflow: hidden !important;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12) !important;
            border: 1px solid #e2e8f0 !important;
        }

        .mapapikeys > .dateflex:has(#map-canvas),
        .mapapikeys > .dateflex {
            flex: 1 1 auto;
            min-height: 0;
        }

        .mapapikeys > .dateflex:has(#map-canvas) {
            display: block !important;
            flex: 1 1 auto !important;
        }

        #hide_class {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        #distributor {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .dealerdetail_2 {
            margin: 0;
            padding: 12px 14px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            width: auto;
            min-width: 160px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dealerdetail_2::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .dealerdetail_2:hover {
            background: white;
            border-color: #667eea;
            box-shadow: 0 6px 18px rgba(102, 126, 234, 0.22);
            transform: translateY(-2px);
        }

        .dealerdetail_2 h5 {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 6px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .dealerdetail_2 h5 + div h5 {
            color: #2d3748;
            font-size: 14px;
            font-weight: 600;
            text-transform: none;
            letter-spacing: 0;
            margin: 0;
        }

        .orderval {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            background: #f7fafc;
            border-radius: 8px;
            border: 1px solid #edf2f7;
            margin: 0 !important;
        }

        .orderval p {
            margin: 0 !important;
            font: 500 13px/1.3 'Poppins', sans-serif;
            color: #4a5568;
        }

        .orderval h5 {
            margin: 0 !important;
            font: 700 13px/1.3 'Poppins', sans-serif;
            color: #2d3748;
        }

        .box-field {
            padding: 10px 12px;
            margin: 6px 0;
            border-radius: 10px;
            background: #f7fafc;
            border: 1px solid #edf2f7;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .box-field:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .box-field h4 {
            margin: 0 0 6px 0;
            font: 600 14px/1.3 'Poppins', sans-serif;
            color: #2d3748;
        }

        /* Live status indicator */
        .live-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            font: 500 12px/1.2 'Poppins', sans-serif;
            color: #4a5568;
            margin: 0 0 8px 0;
            padding: 4px 0;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .live-dot.fetching {
            background: #f6ad55;
            animation: pulse 1s ease-in-out infinite;
        }

        .live-dot.live {
            background: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.25);
        }

        /* Hide Google Maps InfoWindow close button */
        .gm-ui-hover-effect {
            display: none !important;
        }

        /* Enhanced marker and info window styles */
        .marker-label {
            font-weight: bold;
            color: white !important;
            font-size: 14px !important;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
            font-family: 'Poppins', sans-serif;
        }

        .info-window-content {
            padding: 12px;
            font-family: 'Poppins', sans-serif;
            min-width: 260px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
        }

        .info-window-content h3 {
            margin: 0 0 10px 0;
            color: #2d3748;
            font-size: 16px;
            font-weight: 700;
            border-bottom: 3px solid #667eea;
            padding-bottom: 6px;
            text-transform: capitalize;
        }

        .info-window-content p {
            margin: 6px 0;
            font-size: 13px;
            color: #4a5568;
            line-height: 1.5;
        }

        .info-window-content strong {
            color: #667eea;
            font-weight: 700;
        }

        .visit-order {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 16px;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 12px;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.35);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .start-marker {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
        }

        .end-marker {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%) !important;
        }

        /* Smooth Popup Transitions */
        .custom-popup-content {
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 4px;
            transform: translateY(10px);
        }

        .custom-popup-content.show {
            opacity: 1;
            transform: translateY(0);
        }

        .datetime-badge {
            background: linear-gradient(135deg, #eef2f7 0%, #d1d9e6 100%);
            border: 2px solid #c5cdd8;
            padding: 8px 12px;
            border-radius: 8px;
            margin: 8px 0;
            font-size: 12px;
            color: #2c3e50;
            font-weight: 600;
            display: block;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            font-family: 'Poppins', sans-serif;
        }

        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .loading-text {
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Enhanced route visualization */
        .route-point-marker {
            animation: markerBounce 0.6s ease-out;
        }

        @keyframes markerBounce {
            0% { transform: translateY(-20px); opacity: 0; }
            60% { transform: translateY(5px); }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Active person indicator */
        .active-person {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border-color: #667eea !important;
            box-shadow: 0 6px 18px rgba(102, 126, 234, 0.45) !important;
            transform: translateX(6px);
            position: relative;
            padding-left: 40px !important;
        }

        .active-person::before {
            content: '📍';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            animation: pulseLoc 2s ease-in-out infinite;
        }

        .active-person::after {
            content: '→';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: white;
            opacity: 1;
        }

        @keyframes pulseLoc {
            0%, 100% { transform: translateY(-50%) scale(1); opacity: 1; }
            50% { transform: translateY(-50%) scale(1.15); opacity: 0.85; }
        }

        /* Responsive: stack on smaller screens but keep map tall */
        @media (max-width: 1100px) {
            .trackpage {
                flex-direction: column !important;
            }
            .statevise {
                flex: 0 0 auto !important;
                max-width: 100% !important;
                width: 100% !important;
                max-height: 280px;
            }
            #map-canvas {
                height: calc(100vh - 380px) !important;
                min-height: 420px !important;
            }
        }
    </style>
</head>
<body>
    <div class="se-pre-con" style="display: none;"></div>
    <header id="main-dash-header" class="dash-header">
    </header>
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
            <label for="sidebar-toggle" class="side-togglebar">
                <img src="assets/next.svg" alt="">
            </label>
        </div>
        <h2 class="project-head">Live Tracking</h2>
        <div class="sidebar-menu">
            <ul id="li_state">
            </ul>
        </div>
    </div>
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <h1 class="header_main">Live Tracking</h1>
            </div>
            <div class="trackpage">
                <div class="statevise">
                    <div class="listofstate">
                        <h2>Overall Details</h2>
                        <div id="state">
                        </div>
                    </div>
                    <div class="detailofdealer">
                        <h2>Sales Representatives</h2>
                        <div class="delearlist">
                            <ul id="rep">
                            </ul>
                        </div>
                    </div>
                    <div class="dealerdetail">
                        <h2>Details</h2>
                        <div id="details">
                        </div>
                    </div>
                </div>
                <div class="mapapikeys">
                    <div class="dateflex" id="overall_data">
                    </div>
                    <div class="dateflex">
                        <div id="map-canvas"></div>
                    </div>
                    <div class="dateflex" id="hide_class">
                        <div class="dateval" id="all_rep_leave">
                            <p>Total no of leave <span>:</span></p>
                            <h5>-</h5>
                        </div>
                        <div class="dateval">
                        </div>
                        <div class="dateval">
                        </div>
                    </div>
                    <div class="dateflex">
                        <div id="distributor">
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
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbV6guze9AOGJf91eU07rfrrK0qnICW1E&callback=initMap&v=weekly" defer></script>
    <script>
    // Map and tracker globals
    var map;
    var geocoder;
    var api_path = "<?php echo $api_path; ?>";
    var allMarkers = [];
    var allPolylines = [];
    var allCircles = [];
    var repMarkers = {}; // rep_token -> {marker, position, name}

    // Interactive states global controllers
    var currentHoverInfoWindow = null;
    var currentClickInfoWindow = null;
    var hoverTimeout = null;

    // Dynamic Filtering Engine: Cleans out alphanumeric Plus Codes securely
    function extractCleanAddress(results) {
        if (!results || results.length === 0) return "Area not found";

        for (var i = 0; i < results.length; i++) {
            var addr = results[i].formatted_address;
            var plusPos = addr.indexOf('+');
            if (plusPos === -1 || plusPos > 8) {
                return addr;
            }
        }

        var components = results[0].address_components;
        var addressParts = [];
        var desiredTypes = ['route', 'sublocality_level_1', 'sublocality', 'locality', 'administrative_area_level_2'];

        if (components && Array.isArray(components)) {
            for (var j = 0; j < desiredTypes.length; j++) {
                for (var k = 0; k < components.length; k++) {
                    if (components[k].types && components[k].types.indexOf(desiredTypes[j]) !== -1) {
                        addressParts.push(components[k].long_name);
                        break;
                    }
                }
            }
        }

        if (addressParts.length > 0) {
            return addressParts.join(', ');
        }

        return results[0].formatted_address;
    }

    function attachInteractivePopup(marker, mapInstance, innerHTML, fetchCallback) {
        var uniqueId = 'win-' + Math.random().toString(36).substr(2, 9);
        var processedHTML = innerHTML.replace(/{UNIQUE_ID}/g, uniqueId);
        var animatedWrapper = '<div class="custom-popup-content" id="' + uniqueId + '">' + processedHTML + '</div>';

        var infoWindow = new google.maps.InfoWindow({
            content: animatedWrapper
        });
        var dataFetched = false;
        var hoverIntentTimeout = null;

        function triggerFetch() {
            if (!dataFetched && typeof fetchCallback === 'function') {
                dataFetched = true;
                fetchCallback(uniqueId);
            }
        }

        // 1. Hover to Show (with delay)
        marker.addListener("mouseover", function() {
            if (currentClickInfoWindow && currentClickInfoWindow.marker === marker) return;

            if (currentHoverInfoWindow && currentHoverInfoWindow !== infoWindow) {
                currentHoverInfoWindow.close();
            }

            if (hoverTimeout) clearTimeout(hoverTimeout);

            infoWindow.open(mapInstance, marker);
            currentHoverInfoWindow = infoWindow;
            currentHoverInfoWindow.marker = marker;

            hoverIntentTimeout = setTimeout(function() {
                triggerFetch();
            }, 400);

            setTimeout(function() {
                var domElement = document.getElementById(uniqueId);
                if (domElement) domElement.classList.add('show');
            }, 15);
        });

        // 2. Hover to Hide
        marker.addListener("mouseout", function() {
            if (hoverIntentTimeout) clearTimeout(hoverIntentTimeout);

            if (currentClickInfoWindow && currentClickInfoWindow.marker === marker) return;

            var domElement = document.getElementById(uniqueId);
            if (domElement) domElement.classList.remove('show');

            hoverTimeout = setTimeout(function() {
                if (currentHoverInfoWindow === infoWindow) {
                    infoWindow.close();
                    currentHoverInfoWindow = null;
                }
            }, 300);
        });

        // 3. Click to Lock and Keep Open
        marker.addListener("click", function() {
            if (hoverIntentTimeout) clearTimeout(hoverIntentTimeout);
            if (currentHoverInfoWindow) {
                currentHoverInfoWindow.close();
                currentHoverInfoWindow = null;
            }

            if (currentClickInfoWindow && currentClickInfoWindow !== infoWindow) {
                currentClickInfoWindow.close();
            }

            infoWindow.open(mapInstance, marker);
            currentClickInfoWindow = infoWindow;
            currentClickInfoWindow.marker = marker;

            triggerFetch();

            setTimeout(function() {
                var domElement = document.getElementById(uniqueId);
                if (domElement) domElement.classList.add('show');
            }, 15);
        });
    }

    $(document).ready(function() {
        let consolidatedData = {
            type: "total_live_info"
        };
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/live_tracking_state.php",
            data: JSON.stringify(consolidatedData),
        }).done(function(response) {
            var overall = '';
            const d = new Date();
            var date = `${d.getFullYear()}-${d.getMonth()+1}-${d.getDate()}`;
            if (response.overall_stats && Array.isArray(response.overall_stats)) {
                response.overall_stats.forEach(function(item) {
                    overall += `<div class="dateval"><p>Date <span>:</span></p><h5>${date}</h5></div>
                               <div class="dateval"><p>Total no of order <span>:</span></p><h5>${item.orders_count}</h5></div>
                               <div class="dateval"><p>Order Value <span>:</span></p><h5>${item.total_order_value}</h5></div>`;
                });
            }
            $("#overall_data").html(overall);

            var statedate = '';
            if (response.state_data && Array.isArray(response.state_data)) {
                response.state_data.forEach(function(item) {
                    statedate += `<div class="box-field">
                                    <h4 id="token_sate" data-state_token="${item.state_token}">${item.state_name}</h4>
                                    <div class="orderval"><p>Order Value <span>:</span></p><h5 class="amount">INR </h5></div>
                                  </div>`;
                });
            }
            $("#state").html(statedate);

            var sidebarHtml = '';
            if (response.sidebar_statedata && Array.isArray(response.sidebar_statedata)) {
                response.sidebar_statedata.forEach(function(item, i) {
                    sidebarHtml += `<li class="project-menu">
                                        <a href="javascript:void(0)" class="greenline1 sidebar-link ${i==0 ? 'active-sidemenu':''}" id="state_click" data-token="${item.token}">
                                            <span>${item.state_name}</span>
                                        </a>
                                    </li>`;
                });
            }
            $('#li_state').html(sidebarHtml);

            var leaveHtml = '';
            if (response.leave_count && Array.isArray(response.leave_count)) {
                response.leave_count.forEach(function(item) {
                    leaveHtml += `<p>Total no of leave <span>:</span></p><h5>${item.total_count_leave}</h5>`;
                });
            }
            $('#all_rep_leave').html(leaveHtml);
        });
    });

    $(document).on('click', '#state', function(e) {
        const state = e.target.closest('.box-field');
        if (!state) return;
        const stateName = state.querySelector('#token_sate');
        const amount = state.querySelector('.amount');
        if (!stateName || !amount) return;
        var token = $(stateName).attr('data-state_token');
        var data = {
            "state_token": token
        };
        var json_data = JSON.stringify(data);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: api_path + "/admin/individual_state_amount.php",
            data: json_data,
        }).done(function(datas) {
            if (datas && Array.isArray(datas)) {
                amount.textContent = '';
                datas.forEach(function(itme, index) {
                    amount.textContent = '₹' + itme.state_amount;
                });
            }
        });
    });

    $(document).on('click', '#ind_rep', function() {
        var rep_token = $(this).attr('data-sales_rep_token');

        // === VISUAL HIGHLIGHT: Remove active from all, add to clicked ===
        $('#rep li').removeClass('active-person');
        $(this).addClass('active-person');

        // === MAP ZOOM: Pan & zoom to this person's marker ===
        if (repMarkers[rep_token]) {
            map.panTo(repMarkers[rep_token].position);
            map.setZoom(14);
            // Trigger marker click to show route
            google.maps.event.trigger(repMarkers[rep_token].marker, 'click');
        }

        // === LIVE FETCH: Stop old interval, start new one ===
        startLiveFetch(rep_token);
    });

    // =============================
    // LIVE AUTO-REFRESH ENGINE
    // =============================
    var liveFetchInterval = null;
    var currentLiveRepToken = null;

    function startLiveFetch(rep_token) {
        // Clear previous interval
        if (liveFetchInterval) {
            clearInterval(liveFetchInterval);
            liveFetchInterval = null;
        }
        currentLiveRepToken = rep_token;

        // Show loading state
        showLiveStatus('fetching');

        // Fetch immediately
        fetchRepDetails(rep_token);
        fetchRepDistributor(rep_token);

        // Auto-refresh every 15 seconds
        liveFetchInterval = setInterval(function() {
            if (currentLiveRepToken === rep_token) {
                showLiveStatus('fetching');
                fetchRepDetails(rep_token);
                fetchRepDistributor(rep_token);
            }
        }, 15000);
    }

    function showLiveStatus(status) {
        var liveIndicator = $('#live-status');
        if (liveIndicator.length === 0) {
            // Create live indicator if it doesn't exist
            $('.dealerdetail h2').after('<div id="live-status" class="live-indicator"></div>');
            liveIndicator = $('#live-status');
        }
        if (status === 'fetching') {
            liveIndicator.html('<span class="live-dot fetching"></span> Updating live...');
        } else if (status === 'live') {
            var now = new Date();
            var timeStr = now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            liveIndicator.html('<span class="live-dot live"></span> Live · Updated ' + timeStr);
        }
    }

    function fetchRepDetails(rep_token) {
        var reptoken = {
            "type": "sales_details",
            "rep_token": rep_token
        };
        let json_data = JSON.stringify(reptoken);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: api_path + "/admin/rep_sales_details.php",
            data: json_data,
        }).done(function(repdata) {
            var html = '';
            if (repdata && Array.isArray(repdata.deatils)) {
                repdata.deatils.forEach(function(item, index) {
                    html += `
                    <div class="orderval">
                        <p>Mobile Number <span>:</span></p>
                        <h5>${item.mobile_number}</h5>
                    </div>
                    <div class="orderval">
                        <p>Total no of order <span>:</span></p>
                        <h5>${item.shop_count}</h5>
                    </div>
                    <div class="orderval">
                        <p>Order Value <span>:</span></p>
                        <h5>${item.total_amount}</h5>
                    </div>`;
                });
            }
            if (repdata && Array.isArray(repdata.total_shop_read)) {
                repdata.total_shop_read.forEach(function(item, index) {
                    html += `<div class="orderval">
                        <p>Total Shop <span>:</span></p>
                        <h5>${item.total_shop_count}</h5>
                    </div>`;
                });
            }
            if (repdata && Array.isArray(repdata.order_taken_total)) {
                repdata.order_taken_total.forEach(function(item, index) {
                    html += `<div class="orderval">
                        <p>Total Shop Order<span>:</span></p>
                        <h5>${item.total_shop_order}</h5>
                    </div>`;
                });
            }
            if (repdata && Array.isArray(repdata.total_take_order_no_order_read)) {
                repdata.total_take_order_no_order_read.forEach(function(item, index) {
                    html += `<div class="orderval">
                        <p>Shop closed/No order <span>:</span></p>
                        <h5>${item.type_count}</h5>
                    </div>`;
                });
            }
            $("#details").html(html);
            showLiveStatus('live');
        }).fail(function() {
            showLiveStatus('live');
        });
    }

    function fetchRepDistributor(rep_token) {
        var reptoken1 = {
            "type": "allocate_distributor",
            "rep_token": rep_token
        };
        let json_data1 = JSON.stringify(reptoken1);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: api_path + "/admin/rep_sales_details.php",
            data: json_data1,
        }).done(function(repdata1) {
            var html = '';
            if (repdata1 && Array.isArray(repdata1.distributor_data2)) {
                repdata1.distributor_data2.forEach(function(item, index) {
                    html += `<p>District <span>:</span>${item.region_name}</p>`;
                });
            }
            if (repdata1 && Array.isArray(repdata1.distributor_data)) {
                repdata1.distributor_data.forEach(function(item, index) {
                    html += `
                   <div class="dealerdetail_2" style="display: block;">
                        <h5>Distributor Name</h5>
                        <div id="">
                          <h5>${item.distributor_name}</h5>
                        </div>
                   </div>`;
                });
            }
            if (repdata1 && Array.isArray(repdata1.distributor_data1)) {
                repdata1.distributor_data1.forEach(function(item, index) {
                    html += `<div class="dealerdetail_2" style="display: block;">
                        <h5>Area Name</h5>
                        <div id="">
                        <h5>${item.area_name}</h5>
                        </div>
                    </div>`;
                });
            }

            $("#distributor").html(html);
        });
    }

    function initMap() {
        var option = {
            zoom: 6,
            center: { lat: 13.768015, lng: 77.707550 }
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), option);
        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, "click", function() {
            if (currentClickInfoWindow) {
                currentClickInfoWindow.close();
                currentClickInfoWindow = null;
            }
        });

        var data = { "type": "all_sales_rep_latlong" };
        var json_data = JSON.stringify(data);
        var arr = [];

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: api_path + "/admin/latlang.php",
            data: json_data,
        }).done(function(res_data) {
            console.log('Live tracking all_sales_rep_latlong response:', res_data);
            if (res_data && Array.isArray(res_data.data)) {
                res_data.data.forEach(function(item, index) {
                    var pLat = parseFloat(item.lat);
                    var pLng = parseFloat(item.lang);
                    if (isNaN(pLat) || isNaN(pLng)) return;

                    arr.push({
                        coord: { 'lat': pLat, 'lng': pLng },
                        rep_schedule_token: item.schedule_token,
                        rep_token: item.rep_token,
                        img: {
                            url: item.rep_image,
                            scaledSize: new google.maps.Size(50, 50),
                            labelOrigin: new google.maps.Point(25, 25)
                        },
                        rep_name: item.rep_name,
                        area_name: item.area_name
                    });
                });
            }

            for (let i = 0; i < arr.length; i++) {
                var element = arr[i];
                setdata(element);
            }

            function setdata(props) {
                var marker = new google.maps.Marker({
                    map: map,
                    position: props.coord,
                    icon: props.img,
                    animation: google.maps.Animation.DROP,
                });

                // Store marker reference for click-to-zoom
                repMarkers[props.rep_token] = {
                    marker: marker,
                    position: props.coord,
                    name: props.rep_name
                };

                var popupStaticHTML = `
                    <div style="text-align:center; padding:5px; font-family: sans-serif;">
                        <div style="font-size:14px; font-weight:700; color:#333; margin-bottom:5px; text-transform: uppercase;">${props.rep_name}</div>
                        <div style="font-size:12px; color:#555; background:#eef2f7; border-radius:15px; padding:4px 10px; display:inline-block; border:1px solid #d1d9e6;">${props.area_name || "N/A"}</div>
                        <p style="margin: 8px 0; font-size: 13px; line-height: 1.4; text-align:left;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                    </div>
                `;

                attachInteractivePopup(marker, map, popupStaticHTML, function(uid) {
                    geocoder.geocode({ 'location': props.coord }, function(results, status) {
                        var locBadge = document.getElementById('loc-badge-' + uid);
                        if (locBadge) {
                            if (status === 'OK') {
                                locBadge.innerHTML = extractCleanAddress(results);
                            } else {
                                locBadge.innerHTML = "Area not found";
                            }
                        }
                    });
                });

                google.maps.event.addListener(marker, "click", function() {
                    map.panTo(this.getPosition());
                    map.setZoom(13);
                    var rep_schedule_token = props.rep_schedule_token;
                    var rep_token = props.rep_token;

                    clearMapMarkers();

                    var data_name = {
                        "type": "rep_name",
                        "rep_token": rep_token
                    };
                    var json_data7 = JSON.stringify(data_name);
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: api_path + "/admin/latlang.php",
                        data: json_data7,
                    }).done(function(named_data) {
                        if (named_data && Array.isArray(named_data.name_data1)) {
                            var date_arr = [];
                            named_data.name_data1.forEach(function(item) {
                                date_arr.push(item.rep_name);
                            });
                            for (let index = 0; index < date_arr.length; index++) {
                                const element12 = date_arr[index];
                                repname(element12);
                            }
                        }

                        function repname(element12) {
                            var infowindow12 = new google.maps.InfoWindow({
                                content: element12,
                                ariaLabel: "Uluru",
                            });
                            infowindow12.open({
                                anchor: marker,
                                map: map,
                            });
                        }
                    });

                    // Fetching shops latlangs
                    var data1 = {
                        "type": "shop_latlang",
                        "rep_token": rep_token
                    };
                    var json_data1 = JSON.stringify(data1);
                    var shop_arr = [];
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: api_path + "/admin/latlang.php",
                        data: json_data1,
                    }).done(function(shop_res_data) {
                        if (shop_res_data && Array.isArray(shop_res_data.rep_shop_lat_data)) {
                            shop_res_data.rep_shop_lat_data.forEach(function(item, index) {
                                if (!item.lats) return;
                                var pLat = parseFloat(item.lats.split(',')[0]);
                                var pLng = parseFloat(item.lats.split(',')[1]);
                                if (isNaN(pLat) || isNaN(pLng)) return;

                                var date_time = "Not Logged";
                                var visit_time = "Not Logged";
                                if (item.date_time) {
                                    var dt = new Date(item.date_time);
                                    if (!isNaN(dt.getTime())) {
                                        date_time = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                        visit_time = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                    } else {
                                        date_time = item.date_time;
                                        visit_time = "";
                                    }
                                }

                                shop_arr.push({
                                    coords: { 'lat': pLat, 'lng': pLng },
                                    meters: 10,
                                    rep_schedule_token: item.shop_name,
                                    shop_name: item.shop_name,
                                    date_time: date_time,
                                    visit_time: visit_time
                                });
                            });

                            for (let index = 0; index < shop_arr.length; index++) {
                                var element_data = shop_arr[index];
                                shops(element_data, index, shop_arr.length);
                            }
                        }
                    });

                    // Fetching particular sales rep route points
                    var data = {
                        "type": "particulor_rep_latlang",
                        "rep_schedule_token": rep_schedule_token,
                        "rep_token": rep_token
                    };
                    var json_data = JSON.stringify(data);
                    var array_lat = [];
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: api_path + "/admin/latlang.php",
                        data: json_data,
                    }).done(function(res_data1) {
                        if (res_data1 && Array.isArray(res_data1.data1)) {
                            var imageGreen = {
                                url: 'assets/green.svg',
                                scaledSize: new google.maps.Size(35, 35),
                                labelOrigin: new google.maps.Point(17, 17)
                            };
                            var imageRed = {
                                url: 'assets/red.svg',
                                scaledSize: new google.maps.Size(30, 30),
                                labelOrigin: new google.maps.Point(15, 15)
                            };

                            res_data1.data1.forEach(function(item, index) {
                                var pLat = parseFloat(item.rep_lat);
                                var pLng = parseFloat(item.rep_lang);
                                if (isNaN(pLat) || isNaN(pLng)) return;

                                var date_time = "Not Logged";
                                var visit_time = "Not Logged";
                                if (item.date_time) {
                                    var dt = new Date(item.date_time);
                                    if (!isNaN(dt.getTime())) {
                                        date_time = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                        visit_time = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                    } else {
                                        date_time = item.date_time;
                                        visit_time = "";
                                    }
                                }
                                var imgToUse = imageRed;
                                if (item.type == '2') imgToUse = imageGreen;

                                array_lat.push({
                                    coords: { 'lat': pLat, 'lng': pLng },
                                    rep_schedule_token: item.rep_schedule_token,
                                    rep_token: item.rep_token,
                                    rep_lat: item.rep_lat,
                                    rep_lang: item.rep_lang,
                                    date_time: date_time,
                                    visit_time: visit_time,
                                    img: imgToUse
                                });
                            });

                            var polyarrays = [];
                            for (let i = 0; i < array_lat.length; i++) {
                                var elements = array_lat[i];
                                polyarrays.push(elements.coords);
                                setlatlang(elements, i, array_lat.length);
                            }

                            function setlatlang(elements, index, total) {
                                var label = {
                                    text: String(index + 1),
                                    color: "white",
                                    fontSize: "12px",
                                    fontWeight: "bold"
                                };

                                var marker1 = new google.maps.Marker({
                                    map: map,
                                    icon: elements.img,
                                    position: elements.coords,
                                    animation: google.maps.Animation.DROP,
                                    label: label
                                });

                                allMarkers.push(marker1);

                                const flightPath = new google.maps.Polyline({
                                    path: polyarrays,
                                    geodesic: true,
                                    strokeColor: "#667eea",
                                    strokeOpacity: 0.9,
                                    strokeWeight: 4,
                                    icons: [{
                                        icon: {
                                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                            scale: 6,
                                            strokeColor: '#764ba2',
                                            strokeWeight: 2
                                        },
                                        offset: '0',
                                        repeat: '60px'
                                    }]
                                });
                                flightPath.setMap(map);
                                allPolylines.push(flightPath);

                                var popupContent = `
                                    <div class="info-window-content">
                                        <div class="visit-order">Visit #${index + 1}</div>
                                        <h3>Route Point ${index + 1} of ${total}</h3>
                                        <div class="datetime-badge" id="dt-badge-{UNIQUE_ID}">⏳ Fetching Time...</div>
                                        <p style="margin: 8px 0; font-size: 13px; line-height: 1.4;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                                        <p style="font-size:10px; color:#999; margin:0;">Lat: ${elements.rep_lat}, Lng: ${elements.rep_lang}</p>
                                    </div>
                                `;

                                attachInteractivePopup(marker1, map, popupContent, function(uid) {
                                    var dtData = {
                                        "type": "lat_lang_date_and_time",
                                        "lat": elements.rep_lat,
                                        "lang": elements.rep_lang
                                    };
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: api_path + "/admin/latlang.php",
                                        data: JSON.stringify(dtData),
                                    }).done(function(date_data) {
                                        var fDate = elements.date_time;
                                        var fTime = elements.visit_time;
                                        if (date_data && Array.isArray(date_data.read_date_lang) && date_data.read_date_lang.length > 0) {
                                            var rawDt = date_data.read_date_lang[0].date_time;
                                            if (rawDt) {
                                                var dt = new Date(rawDt);
                                                if (!isNaN(dt.getTime())) {
                                                    fDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                                    fTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                                } else {
                                                    fDate = rawDt;
                                                    fTime = "";
                                                }
                                            }
                                        }
                                        var badgeEl = document.getElementById('dt-badge-' + uid);
                                        if (badgeEl) {
                                            badgeEl.innerHTML = "📅 " + fDate + (fTime && fTime !== "Not Logged" ? " | ⏰ " + fTime : "");
                                        }
                                    }).fail(function() {
                                        var badgeEl = document.getElementById('dt-badge-' + uid);
                                        if (badgeEl) {
                                            badgeEl.innerHTML = "📅 " + elements.date_time + (elements.visit_time && elements.visit_time !== "Not Logged" ? " | ⏰ " + elements.visit_time : "");
                                        }
                                    });

                                    geocoder.geocode({ 'location': elements.coords }, function(results, status) {
                                        var locBadge = document.getElementById('loc-badge-' + uid);
                                        if (locBadge) {
                                            if (status === 'OK') {
                                                locBadge.innerHTML = extractCleanAddress(results);
                                            } else {
                                                locBadge.innerHTML = "Area not found";
                                            }
                                        }
                                    });
                                });
                            }
                        }
                    });
                });
            }
        });
    }

    function clearMapMarkers() {
        for (var i = 0; i < allMarkers.length; i++) {
            allMarkers[i].setMap(null);
        }
        allMarkers = [];

        for (var i = 0; i < allPolylines.length; i++) {
            allPolylines[i].setMap(null);
        }
        allPolylines = [];

        for (var i = 0; i < allCircles.length; i++) {
            allCircles[i].setMap(null);
        }
        allCircles = [];
    }

    // General Shop Markers
    function shops(param, index, total) {
        var shop_image = {
            url: "assets/shop.png",
            scaledSize: new google.maps.Size(50, 50),
            labelOrigin: new google.maps.Point(25, 25)
        };

        var label = {
            text: String(index + 1),
            color: "white",
            fontSize: "14px",
            fontWeight: "bold"
        };

        var shop_maker = new google.maps.Marker({
            map: map,
            icon: shop_image,
            position: param.coords,
            animation: google.maps.Animation.DROP,
            label: label,
            title: "Visit #" + (index + 1)
        });

        allMarkers.push(shop_maker);

        const cityCircle = new google.maps.Circle({
            strokeColor: "#667eea",
            strokeOpacity: 0.8,
            strokeWeight: 4,
            fillColor: "#764ba2",
            fillOpacity: 0.25,
            map: map,
            center: param.coords,
            radius: param.meters,
        });
        allCircles.push(cityCircle);

        var popupContent = `
            <div class="info-window-content">
                <div class="visit-order">Visit #${index + 1}</div>
                <h3>${param.shop_name || param.rep_schedule_token || 'Shop Location'}</h3>
                <div class="datetime-badge">📅 ${param.date_time} | ⏰ ${param.visit_time}</div>
                <p><strong>Visit Order:</strong> ${index + 1} of ${total}</p>
                <p style="margin: 8px 0; font-size: 13px; line-height: 1.4;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                <p style="font-size:10px; color:#999; margin:0;">Lat: ${param.coords.lat.toFixed(6)}, Lng: ${param.coords.lng.toFixed(6)}</p>
            </div>
        `;

        attachInteractivePopup(shop_maker, map, popupContent, function(uid) {
            geocoder.geocode({ 'location': param.coords }, function(results, status) {
                var locBadge = document.getElementById('loc-badge-' + uid);
                if (locBadge) {
                    if (status === 'OK') {
                        locBadge.innerHTML = extractCleanAddress(results);
                    } else {
                        locBadge.innerHTML = "Area not found";
                    }
                }
            });
        });
    }

    // ================= individual state data switcher
    $(".sidebar-menu").on("click", "#state_click", function() {
        var option = {
            zoom: 6,
            center: { lat: 13.768015, lng: 77.707550 }
        };

        map = new google.maps.Map(document.getElementById("map-canvas"), option);
        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, "click", function() {
            if (currentClickInfoWindow) {
                currentClickInfoWindow.close();
                currentClickInfoWindow = null;
            }
        });

        clearMapMarkers();

        var state_token = $(this).attr('data-token');
        if (state_token == 0) {
            $(".detailofdealer").hide();
            $(".dealerdetail").hide();
            $(".listofstate").show();
            window.location.reload();
        } else {
            $(".listofstate").hide();
            $(".detailofdealer").show();
            $(".dealerdetail").show();
            $("#hide_class").hide();

            let statetoken = {
                "state_token": state_token
            };
            let json_data = JSON.stringify(statetoken);
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: api_path + "/admin/individual_state_rep.php",
                data: json_data,
            }).done(function(res_repdata) {
                if (res_repdata && Array.isArray(res_repdata.individual_state_rep_read)) {
                    var html = '';
                    res_repdata.individual_state_rep_read.forEach(function(item, index) {
                        html += `<li id="ind_rep" data-sales_rep_token="${item.rep_token}">${item.rep_name}</li>`;
                    });
                    $("#rep").html(html);
                }
            });

            let statetoken2 = {
                "type": "particular_state_order_value",
                "state_token": state_token
            };
            var json_data2 = JSON.stringify(statetoken2);
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: api_path + "/admin/live_tracking_state.php",
                data: json_data2
            }).done(function(result_data) {
                if (result_data && Array.isArray(result_data.particular_state_order_read)) {
                    var overall = '';
                    const d = new Date();
                    var date = `${d.getFullYear()}-${d.getMonth()+1}-${d.getDate()}  ${d.toLocaleTimeString().replace(/:\d+ /, ' ')}`;
                    result_data.particular_state_order_read.forEach(function(item) {
                        overall += `<div class="dateval">
                                <p>Date <span>:</span></p>
                                <h5>${date}</h5>
                            </div>
                            <div class="dateval">
                                <p>Total no of order <span>:</span></p>
                                <h5>${item.count_order}</h5>
                            </div>
                            <div class="dateval">
                                <p>Order Value <span>:</span></p>
                                <h5>${item.total_order_value == null ? '-': item.total_order_value}</h5>
                            </div>`;
                    });
                    $("#overall_data").html(overall);
                }
            });

            let statetoken1 = {
                "type": "particular_state_latlang",
                "state_token": state_token
            };
            let json_data1 = JSON.stringify(statetoken1);
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: api_path + "/admin/latlang.php",
                data: json_data1,
            }).done(function(get_data) {
                var aar = [];
                var h = new Date().getHours();
                var m = new Date().getMinutes();
                var js_date = `${h}:${m}`;

                if (get_data && Array.isArray(get_data.stmt_state_lat_data)) {
                    get_data.stmt_state_lat_data.forEach(function(item, index) {
                        var date_times = new Date(item.date_time);
                        var db_time = `${date_times.getHours()}:${date_times.getMinutes()}`;

                        if (db_time == js_date || db_time < js_date) {
                            var pLat = parseFloat(item.rep_lat);
                            var pLng = parseFloat(item.rep_lang);
                            if (isNaN(pLat) || isNaN(pLng)) return;

                            aar.push({
                                coord: { 'lat': pLat, 'lng': pLng },
                                rep_schedule_token: item.rep_schedule_token,
                                rep_token: item.rep_token,
                                img: {
                                    url: item.rep_image,
                                    scaledSize: new google.maps.Size(50, 50),
                                    labelOrigin: new google.maps.Point(25, 25)
                                },
                                rep_name: item.rep_name,
                                area_name: item.area_name
                            });
                        }
                    });

                    for (let i = 0; i < aar.length; i++) {
                        const element = aar[i];
                        ind_state_rep_marker_fun(element);
                    }
                }

                function ind_state_rep_marker_fun(state_props) {
                    var ind_state_rep_marker = new google.maps.Marker({
                        map: map,
                        position: state_props.coord,
                        icon: state_props.img,
                        animation: google.maps.Animation.DROP,
                    });

                    // Store marker reference for click-to-zoom
                    repMarkers[state_props.rep_token] = {
                        marker: ind_state_rep_marker,
                        position: state_props.coord,
                        name: state_props.rep_name
                    };

                    var popupStaticHTML = `
                        <div style="text-align:center; padding:5px; font-family: sans-serif;">
                            <div style="font-size:14px; font-weight:700; color:#333; margin-bottom:5px; text-transform: uppercase;">${state_props.rep_name}</div>
                            <div style="font-size:12px; color:#555; background:#eef2f7; border-radius:15px; padding:4px 10px; display:inline-block; border:1px solid #d1d9e6;">${state_props.area_name || "N/A"}</div>
                            <p style="margin: 8px 0; font-size: 13px; line-height: 1.4; text-align:left;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                        </div>
                    `;

                    attachInteractivePopup(ind_state_rep_marker, map, popupStaticHTML, function(uid) {
                        geocoder.geocode({ 'location': state_props.coord }, function(results, status) {
                            var locBadge = document.getElementById('loc-badge-' + uid);
                            if (locBadge) {
                                if (status === 'OK') {
                                    locBadge.innerHTML = extractCleanAddress(results);
                                } else {
                                    locBadge.innerHTML = "Area not found";
                                }
                            }
                        });
                    });

                    google.maps.event.addListener(ind_state_rep_marker, "click", function() {
                        map.panTo(this.getPosition());
                        map.setZoom(13);
                        var rep_schedule_token = state_props.rep_schedule_token;
                        var rep_token = state_props.rep_token;

                        clearMapMarkers();

                        // IND STATE SHOPS
                        var data1 = {
                            "type": "shop_latlang",
                            "rep_token": rep_token
                        };
                        var json_data1 = JSON.stringify(data1);
                        var shop_arr = [];
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: api_path + "/admin/latlang.php",
                            data: json_data1,
                        }).done(function(shop_res_data) {
                            if (shop_res_data && Array.isArray(shop_res_data.rep_shop_lat_data)) {
                                shop_res_data.rep_shop_lat_data.forEach(function(item, index) {
                                    if (!item.lats) return;
                                    var pLat = parseFloat(item.lats.split(',')[0]);
                                    var pLng = parseFloat(item.lats.split(',')[1]);
                                    if (isNaN(pLat) || isNaN(pLng)) return;

                                    var date_time = "Not Logged";
                                    var visit_time = "Not Logged";
                                    if (item.date_time) {
                                        var dt = new Date(item.date_time);
                                        if (!isNaN(dt.getTime())) {
                                            date_time = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                            visit_time = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                        } else {
                                            date_time = item.date_time;
                                            visit_time = "";
                                        }
                                    }

                                    shop_arr.push({
                                        coords: { 'lat': pLat, 'lng': pLng },
                                        meters: 100,
                                        rep_schedule_token: item.shop_name,
                                        shop_name: item.shop_name,
                                        date_time: date_time,
                                        visit_time: visit_time
                                    });
                                });

                                for (let index = 0; index < shop_arr.length; index++) {
                                    var element_data = shop_arr[index];
                                    ind_shops(element_data, index, shop_arr.length);
                                }
                            }
                        });

                        // IND STATE ROUTE POINTS
                        var data = {
                            "type": "particulor_rep_latlang",
                            "rep_schedule_token": rep_schedule_token,
                            "rep_token": rep_token
                        };
                        var json_data = JSON.stringify(data);
                        var array_lat = [];
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: api_path + "/admin/latlang.php",
                            data: json_data,
                        }).done(function(res_data1) {
                            if (res_data1 && Array.isArray(res_data1.data1)) {
                                var imageGreen = {
                                    url: 'assets/green.svg',
                                    scaledSize: new google.maps.Size(35, 35),
                                    labelOrigin: new google.maps.Point(17, 17)
                                };
                                var imageRed = {
                                    url: 'assets/red.svg',
                                    scaledSize: new google.maps.Size(30, 30),
                                    labelOrigin: new google.maps.Point(15, 15)
                                };

                                res_data1.data1.forEach(function(item, index) {
                                    var pLat = parseFloat(item.rep_lat);
                                    var pLng = parseFloat(item.rep_lang);
                                    if (isNaN(pLat) || isNaN(pLng)) return;

                                    var date_time = "Not Logged";
                                    var visit_time = "Not Logged";
                                    if (item.date_time) {
                                        var dt = new Date(item.date_time);
                                        if (!isNaN(dt.getTime())) {
                                            date_time = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                            visit_time = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                        } else {
                                            date_time = item.date_time;
                                            visit_time = "";
                                        }
                                    }
                                    var imgToUse = imageRed;
                                    if (item.type == '2') imgToUse = imageGreen;

                                    array_lat.push({
                                        coords: { 'lat': pLat, 'lng': pLng },
                                        rep_schedule_token: item.rep_schedule_token,
                                        rep_token: item.rep_token,
                                        rep_lat: item.rep_lat,
                                        rep_lang: item.rep_lang,
                                        date_time: date_time,
                                        visit_time: visit_time,
                                        img: imgToUse
                                    });
                                });

                                var polyarrays = [];
                                for (let i = 0; i < array_lat.length; i++) {
                                    var elements = array_lat[i];
                                    polyarrays.push(elements.coords);
                                    ind_setlatlang(elements, i, array_lat.length);
                                }

                                function ind_setlatlang(elements, index, total) {
                                    var label = {
                                        text: String(index + 1),
                                        color: "white",
                                        fontSize: "12px",
                                        fontWeight: "bold"
                                    };

                                    var marker1 = new google.maps.Marker({
                                        map: map,
                                        icon: elements.img,
                                        position: elements.coords,
                                        animation: google.maps.Animation.DROP,
                                        label: label
                                    });

                                    allMarkers.push(marker1);

                                    const flightPath = new google.maps.Polyline({
                                        path: polyarrays,
                                        geodesic: true,
                                        strokeColor: "#667eea",
                                        strokeOpacity: 0.9,
                                        strokeWeight: 4,
                                        icons: [{
                                            icon: {
                                                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                                scale: 6,
                                                strokeColor: '#764ba2',
                                                strokeWeight: 2
                                            },
                                            offset: '0',
                                            repeat: '60px'
                                        }]
                                    });
                                    flightPath.setMap(map);
                                    allPolylines.push(flightPath);

                                    var popupContent = `
                                        <div class="info-window-content">
                                            <div class="visit-order">Visit #${index + 1}</div>
                                            <h3>Route Point ${index + 1} of ${total}</h3>
                                            <div class="datetime-badge" id="dt-badge-{UNIQUE_ID}">📅 ${elements.date_time} | ⏰ ${elements.visit_time}</div>
                                            <p style="margin: 8px 0; font-size: 13px; line-height: 1.4;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                                            <p style="font-size:10px; color:#999; margin:0;">Lat: ${elements.rep_lat}, Lng: ${elements.rep_lang}</p>
                                        </div>
                                    `;

                                    attachInteractivePopup(marker1, map, popupContent, function(uid) {
                                        var dtData = {
                                            "type": "lat_lang_date_and_time",
                                            "lat": elements.rep_lat,
                                            "lang": elements.rep_lang
                                        };
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: api_path + "/admin/latlang.php",
                                            data: JSON.stringify(dtData),
                                        }).done(function(date_data) {
                                            var fDate = elements.date_time;
                                            var fTime = elements.visit_time;
                                            if (date_data && Array.isArray(date_data.read_date_lang) && date_data.read_date_lang.length > 0) {
                                                var rawDt = date_data.read_date_lang[0].date_time;
                                                if (rawDt) {
                                                    var dt = new Date(rawDt);
                                                    if (!isNaN(dt.getTime())) {
                                                        fDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                                                        fTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
                                                    } else {
                                                        fDate = rawDt;
                                                        fTime = "";
                                                    }
                                                }
                                            }
                                            var badgeEl = document.getElementById('dt-badge-' + uid);
                                            if (badgeEl) {
                                                badgeEl.innerHTML = "📅 " + fDate + (fTime && fTime !== "Not Logged" ? " | ⏰ " + fTime : "");
                                            }
                                        }).fail(function() {
                                            var badgeEl = document.getElementById('dt-badge-' + uid);
                                            if (badgeEl) {
                                                badgeEl.innerHTML = "📅 " + elements.date_time + (elements.visit_time && elements.visit_time !== "Not Logged" ? " | ⏰ " + elements.visit_time : "");
                                            }
                                        });

                                        geocoder.geocode({ 'location': elements.coords }, function(results, status) {
                                            var locBadge = document.getElementById('loc-badge-' + uid);
                                            if (locBadge) {
                                                if (status === 'OK') {
                                                    locBadge.innerHTML = extractCleanAddress(results);
                                                } else {
                                                    locBadge.innerHTML = "Area not found";
                                                }
                                            }
                                        });
                                    });
                                }
                            }
                        });
                    });
                }
            });
        }
    });

    function ind_shops(param, index, total) {
        var shop_image = {
            url: "assets/shop.png",
            scaledSize: new google.maps.Size(50, 50),
            labelOrigin: new google.maps.Point(25, 25)
        };

        var label = {
            text: String(index + 1),
            color: "white",
            fontSize: "14px",
            fontWeight: "bold"
        };

        var shop_maker = new google.maps.Marker({
            map: map,
            icon: shop_image,
            position: param.coords,
            animation: google.maps.Animation.DROP,
            label: label,
            title: "Visit #" + (index + 1)
        });

        allMarkers.push(shop_maker);

        const cityCircle = new google.maps.Circle({
            strokeColor: "#667eea",
            strokeOpacity: 0.8,
            strokeWeight: 4,
            fillColor: "#764ba2",
            fillOpacity: 0.25,
            map: map,
            center: param.coords,
            radius: param.meters,
        });
        allCircles.push(cityCircle);

        var popupContent = `
            <div class="info-window-content">
                <div class="visit-order">Visit #${index + 1}</div>
                <h3>${param.shop_name || param.rep_schedule_token || 'Shop Location'}</h3>
                <div class="datetime-badge">📅 ${param.date_time} | ⏰ ${param.visit_time}</div>
                <p><strong>Visit Order:</strong> ${index + 1} of ${total}</p>
                <p style="margin: 8px 0; font-size: 13px; line-height: 1.4;"><strong>Location:</strong> <br><span id="loc-badge-{UNIQUE_ID}" style="color: #0587FA;">⏳ Fetching Address...</span></p>
                <p style="font-size:10px; color:#999; margin:0;">Lat: ${param.coords.lat.toFixed(6)}, Lng: ${param.coords.lng.toFixed(6)}</p>
            </div>
        `;

        attachInteractivePopup(shop_maker, map, popupContent, function(uid) {
            geocoder.geocode({ 'location': param.coords }, function(results, status) {
                var locBadge = document.getElementById('loc-badge-' + uid);
                if (locBadge) {
                    if (status === 'OK') {
                        locBadge.innerHTML = extractCleanAddress(results);
                    } else {
                        locBadge.innerHTML = "Area not found";
                    }
                }
            });
        });
    }

    // Enhanced visual feedback for active person
    function highlightActivePerson(repToken) {
        // Remove active class from all items
        $('.delearlist ul li').removeClass('active-person');

        // Add active class to clicked person
        $('[data-sales_rep_token="' + repToken + '"]').addClass('active-person');

        // Smooth scroll to the active person
        var activeElement = $('[data-sales_rep_token="' + repToken + '"]');
        if (activeElement.length > 0) {
            $('.detailofdealer').animate({
                scrollTop: activeElement.offset().top - $('.detailofdealer').offset().top + $('.detailofdealer').scrollTop() - 100
            }, 500);
        }
    }

    // Add pulse animation to markers on hover
    function addMarkerPulse(marker) {
        var originalIcon = marker.getIcon();

        google.maps.event.addListener(marker, 'mouseover', function() {
            if (originalIcon && originalIcon.scaledSize) {
                var newIcon = {
                    url: originalIcon.url,
                    scaledSize: new google.maps.Size(
                        originalIcon.scaledSize.width * 1.2,
                        originalIcon.scaledSize.height * 1.2
                    ),
                    labelOrigin: originalIcon.labelOrigin
                };
                marker.setIcon(newIcon);
            }
        });

        google.maps.event.addListener(marker, 'mouseout', function() {
            marker.setIcon(originalIcon);
        });
    }
    </script>
</body>
</html>
<?php
}
mysqli_close($link);
?>
