<?php
    switch($_GET['page']) {
        case 'dashboard':
            include 'views/dashboard.php';
            break;
        case 'articles':
            include 'views/articles.php';
            break;
        case 'articles-view':
            include 'views/articles-view.php';
            break;
        case 'newsletter':
            include 'views/newsletter.php';
            break;
        case 'earnings':
            include 'views/earnings.php';
            break;
        case 'analytics':
            include 'views/analytics.php';
            break;
        case 'admin':
            print '<div style="margin-left:300px">';
            include 'admincp.php';
            print '</div>';
            break;
        default:
            include 'views/dashboard.php';
            break;
    }


?>