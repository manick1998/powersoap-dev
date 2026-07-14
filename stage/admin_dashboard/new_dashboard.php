<?php
include "config.php";
include "$api_path/config/core.php";

if ($cookie_admin_name == "") {
    header("Location:login.php");
    exit;
}

$loggedAdminName = trim($cookie_admin_name);
$loggedAdminEmail = isset($row['email']) ? trim($row['email']) : "";
$loggedAdminPhone = isset($row['phone_number']) ? trim($row['phone_number']) : "";
$loggedAdminRole = "Sales Admin";
$loggedAdminSubtitle = $loggedAdminEmail != "" ? $loggedAdminEmail : ($loggedAdminPhone != "" ? $loggedAdminPhone : $loggedAdminRole);
$loggedAdminInitial = strtoupper(substr($loggedAdminName, 0, 1));
if ($loggedAdminInitial == "") {
    $loggedAdminInitial = "A";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerSoaps Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            --bg-body: #f4f7fe;
            --bg-card: #ffffff;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar { width: var(--sidebar-width); height: 100vh; background-color: var(--bg-card); position: fixed; top: 0; left: 0; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { height: var(--navbar-height); display: flex; align-items: center; padding: 0 24px; border-bottom: 1px solid var(--border-color); }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
        .sidebar-logo span { color: var(--primary); }
        .sidebar-menu { flex: 1; overflow-y: auto; padding: 20px 16px; list-style: none; }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .menu-item { margin-bottom: 4px; }
        .menu-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; color: var(--text-gray); text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .menu-link i { font-size: 16px; width: 20px; text-align: center; }
        .menu-link:hover { background-color: #f8fafc; color: var(--primary); }
        .menu-link.active { background: var(--primary-gradient); color: white; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2); }

        /* Sidebar Target Card */
        .sidebar-target-card { margin: 16px; background: var(--primary-gradient); border-radius: 16px; padding: 20px; color: white; position: relative; }
        .target-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .target-title { font-size: 14px; font-weight: 600; }
        .target-subtitle { font-size: 12px; color: rgba(255,255,255,0.8); margin-top: 4px; }
        .target-icon { font-size: 24px; }
        .target-stats { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
        .target-label { font-size: 12px; color: rgba(255,255,255,0.8); }
        .target-amount { font-size: 18px; font-weight: 700; margin-top: 4px; }
        .target-percent { font-size: 12px; font-weight: 600; background: rgba(255,255,255,0.2); padding: 4px 8px; border-radius: 12px; }
        .target-progress-bg { width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 8px;}
        .target-progress-fill { height: 100%; width: 87.5%; background: white; border-radius: 4px; }
        .target-footer { font-size: 11px; color: rgba(255,255,255,0.8); }

        /* ===== MAIN LAYOUT ===== */
        .main-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }

        /* ===== NAVBAR ===== */
        .navbar { height: var(--navbar-height); background-color: var(--bg-card); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 999; }
        .nav-left { display: flex; align-items: center; gap: 20px; flex: 1; }
        .menu-toggle { font-size: 20px; color: var(--text-gray); cursor: pointer; }
        .search-bar { display: flex; align-items: center; background-color: #f1f5f9; border-radius: 8px; padding: 8px 16px; width: 100%; max-width: 400px; border: 1px solid transparent; transition: all 0.3s; }
        .search-bar:focus-within { border-color: var(--primary); background: white; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
        .search-bar i { color: var(--text-light); font-size: 14px; }
        .search-bar input { border: none; background: none; outline: none; padding: 0 12px; width: 100%; font-size: 13px; color: var(--text-dark); }
        .search-shortcut { font-size: 11px; color: var(--text-light); background: #e2e8f0; padding: 4px 8px; border-radius: 4px; }
        .nav-right { display: flex; align-items: center; gap: 24px; }
        .nav-icons { display: flex; gap: 16px; }
        .nav-icon-btn { position: relative; color: var(--text-gray); font-size: 18px; cursor: pointer; }
        .nav-badge { position: absolute; top: -6px; right: -6px; background: #ef4444; color: white; font-size: 10px; font-weight: bold; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 2px solid white; }
        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .user-avatar { width: 36px; height: 36px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; }
        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .user-role { font-size: 11px; color: var(--text-gray); }
        .profile-menu-wrap { position: relative; }
        .profile-trigger { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 5px 10px; border-radius: 10px; transition: background 0.2s; border: none; background: transparent; text-align: left; }
        .profile-trigger:hover { background: #f8fafc; }
        .profile-dropdown { display: none; position: absolute; top: calc(100% + 10px); right: 0; width: 170px; background: white; border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12); padding: 6px; z-index: 1200; }
        .profile-dropdown.show { display: block; }
        .profile-dropdown a { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 6px; color: var(--danger); text-decoration: none; font-size: 13px; font-weight: 600; }
        .profile-dropdown a:hover { background: #fef2f2; }

        /* ===== CONTENT AREA ===== */
        .content { padding: 24px 30px; flex: 1; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title h1 { font-size: 24px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px;}
        .page-title p { font-size: 14px; color: var(--text-gray); }
        .date-picker-btn { display: flex; align-items: center; gap: 10px; background: white; border: 1px solid var(--border-color); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; }

        /* Export Button Styles */
        .export-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }
        .export-btn:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Card Styles */
        .card { background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .card-title { font-size: 24px; font-weight: 600; color: var(--text-dark); }
        .dropdown-select { font-size: 17px; color: var(--text-gray); border: 1px solid var(--border-color); padding: 6px 12px; border-radius: 6px; cursor: pointer; background: #f8fafc; outline: none; font-family: inherit; transition: all 0.2s;}
        .scroll-table-wrapper, .scroll-list-wrapper { max-height: 280px; overflow-y: auto; padding-right: 8px; }
        .scroll-table-wrapper table { width: 100%; }
        .scroll-list-wrapper { padding-right: 4px; }
        .scroll-list-wrapper .list-container { display: flex; flex-direction: column; gap: 16px; }
        .scroll-table-wrapper::-webkit-scrollbar, .scroll-list-wrapper::-webkit-scrollbar { width: 6px; }
        .scroll-table-wrapper::-webkit-scrollbar-thumb, .scroll-list-wrapper::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.6); border-radius: 999px; }
        .scroll-table-wrapper::-webkit-scrollbar-track, .scroll-list-wrapper::-webkit-scrollbar-track { background: transparent; }
        .dropdown-select:focus { border-color: var(--primary); box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.1); background: white;}

        /* Grids */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px; }
        .charts-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .city-sales-grid { display: grid; grid-template-columns: 1fr; margin-bottom: 20px; }
        .lower-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .bottom-grid { display: grid; grid-template-columns: 2fr 1.5fr; gap: 20px; margin-bottom: 20px; }
        .extra-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }

        /* Stat Cards */
        .stat-card { display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: white; }
        .bg-purple { background: #8b5cf6; } .bg-green { background: #10b981; } .bg-blue { background: #3b82f6; } .bg-orange { background: #f59e0b; }
        .stat-details { display: flex; flex-direction: column; gap: 4px;}
        .stat-label { font-size: 13px; color: var(--text-gray); font-weight: 500;}
        .stat-value { font-size: 22px; font-weight: 700; color: var(--text-dark); }
        .stat-trend { font-size: 12px; font-weight: 500; display: flex; align-items: center; gap: 4px;}
        .text-green { color: var(--success); } .text-gray { color: var(--text-gray); font-weight: 400;} .text-danger { color: var(--danger); }

        /* Line Chart Area */
        .line-chart-wrapper { height: 260px; position: relative; }
        .chart-badge { position: absolute; right: 0; top: 20px; background: var(--primary); color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .y-axis { position: absolute; left: 0; top: 0; bottom: 30px; display: flex; flex-direction: column; justify-content: space-between; font-size: 11px; color: var(--text-light); }
        .x-axis { position: absolute; bottom: 0; left: 40px; right: 0; display: flex; justify-content: space-between; font-size: 11px; color: var(--text-light); padding-top: 10px; border-top: 1px dashed var(--border-color);}
        .chart-svg { position: absolute; left: 40px; top: 0; width: calc(100% - 40px); height: calc(100% - 30px); }

        /* Donut Chart Area */
        .donut-container { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; position: relative; width:25px; flex:1;margin-left:50px; margin-bottom:45px; padding:45px;}
        .donut-wrapper .svg
        .donut-wrapper { position: relative; width: 150px; height: 150px; margin-bottom: 20px;}
        .donut-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;}
        .donut-center span { display: block; font-size: 11px; color: var(--text-gray); }
        .donut-center strong { display: block; font-size: 14px; color: var(--text-dark); }
        .legend-grid { display: grid; grid-template-columns: 1fr 1fr; width: 100%; column-gap: 30px; row-gap: 12px;}
        .legend-item { display: flex; justify-content: space-between; align-items: center; font-size: 12px; }
        .legend-label { display: flex; align-items: center; gap: 8px; color: var(--text-gray);}
        .legend-dot { width: 10px; height: 10px; border-radius: 3px; }

        /* ENHANCED: Sales by City with Executives & Products */
        .city-sales-body-enhanced {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        .city-main-card {
            display: flex;
            align-items: center;
            gap: 28px;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 1px solid var(--border-color);
            padding: 32px 48px;
            border-radius: 24px;
            transition: all 0.3s ease;
        }
        .city-main-card:hover {
            box-shadow: 0 12px 28px rgba(124, 58, 237, 0.08);
            border-color: rgba(124, 58, 237, 0.2);
        }
        .metric-icon-large {
            width: 88px;
            height: 88px;
            background: #ede9fe;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin-left: 384px;
        }
        .metric-info-large {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .metric-label-large {
            font-size: 16px;
            color: var(--text-gray);
            font-weight: 500;
        }
        .metric-label-large span {
            color: var(--text-dark);
            font-weight: 700;
        }
        .metric-value-large {
            font-size: 52px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
        }
        .city-details-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        .detail-card {
            background: #fafcff;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            padding: 20px;
        }
        .detail-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--primary);
            padding-left: 12px;
        }
        .executive-item, .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f2f6;
        }
        .executive-item:last-child, .product-item:last-child {
            border-bottom: none;
        }
        .executive-name {
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .executive-badge {
            width: 32px;
            height: 32px;
            background: #e9eef3;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: bold;
            color: var(--primary);
        }
        .executive-sales, .product-sales {
            font-weight: 700;
            color: var(--text-dark);
        }
        .product-name {
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .product-name i {
            color: var(--primary);
            width: 24px;
        }
        span#displayCityName {
                font-size: 29px;
            }
        
        /* Lists */
        .list-container { display: flex; flex-direction: column; gap: 16px; }
        .list-item { display: flex; justify-content: space-between; align-items: center; gap: 12px;}
        .list-left { display: flex; align-items: center; gap: 12px; flex: 1;}
        .list-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;}
        .list-info h4 { font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 2px;}
        .list-info p { font-size: 12px; color: var(--text-gray); }
        .list-right { text-align: right; }
        .list-right strong { display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .list-right span { display: block; font-size: 11px; color: var(--text-light); }

        /* Icon Colors */
        .ic-green { background: #d1fae5; color: #10b981; }
        .ic-yellow { background: #fef3c7; color: #f59e0b; }
        .ic-blue { background: #dbeafe; color: #3b82f6; }
        .ic-purple { background: #ede9fe; color: #8b5cf6; }
        .ic-red { background: #fee2e2; color: #ef4444; }
        .ic-pink { background: #fce7f3; color: #ec4899; }
        
        /* Modules & Quick Actions */
        .modules-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .module-item { display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: 12px; cursor: pointer; transition: 0.2s; }
        .module-item:hover { border-color: var(--primary); background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);}
        .mod-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;}
        
        .quick-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .quick-item { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 16px 10px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: 12px; cursor: pointer; transition: 0.2s; text-align: center; }
        .quick-item:hover { border-color: var(--primary); background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.04);}
        .quick-item i { font-size: 20px; }
        .quick-item span { font-size: 12px; font-weight: 500; color: var(--text-dark); }

        /* Tables */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; font-size: 12px; font-weight: 500; color: var(--text-light); padding-bottom: 12px; border-bottom: 1px solid var(--border-color); }
        .data-table td { padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: var(--text-dark); font-weight: 500;}
        .data-table tr:last-child td { border-bottom: none; padding-bottom: 0;}
        .rep-cell { display: flex; align-items: center; gap: 10px; }
        .rep-initial { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: white;}
        .prog-container { display: flex; align-items: center; gap: 10px; }
        .prog-bar { flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;}
        .prog-fill { height: 100%; border-radius: 3px; }
        .prog-text { font-size: 12px; color: var(--text-gray); width: 35px; text-align: right;}

        /* Stock Status */
        .status-critical { color: var(--danger); font-weight: 700; }
        .status-warning { color: var(--warning); font-weight: 700; }

        .footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 30px; border-top: 1px solid var(--border-color); font-size: 12px; color: var(--text-light); }
    
    
    
    
    
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img class="logo" src="assets/logo.png" alt="logo" style="width: 145px; height: 50px; object-fit: contain;">
                
            </div>
        </div>

        <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            $sidebarMenus = [
                ['label' => 'Dashboard', 'icon' => 'fas fa-border-all', 'url' => 'new_dashboard.php', 'pages' => ['new_dashboard.php']],
                ['label' => 'Live Tracking', 'icon' => 'fas fa-location-crosshairs', 'url' => 'livetrack.php', 'pages' => ['livetrack.php', 'livetrack_sales_rep.php']],
                ['label' => 'Order Management', 'icon' => 'fas fa-file-invoice', 'url' => 'distributor_order.php', 'pages' => ['distributor_order.php']],
                ['label' => 'Inventory Management', 'icon' => 'fas fa-boxes-stacked', 'url' => 'division.php', 'pages' => ['division.php']],
                ['label' => 'Distributor Management', 'icon' => 'fas fa-truck-fast', 'url' => 'employees.php', 'pages' => ['employees.php', 'employees_detail.php']],
                ['label' => 'Region Management', 'icon' => 'fas fa-map-location-dot', 'url' => 'region.php', 'pages' => ['region.php']],
                ['label' => 'Retailer Management', 'icon' => 'fas fa-shop', 'url' => 'retailer.php', 'pages' => ['retailer.php', 'retailer_view.php', 'retailer-request.php', 'retailer_onboard.php', 'shop-list.php']],
                ['label' => 'Sales Rep', 'icon' => 'far fa-user', 'url' => 'sales-rep.php', 'pages' => ['sales-rep.php', 'sales_rep_role.php', 'sales_rep_report.php']],
                ['label' => 'Daily Summary', 'icon' => 'fas fa-calendar-day', 'url' => 'daily.php', 'pages' => ['daily.php']],
                ['label' => 'Schedule Management', 'icon' => 'far fa-calendar-check', 'url' => 'daily-schedule.php', 'pages' => ['daily-schedule.php', 'scheduleSalesRep.php', 'schedule_create.php']],
                ['label' => 'Reports & Analytics', 'icon' => 'fas fa-chart-simple', 'url' => 'report_dashboard.php', 'pages' => ['report_dashboard.php', 'state_report.php', 'stateWise_report.php', 'sales_order_report.php', 'distributorOrderReport.php', 'distributorPurchaseReport.php']],
                ['label' => 'Offer Management', 'icon' => 'fas fa-tags', 'url' => 'offer.php', 'pages' => ['offer.php', 'discount.php', 'Scheme.php', 'overall_productoff_report.php', 'schem_product_report.php']],
                ['label' => 'Communication', 'icon' => 'far fa-envelope', 'url' => 'notification_list.php', 'pages' => ['notification_list.php']],
                ['label' => 'User Roles & Access', 'icon' => 'fas fa-users-gear', 'url' => 'user-role.php', 'pages' => ['user-role.php']],
                ['label' => 'Policy', 'icon' => 'fas fa-file-shield', 'url' => 'privacy-policy.php', 'pages' => ['privacy-policy.php', 'terms-condition.php', 'About_us.php']],
                ['label' => 'Support Management', 'icon' => 'fas fa-headset', 'url' => 'Support.php', 'pages' => ['Support.php']],
                ['label' => 'Log Management', 'icon' => 'fas fa-clipboard-list', 'url' => 'log.php', 'pages' => ['log.php', 'order_log.php', 'product_log.php', 'offer_log.php', 'salesRep_log.php', 'shop_create_log.php', 'admin_stock_log.php']],
                ['label' => 'Settings', 'icon' => 'fas fa-gear', 'url' => 'setting.php', 'pages' => ['setting.php', 'unit-grouping.php', 'shop_type.php', 'slot.php']],
            ];
        ?>
        <ul class="sidebar-menu">
            <?php foreach ($sidebarMenus as $menu): ?>
                <?php $isActive = in_array($currentPage, $menu['pages'], true); ?>
                <li class="menu-item">
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="menu-link<?php echo $isActive ? ' active' : ''; ?>">
                        <i class="<?php echo htmlspecialchars($menu['icon']); ?>"></i> <?php echo htmlspecialchars($menu['label']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="sidebar-target-card">
            <div class="target-header">
                <div>
                    <div class="target-title">Sales Target</div>
                    <div class="target-subtitle">April 2025</div>
                </div>
                <div class="target-icon">🎯</div>
            </div>
            <div class="target-stats">
                <div>
                    <div class="target-label">Achieved</div>
                    <div class="target-amount">₹8,75,000</div>
                </div>
                <div class="target-percent">87.5%</div>
            </div>
            <div class="target-progress-bg">
                <div class="target-progress-fill"></div>
            </div>
            <div class="target-footer">Target: ₹10,00,000</div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="navbar">
    <div class="nav-left" style="display:flex; align-items:center; gap:20px; flex:1;">

        <i class="fas fa-bars menu-toggle"></i>

        <div id="searchBox"
            style="display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1.5px solid transparent; border-radius:10px; padding:0 14px; height:40px; cursor:text; transition:all 0.2s; width:100%; max-width:420px;"
            onmouseenter="this.style.borderColor='#c4b5fd'"
            onmouseleave="if(document.activeElement.closest && !document.activeElement.closest('#searchBox')) this.style.borderColor='transparent'">
            <i class="fas fa-search" style="font-size:13px; color:#94a3b8; flex-shrink:0;"></i>
            <input type="text"
                placeholder="Search modules, reports, retailers..."
                style="border:none; background:transparent; outline:none; padding:0; width:100%; font-size:13px; color:var(--text-dark); font-family:'Inter',sans-serif;"
                onfocus="
                    document.getElementById('searchBox').style.borderColor='#7c3aed';
                    document.getElementById('searchBox').style.background='white';
                    document.getElementById('searchBox').style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'
                "
                onblur="
                    document.getElementById('searchBox').style.borderColor='transparent';
                    document.getElementById('searchBox').style.background='#f1f5f9';
                    document.getElementById('searchBox').style.boxShadow='none'
                ">
            <!-- <div style="display:flex; align-items:center; gap:3px; flex-shrink:0;">
                <kbd style="font-size:10px; font-family:'Inter',sans-serif; color:#94a3b8; background:white; border:1px solid #e2e8f0; border-radius:5px; padding:2px 6px; line-height:1.6;">Ctrl</kbd>
                <kbd style="font-size:10px; font-family:'Inter',sans-serif; color:#94a3b8; background:white; border:1px solid #e2e8f0; border-radius:5px; padding:2px 6px; line-height:1.6;">K</kbd>
            </div> -->
        </div>
    </div>

    <div class="nav-right" style="display:flex; align-items:center; gap:20px;">

        <div style="display:flex; align-items:center; gap:18px;">

            <div style="position:relative; cursor:pointer;">
                <i class="far fa-bell" style="font-size:19px; color:var(--text-gray);"></i>
                <span style="position:absolute; top:-5px; right:-6px; width:16px; height:16px; background:#ef4444; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:white; border:2px solid white;">5</span>
            </div>

            <div style="position:relative; cursor:pointer;">
                <i class="far fa-comment-dots" style="font-size:19px; color:var(--text-gray);"></i>
                <span style="position:absolute; top:-5px; right:-6px; width:16px; height:16px; background:#ef4444; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:white; border:2px solid white;">8</span>
            </div>
        </div>

        <div style="width:1px; height:24px; background:var(--border-color);"></div>

        <div class="profile-menu-wrap">
            <button type="button" class="profile-trigger" id="profileMenuButton" aria-expanded="false" aria-controls="profileDropdown">
                <div style="width:34px; height:34px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:white; flex-shrink:0;"><?php echo htmlspecialchars($loggedAdminInitial); ?></div>
                <div>
                    <div style="font-size:13px; font-weight:600; color:var(--text-dark); line-height:1.3;"><?php echo htmlspecialchars($loggedAdminName); ?></div>
                    <div style="font-size:11px; color:var(--text-gray); line-height:1.3;"><?php echo htmlspecialchars($loggedAdminSubtitle); ?></div>
                </div>
                <i class="fas fa-chevron-down" style="font-size:10px; color:var(--text-gray); margin-left:2px;"></i>
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>

    </div>
</div>

        

        <div class="content">
            
            <div class="page-header">
                <div class="page-title">
                    <h1>Welcome back, <?php echo htmlspecialchars($loggedAdminName); ?>! 👋</h1>
                    <p>Here's what's happening with your business today.</p>
                </div>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button class="export-btn" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export
                    </button>
                    <div class="date-picker-btn">
                        May 14, 2025 <i class="far fa-calendar"></i>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="card stat-card">
                    <div class="stat-icon bg-purple"><i class="fas fa-chart-line"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Total Sales Today</div>
                        <div class="stat-value">₹18,75,000</div>
                        <div class="stat-trend text-green">15.8% vs yesterday</div>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="stat-icon bg-blue"><i class="fas fa-file-invoice"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Primary Order Value</div>
                        <div class="stat-value">₹8,45,000</div>
                        <div class="stat-trend text-green">12.3% vs yesterday</div>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="stat-icon bg-green"><i class="fas fa-layer-group"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Secondary Order Value</div>
                        <div class="stat-value">₹10,30,000</div>
                        <div class="stat-trend text-green">18.6% vs yesterday</div>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="stat-icon bg-orange"><i class="fas fa-users"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Active Distributors</div>
                        <div class="stat-value">128</div>
                        <div class="stat-trend text-green">5.2% vs last month</div>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="stat-icon bg-purple"><i class="fas fa-store"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Retailer Activity</div>
                        <div class="stat-value">356</div>
                        <div class="stat-trend text-green">New this month 42</div>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="stat-icon bg-blue"><i class="fas fa-user-check"></i></div>
                    <div class="stat-details">
                        <div class="stat-label">Active Sales Reps</div>
                        <div class="stat-value">256</div>
                        <div class="stat-trend text-green">7.3% vs last month</div>
                    </div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Monthly Sales Overview</div>
                        <select class="dropdown-select">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <div class="line-chart-wrapper">
                        <div class="chart-badge">₹1,25,000</div>
                        <div class="y-axis">
                            <span>₹2.0L</span><span>₹1.5L</span><span>₹1.0L</span><span>₹50K</span><span>₹0</span>
                        </div>
                        <svg class="chart-svg" viewBox="0 0 500 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lineFill" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.2"/>
                                    <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,180 C40,160 80,180 120,150 C160,120 200,140 240,100 C280,60 320,120 360,110 C400,100 450,80 500,80 L500,220 L0,220 Z" fill="url(#lineFill)" />
                            <path d="M0,180 C40,160 80,180 120,150 C160,120 200,140 240,100 C280,60 320,120 360,110 C400,100 450,80 500,80" fill="none" stroke="#8b5cf6" stroke-width="3" />
                            <circle cx="500" cy="80" r="5" fill="#8b5cf6" stroke="white" stroke-width="2"/>
                            <line x1="0" y1="0" x2="500" y2="0" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="55" x2="500" y2="55" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="110" x2="500" y2="110" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="165" x2="500" y2="165" stroke="#f1f5f9" stroke-width="1" />
                        </svg>
                        <div class="x-axis">
                            <span>1 May</span><span>5 May</span><span>9 May</span><span>13 May</span><span>17 May</span><span>21 May</span><span>25 May</span><span>31 May</span>
                        </div>
                    </div>
                </div>

              

                <div class="card" style="display: flex; flex-direction: column;">
                    <div class="card-header">
                        <div class="card-title">Sales by State</div>
                        <select class="dropdown-select">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 2rem; flex: 1;">

                        <!-- Donut Chart -->
                        <div style="position: relative; width: 160px; height: 160px; flex-shrink: 0;">
                            <canvas id="donutChart" width="160" height="160"></canvas>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                                <div style="font-size: 11px; color: var(--text-gray); margin-bottom: 2px;">Total</div>
                                <div style="font-size: 13px; font-weight: 700; color: var(--text-dark);">₹12,45,000</div>
                            </div>
                        </div>

                        <!-- Detailed Table -->
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                            <!-- Header Row -->
                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding-bottom: 8px; border-bottom: 2px solid var(--border-color);">
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-light);">State</div>
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-light);">Amount</div>
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-light); text-align: right;">Percentage</div>
                            </div>

                            <!-- Data Rows -->
                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #8b5cf6; flex-shrink: 0;"></span>
                                    <span style="color: var(--text-gray);">Tamil Nadu</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">₹4,35,750</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right;">35.0%</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #3b82f6; flex-shrink: 0;"></span>
                                    <span style="color: var(--text-gray);">Kerala</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">₹3,48,600</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right;">28.0%</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #10b981; flex-shrink: 0;"></span>
                                    <span style="color: var(--text-gray);">Karnataka</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">₹2,49,000</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right;">20.0%</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #f59e0b; flex-shrink: 0;"></span>
                                    <span style="color: var(--text-gray);">Andhra Pradesh</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">₹1,49,400</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right;">12.0%</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1.2fr 1fr 0.8fr; gap: 12px; padding: 10px 0; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #ef4444; flex-shrink: 0;"></span>
                                    <span style="color: var(--text-gray);">Telangana</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">₹62,250</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right;">5.0%</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Notifications</div>
                    </div>
                    <div class="list-container">
                        <div class="list-item">
                            <div class="list-icon ic-green"><i class="fas fa-shopping-cart"></i></div>
                            <div class="list-info" style="flex:1;">
                                <h4>New order received</h4>
                                <p>Order #ORD-5247 placed</p>
                            </div>
                            <div class="list-right"><span>5m ago</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-icon ic-yellow"><i class="fas fa-triangle-exclamation"></i></div>
                            <div class="list-info" style="flex:1;">
                                <h4>Low stock alert</h4>
                                <p>15 products running low</p>
                            </div>
                            <div class="list-right"><span>15m ago</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-icon ic-blue"><i class="fas fa-truck-fast"></i></div>
                            <div class="list-info" style="flex:1;">
                                <h4>Delivery update</h4>
                                <p>8 deliveries are out</p>
                            </div>
                            <div class="list-right"><span>30m ago</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-icon ic-purple"><i class="fas fa-bullseye"></i></div>
                            <div class="list-info" style="flex:1;">
                                <h4>Target achieved</h4>
                                <p>Arun reached 100%</p>
                            </div>
                            <div class="list-right"><span>1h ago</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="city-sales-grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Sales by Specific City</div>
                        <div style="display: flex; gap: 10px;  margin-right: 649px;">
                            <select id="stateSelector" class="dropdown-select" style="font-weight: 600; color: var(--primary);">
                                <option value="TN" selected>Tamil Nadu</option>
                                <option value="KL">Kerala</option>
                                <option value="KA">Karnataka</option>
                            </select>
                            <select id="citySelector" class="dropdown-select" style="font-weight: 600; color: var(--primary); "></select>
                        </div>
                    </div>
                    
                    <div class="city-sales-body-enhanced">
                        <div class="city-main-card">
                            <div class="metric-icon-large">
                                <i class="fas fa-city"></i>
                            </div>
                            <div class="metric-info-large">
                                <span class="metric-label-large">Total Sales in <span id="displayCityName">Bangalore</span></span>
                                <strong class="metric-value-large" id="displayCityTotal">₹6,10,000</strong>
                            </div>
                        </div>

                        <div class="city-details-row">
                            <div class="detail-card">
                                <div class="detail-title">
                                    <i class="fas fa-user-tie" style="color: var(--primary);"></i> Top Sales Executives
                                </div>
                                <div id="executivesList">
                                    </div>
                            </div>

                            <div class="detail-card">
                                <div class="detail-title">
                                    <i class="fas fa-chart-line" style="color: var(--primary);"></i> Top Products
                                </div>
                                <div id="productsList">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lower-grid">
                <div class="card">
                    <div class="card-header"><div class="card-title">Modules Shortcuts</div></div>
                    <div class="modules-grid">
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-blue"><i class="fas fa-truck"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Live Tracking</div><div style="font-size: 11px; color: var(--text-gray);">48 Active</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-green"><i class="fas fa-file-invoice"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Order Mgmt</div><div style="font-size: 11px; color: var(--text-gray);">254 Pending</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-yellow"><i class="fas fa-boxes-stacked"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Inventory</div><div style="font-size: 11px; color: var(--text-gray);">1,245 Items</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-blue"><i class="fas fa-users"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Distributors</div><div style="font-size: 11px; color: var(--text-gray);">128 Total</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-green"><i class="fas fa-shop"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Retailers</div><div style="font-size: 11px; color: var(--text-gray);">560 Active</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                        <div class="module-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="mod-icon ic-purple"><i class="far fa-user"></i></div>
                                <div><div style="font-size: 13px; font-weight: 600;">Sales Rep</div><div style="font-size: 11px; color: var(--text-gray);">24 Active</div></div>
                            </div>
                            <i class="fas fa-chevron-right" style="font-size: 12px; color: var(--text-light);"></i>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><div class="card-title">Quick Actions</div></div>
                    <div class="quick-grid">
                        <div class="quick-item"><i class="fas fa-plus" style="color: #3b82f6;"></i><span>Create Order</span></div>
                        <div class="quick-item"><i class="fas fa-user-plus" style="color: #f59e0b;"></i><span>Add Retailer</span></div>
                        <div class="quick-item"><i class="fas fa-building" style="color: #06b6d4;"></i><span>Add Dist.</span></div>
                        <div class="quick-item"><i class="fas fa-gift" style="color: #8b5cf6;"></i><span>Create Offer</span></div>
                        <div class="quick-item"><i class="fas fa-chart-bar" style="color: #10b981;"></i><span>Reports</span></div>
                        <div class="quick-item"><i class="fas fa-download" style="color: #64748b;"></i><span>Download</span></div>
                    </div>
                </div>
            </div>

            <div class="bottom-grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Sales Rep Performance</div>
                    </div>
                    <div class="scroll-table-wrapper">
                        <table class="data-table">
                        <thead>
                            <tr>
                                <th>Sales Rep</th>
                                <th>Achieved</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="rep-cell"><div class="rep-initial" style="background: #bfdbfe; color: #1d4ed8">K</div><span>Kumar</span></div></td>
                                <td>₹95,000</td>
                                <td><div class="prog-container"><div class="prog-bar"><div class="prog-fill" style="width: 95%; background: #10b981;"></div></div><span class="prog-text">95%</span></div></td>
                            </tr>
                            <tr>
                                <td><div class="rep-cell"><div class="rep-initial" style="background: #e9d5ff; color: #6d28d9">A</div><span>Arun Kumar</span></div></td>
                                <td>₹82,000</td>
                                <td><div class="prog-container"><div class="prog-bar"><div class="prog-fill" style="width: 82%; background: #f59e0b;"></div></div><span class="prog-text">82%</span></div></td>
                            </tr>
                            <tr>
                                <td><div class="rep-cell"><div class="rep-initial" style="background: #fbcfe8; color: #be185d">R</div><span>Raja</span></div></td>
                                <td>₹1,10,000</td>
                                <td><div class="prog-container"><div class="prog-bar"><div class="prog-fill" style="width: 100%; background: #10b981;"></div></div><span class="prog-text">110%</span></div></td>
                            </tr>
                            <tr>
                                <td><div class="rep-cell"><div class="rep-initial" style="background: #fecdd3; color: #b91c1c">S</div><span>Sasi</span></div></td>
                                <td>₹75,000</td>
                                <td><div class="prog-container"><div class="prog-bar"><div class="prog-fill" style="width: 75%; background: #ef4444;"></div></div><span class="prog-text">75%</span></div></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div class="card-title">Top Selling Products</div>
                        </div>
                        <select class="dropdown-select">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <div class="list-container">
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-blue"><i class="fas fa-bottle-droplet"></i></div>
                                <div class="list-info"><h4>Power Wash Detergent</h4><p>Washing Powder</p></div>
                            </div>
                            <div class="list-right"><strong>₹2,45,000</strong><span class="text-green">↑ 18.6%</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-purple"><i class="fas fa-spray-can"></i></div>
                                <div class="list-info"><h4>Shine Dishwash Liquid</h4><p>Kitchen Care</p></div>
                            </div>
                            <div class="list-right"><strong>₹1,85,000</strong><span class="text-green">↑ 14.2%</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-green"><i class="fas fa-soap"></i></div>
                                <div class="list-info"><h4>Power Soaps Bar</h4><p>Bathing Soap</p></div>
                            </div>
                            <div class="list-right"><strong>₹1,25,000</strong><span class="text-green">↑ 9.8%</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-pink"><i class="fas fa-jug-detergent"></i></div>
                                <div class="list-info"><h4>Fabric Softener</h4><p>Liquid Care</p></div>
                            </div>
                            <div class="list-right"><strong>₹95,000</strong><span class="text-green">↑ 7.1%</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="extra-grid">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div class="card-title">Top 5 Distributors</div>
                        </div>
                        <select class="dropdown-select" id="topDistributorRange">
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                        </select>
                    </div>
                    <div class="list-container" id="topDistributorsList">
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-purple"><i class="fas fa-spinner fa-spin"></i></div>
                                <div class="list-info"><h4>Loading distributors...</h4><p>Please wait</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Top 5 Low Stock Alerts</div>
                        <a href="#" style="font-size: 13px; color: var(--primary); text-decoration: none; font-weight: 500;">Reorder All</a>
                    </div>
                    <div class="list-container">
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-red"><i class="fas fa-box-open"></i></div>
                                <div class="list-info"><h4>Power Wash 500g Pack</h4><p>SKU: PW-500G</p></div>
                            </div>
                            <div class="list-right"><strong class="status-critical">8 Units</strong><span>Critical</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-red"><i class="fas fa-box-open"></i></div>
                                <div class="list-info"><h4>Shine Dishwash 250ml</h4><p>SKU: SD-250ML</p></div>
                            </div>
                            <div class="list-right"><strong class="status-critical">12 Units</strong><span>Critical</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-yellow"><i class="fas fa-cubes"></i></div>
                                <div class="list-info"><h4>Power Soaps Bar (Pack of 4)</h4><p>SKU: PS-P4</p></div>
                            </div>
                            <div class="list-right"><strong class="status-warning">24 Units</strong><span>Warning</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-yellow"><i class="fas fa-cubes"></i></div>
                                <div class="list-info"><h4>Fabric Softener 1L</h4><p>SKU: FS-1L</p></div>
                            </div>
                            <div class="list-right"><strong class="status-warning">35 Units</strong><span>Warning</span></div>
                        </div>
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-yellow"><i class="fas fa-cubes"></i></div>
                                <div class="list-info"><h4>Handwash Liquid Refill</h4><p>SKU: HW-REF</p></div>
                            </div>
                            <div class="list-right"><strong class="status-warning">42 Units</strong><span>Warning</span></div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <div class="footer">
            <div>© 2026 PowerSoaps. All rights reserved.</div>
            <div>Version 2.0.0</div>
        </div>

    </div>

    <script>
        const dashboardApiPath = <?php echo json_encode($api_path); ?>;
        const dashboardVerificationCode = <?php echo json_encode($verification_code); ?>;

        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', function (event) {
                event.stopPropagation();
                const isOpen = profileDropdown.classList.toggle('show');
                profileMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function () {
                profileDropdown.classList.remove('show');
                profileMenuButton.setAttribute('aria-expanded', 'false');
            });

            profileDropdown.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        }

        const topDistributorRange = document.getElementById('topDistributorRange');
        const topDistributorsList = document.getElementById('topDistributorsList');
        const distributorIconStyles = [
            { className: 'ic-purple', icon: 'fas fa-building' },
            { className: 'ic-blue', icon: 'fas fa-building' },
            { className: 'ic-green', icon: 'fas fa-truck-moving' },
            { className: 'ic-yellow', icon: 'fas fa-store' },
            { className: 'ic-pink', icon: 'fas fa-building-circle-check' }
        ];

        function toLocalDateInputValue(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function getDistributorDateRange(rangeType) {
            const today = new Date();
            const firstDay = rangeType === 'last_month'
                ? new Date(today.getFullYear(), today.getMonth() - 1, 1)
                : new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = rangeType === 'last_month'
                ? new Date(today.getFullYear(), today.getMonth(), 0)
                : today;

            return {
                from_date: toLocalDateInputValue(firstDay),
                to_date: toLocalDateInputValue(lastDay)
            };
        }

        function getPreviousDistributorDateRange(rangeType) {
            const today = new Date();
            const selectedFirstDay = rangeType === 'last_month'
                ? new Date(today.getFullYear(), today.getMonth() - 1, 1)
                : new Date(today.getFullYear(), today.getMonth(), 1);
            const previousFirstDay = new Date(selectedFirstDay.getFullYear(), selectedFirstDay.getMonth() - 1, 1);
            const previousLastDay = new Date(selectedFirstDay.getFullYear(), selectedFirstDay.getMonth(), 0);

            return {
                from_date: toLocalDateInputValue(previousFirstDay),
                to_date: toLocalDateInputValue(previousLastDay)
            };
        }

        function formatIndianCurrency(value) {
            const numberValue = Number(value || 0);
            return '₹' + numberValue.toLocaleString('en-IN', {
                maximumFractionDigits: 0
            });
        }

        function getTrendText(currentValue, previousValue) {
            const current = Number(currentValue || 0);
            const previous = Number(previousValue || 0);

            if (previous <= 0 && current > 0) {
                return { text: 'New', className: 'text-green' };
            }

            if (previous <= 0) {
                return { text: '0%', className: 'text-gray' };
            }

            const change = ((current - previous) / previous) * 100;
            return {
                text: `${change >= 0 ? '↑' : '↓'} ${Math.abs(change).toFixed(1)}%`,
                className: change >= 0 ? 'text-green' : 'text-danger'
            };
        }

        function updateTrendElement(elementId, currentValue, previousValue) {
            const element = document.getElementById(elementId);
            if (!element) return;

            const trend = getTrendText(currentValue, previousValue);
            element.textContent = trend.text;
            element.className = trend.className;
        }

        function loadOverviewStats() {
            fetch(`${dashboardApiPath}/admin/reportAndAnalytics.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    dashboard_code: dashboardVerificationCode,
                    type: 'admin_overview_stats'
                })
            })
                .then(function (response) {
                    if (!response.ok) throw new Error('Unable to load overview stats');
                    return response.json();
                })
                .then(function (data) {
                    const stats = data.stats || {};

                    document.getElementById('todayOrdersValue').textContent = Number(stats.today_orders || 0).toLocaleString('en-IN');
                    document.getElementById('todaySalesValue').textContent = formatIndianCurrency(stats.today_sales || 0);
                    document.getElementById('activeDeliveriesValue').textContent = Number(stats.active_deliveries || 0).toLocaleString('en-IN');
                    document.getElementById('activeRetailersValue').textContent = Number(stats.active_retailers || 0).toLocaleString('en-IN');

                    updateTrendElement('todayOrdersTrend', stats.today_orders, stats.yesterday_orders);
                    updateTrendElement('todaySalesTrend', stats.today_sales, stats.yesterday_sales);
                    updateTrendElement('activeDeliveriesTrend', stats.active_deliveries, stats.yesterday_active_deliveries);
                    updateTrendElement('activeRetailersTrend', stats.active_retailers, stats.yesterday_active_retailers);
                })
                .catch(function () {
                    ['todayOrdersTrend', 'todaySalesTrend', 'activeDeliveriesTrend', 'activeRetailersTrend'].forEach(function (elementId) {
                        const element = document.getElementById(elementId);
                        if (element) {
                            element.textContent = 'Unable to load';
                            element.className = 'text-danger';
                        }
                    });
                });
        }

        function formatDistributorTrend(currentSales, previousSales) {
            const current = Number(currentSales || 0);
            const previous = Number(previousSales || 0);

            if (previous <= 0 && current > 0) {
                return { text: 'New', color: 'var(--success)' };
            }

            if (previous <= 0) {
                return { text: '0%', color: 'var(--text-light)' };
            }

            const change = ((current - previous) / previous) * 100;
            const arrow = change >= 0 ? '↑' : '↓';
            return {
                text: `${arrow} ${Math.abs(change).toFixed(1)}%`,
                color: change >= 0 ? 'var(--success)' : 'var(--danger)'
            };
        }

        function escapeHtml(value) {
            return String(value || '').replace(/[&<>"']/g, function (char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char];
            });
        }

        function renderTopDistributors(distributors, previousDistributors) {
            if (!topDistributorsList) return;

            const topFive = Array.isArray(distributors) ? distributors.slice(0, 5) : [];
            const previousSalesByName = {};

            if (Array.isArray(previousDistributors)) {
                previousDistributors.forEach(function (item) {
                    previousSalesByName[String(item.distributor_name || '').toLowerCase()] = Number(item.distributor_sales || 0);
                });
            }

            if (topFive.length === 0) {
                topDistributorsList.innerHTML = `
                    <div class="list-item">
                        <div class="list-left">
                            <div class="list-icon ic-yellow"><i class="fas fa-circle-info"></i></div>
                            <div class="list-info"><h4>No Records Found</h4><p>Try another month</p></div>
                        </div>
                    </div>
                `;
                return;
            }

            topDistributorsList.innerHTML = topFive.map(function (item, index) {
                const iconStyle = distributorIconStyles[index] || distributorIconStyles[0];
                const name = escapeHtml(item.distributor_name || 'Distributor');
                const amount = formatIndianCurrency(item.distributor_sales);
                const previousSales = previousSalesByName[String(item.distributor_name || '').toLowerCase()] || 0;
                const trend = formatDistributorTrend(item.distributor_sales, previousSales);

                return `
                    <div class="list-item">
                        <div class="list-left">
                            <div class="list-icon ${iconStyle.className}"><i class="${iconStyle.icon}"></i></div>
                            <div class="list-info"><h4>${name}</h4><p>Distributor</p></div>
                        </div>
                        <div class="list-right"><strong>${amount}</strong><span style="color:${trend.color};">${trend.text}</span></div>
                    </div>
                `;
            }).join('');
        }

        function fetchTopDistributors(dates) {
            return fetch(`${dashboardApiPath}/admin/reportAndAnalytics.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    dashboard_code: dashboardVerificationCode,
                    type: 'top_distributor',
                    from_date: dates.from_date,
                    to_date: dates.to_date
                })
            })
                .then(function (response) {
                    if (!response.ok) throw new Error('Unable to load distributors');
                    return response.json();
                })
                .then(function (data) {
                    return data.dist_Data || [];
                });
        }

        function loadTopDistributors() {
            if (!topDistributorRange || !topDistributorsList) return;

            topDistributorsList.innerHTML = `
                <div class="list-item">
                    <div class="list-left">
                        <div class="list-icon ic-purple"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="list-info"><h4>Loading distributors...</h4><p>Please wait</p></div>
                    </div>
                </div>
            `;

            const dates = getDistributorDateRange(topDistributorRange.value);
            const previousDates = getPreviousDistributorDateRange(topDistributorRange.value);

            Promise.all([
                fetchTopDistributors(dates),
                fetchTopDistributors(previousDates)
            ])
                .then(function (results) {
                    renderTopDistributors(results[0], results[1]);
                })
                .catch(function () {
                    topDistributorsList.innerHTML = `
                        <div class="list-item">
                            <div class="list-left">
                                <div class="list-icon ic-red"><i class="fas fa-triangle-exclamation"></i></div>
                                <div class="list-info"><h4>Unable to load distributors</h4><p>Please try again</p></div>
                            </div>
                        </div>
                    `;
                });
        }

        if (topDistributorRange) {
            topDistributorRange.addEventListener('change', loadTopDistributors);
            loadTopDistributors();
        }

        loadOverviewStats();

        const cityDetails = {
            "chennai": { 
                name: "Chennai", 
                total: "₹4,50,000", 
                executives: [
                    { name: "Santhosh", sales: "₹1,20,000" },
                    { name: "Babu", sales: "₹95,000" },
                    { name: "Kumar", sales: "₹80,000" }
                ], 
                products: [
                    { name: "Detergent Powder", sales: "₹2,10,000" },
                    { name: "Dish Wash Gel", sales: "₹1,50,000" },
                    { name: "Soap Bar", sales: "₹90,000" }
                ] 
            },
            "coimbatore": { 
                name: "Coimbatore", 
                total: "₹2,80,000", 
                executives: [
                    { name: "Ramesh", sales: "₹85,000" },
                    { name: "Sundar", sales: "₹72,000" },
                    { name: "Vignesh", sales: "₹60,000" }
                ], 
                products: [
                    { name: "Power Soap", sales: "₹1,20,000" },
                    { name: "Detergent", sales: "₹98,000" },
                    { name: "Liquid Cleaner", sales: "₹62,000" }
                ] 
            },
            "madurai": { 
                name: "Madurai", 
                total: "₹1,95,000", 
                executives: [
                    { name: "Muthu", sales: "₹58,000" },
                    { name: "Selvi", sales: "₹52,000" },
                    { name: "Karthik", sales: "₹45,000" }
                ], 
                products: [
                    { name: "Soap Bar", sales: "₹80,000" },
                    { name: "Detergent", sales: "₹70,000" },
                    { name: "Dishwash", sales: "₹45,000" }
                ] 
            },
            "trichy": { 
                name: "Trichy", 
                total: "₹1,50,000", 
                executives: [
                    { name: "Siva", sales: "₹48,000" },
                    { name: "Murugan", sales: "₹42,000" },
                    { name: "Anbu", sales: "₹35,000" }
                ], 
                products: [
                    { name: "Detergent", sales: "₹65,000" },
                    { name: "Soap Bar", sales: "₹50,000" },
                    { name: "Handwash", sales: "₹35,000" }
                ] 
            },
            "salem": { 
                name: "Salem", 
                total: "₹1,10,000", 
                executives: [
                    { name: "Dinesh", sales: "₹38,000" },
                    { name: "Prakash", sales: "₹32,000" },
                    { name: "Gopi", sales: "₹28,000" }
                ], 
                products: [
                    { name: "Soap Bar", sales: "₹48,000" },
                    { name: "Detergent", sales: "₹40,000" },
                    { name: "Dishwash", sales: "₹22,000" }
                ] 
            },
            "bangalore": { 
                name: "Bangalore", 
                total: "₹6,10,000", 
                executives: [
                    { name: "Santhosh", sales: "₹1,20,000" },
                    { name: "Babu", sales: "₹95,000" },
                    { name: "Kumar", sales: "₹80,000" }
                ], 
                products: [
                    { name: "Detergent Powder", sales: "₹2,10,000" },
                    { name: "Dish Wash Gel", sales: "₹1,50,000" },
                    { name: "Soap Bar", sales: "₹90,000" }
                ] 
            },
            "mysore": { 
                name: "Mysore", 
                total: "₹1,85,000", 
                executives: [
                    { name: "Prakash", sales: "₹55,000" },
                    { name: "Naveen", sales: "₹48,000" },
                    { name: "Deepa", sales: "₹42,000" }
                ], 
                products: [
                    { name: "Soap Pack", sales: "₹78,000" },
                    { name: "Detergent", sales: "₹65,000" },
                    { name: "Spray", sales: "₹42,000" }
                ] 
            },
            "mangalore": { 
                name: "Mangalore", 
                total: "₹1,30,000", 
                executives: [
                    { name: "Rahul", sales: "₹42,000" },
                    { name: "Sharan", sales: "₹38,000" },
                    { name: "Keerthi", sales: "₹32,000" }
                ], 
                products: [
                    { name: "Detergent", sales: "₹58,000" },
                    { name: "Soap Bar", sales: "₹45,000" },
                    { name: "Liquid", sales: "₹27,000" }
                ] 
            },
            "kochi": { 
                name: "Kochi", 
                total: "₹3,20,000", 
                executives: [
                    { name: "Anand", sales: "₹98,000" },
                    { name: "Mohan", sales: "₹85,000" },
                    { name: "Lijo", sales: "₹70,000" }
                ], 
                products: [
                    { name: "Detergent", sales: "₹1,40,000" },
                    { name: "Liquid Soap", sales: "₹1,10,000" },
                    { name: "Bar Soap", sales: "₹70,000" }
                ] 
            },
            "trivandrum": { 
                name: "Trivandrum", 
                total: "₹2,10,000", 
                executives: [
                    { name: "Gokul", sales: "₹65,000" },
                    { name: "Sneha", sales: "₹58,000" },
                    { name: "Vipin", sales: "₹49,000" }
                ], 
                products: [
                    { name: "Dishwash", sales: "₹90,000" },
                    { name: "Detergent", sales: "₹75,000" },
                    { name: "Handwash", sales: "₹45,000" }
                ] 
            },
            "kozhikode": { 
                name: "Kozhikode", 
                total: "₹1,45,000", 
                executives: [
                    { name: "Haris", sales: "₹48,000" },
                    { name: "Fasal", sales: "₹42,000" },
                    { name: "Riyas", sales: "₹35,000" }
                ], 
                products: [
                    { name: "Soap Bar", sales: "₹62,000" },
                    { name: "Detergent", sales: "₹50,000" },
                    { name: "Gel", stroke: "none", sales: "₹33,000" }
                ] 
            }
        };

        const stateCityMap = {
            "TN": ["chennai", "coimbatore", "madurai", "trichy", "salem"],
            "KA": ["bangalore", "mysore", "mangalore"],
            "KL": ["kochi", "trivandrum", "kozhikode"]
        };

        const stateSelector = document.getElementById('stateSelector');
        const citySelector = document.getElementById('citySelector');
        const displayCityName = document.getElementById('displayCityName');
        const displayCityTotal = document.getElementById('displayCityTotal');
        const executivesList = document.getElementById('executivesList');
        const productsList = document.getElementById('productsList');

        function updateCityUI(cityKey) {
            const data = cityDetails[cityKey];
            if (!data) return;
            
            displayCityName.textContent = data.name;
            displayCityTotal.textContent = data.total;
            
            executivesList.innerHTML = data.executives.map(exec => `
                <div class="executive-item">
                    <div class="executive-name">
                        <span class="executive-badge"><i class="fas fa-user"></i></span> ${exec.name}
                    </div>
                    <div class="executive-sales">${exec.sales}</div>
                </div>
            `).join('');
            
            productsList.innerHTML = data.products.map(prod => `
                <div class="product-item">
                    <div class="product-name">
                        <i class="fas fa-cube"></i> ${prod.name}
                    </div>
                    <div class="product-sales">${prod.sales}</div>
                </div>
            `).join('');
        }

        function populateCityDropdown(stateKey) {
            const cityKeys = stateCityMap[stateKey];
            citySelector.innerHTML = "";
            cityKeys.forEach(cityKey => {
                const option = document.createElement("option");
                option.value = cityKey;
                option.textContent = cityDetails[cityKey].name;
                citySelector.appendChild(option);
            });
            updateCityUI(citySelector.value);
        }

        stateSelector.addEventListener('change', (e) => {
            populateCityDropdown(e.target.value);
        });
        
        citySelector.addEventListener('change', (e) => {
            updateCityUI(e.target.value);
        });

        populateCityDropdown('TN');
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        function exportToPDF() {
            var element = document.body;
            var opt = {
                margin:       0.2,
                filename:     'Dashboard_Report.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, scrollY: 0, useCORS: true },
                jsPDF:        { unit: 'in', format: 'a3', orientation: 'landscape' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>

    
<script>
    const donutCtx = document.getElementById('donutChart');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Tamil Nadu', 'Kerala', 'Karnataka', 'Andhra', 'Telangana'],
            datasets: [{
                data: [35, 28, 20, 12, 5],
                backgroundColor: ['#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderColor: 'transparent',
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => '  ' + ctx.label + ': ' + ctx.parsed + '%'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
