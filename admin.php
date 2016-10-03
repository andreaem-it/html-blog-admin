<?php
define('QUADODO_IN_SYSTEM', true);
require_once('includes/header.php');

$qls->Security->check_auth_page('admin.php');
    define('ACCESS',TRUE);
    include 'dash.php';
    
?>