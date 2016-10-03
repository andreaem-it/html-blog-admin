<?php
/* DO NOT REMOVE */
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}
/*****************/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form role="form" action="login_process.php" method="post">
						<input type="hidden" name="process" value="true" />
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus="" maxlength="<?php echo $qls->config['max_username']; ?>">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="" maxlength="<?php echo $qls->config['max_password']; ?>">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Remember Me" name="remember" value="1">Remember Me
								</label>
							</div>
							<input type="submit" class="btn btn-primary" value="<?php echo LOGIN_SUBMIT_LABEL; ?>"/>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
 

<?php
if (isset($_GET['f'])) {
?>
        <br />
        <span style="color:#ff524a;">
<?php
    switch ($_GET['f']) {
        default:
            break;
        case 0:
            echo LOGIN_NOT_ACTIVE_USER;
            break;
        case 1:
            echo LOGIN_USER_BLOCKED;
            break;
        case 2:
            echo LOGIN_PASSWORDS_NOT_MATCHED;
            break;
        case 3:
            echo LOGIN_NO_TRIES;
            break;
        case 4:
            echo LOGIN_USER_INFO_MISSING;
            break;
        case 5:
            echo LOGIN_NOT_ACTIVE_ADMIN;
            break;
    }
?>
        </span>
<?php
}
?>
	</form>
</fieldset>