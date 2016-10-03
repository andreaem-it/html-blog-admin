
<?php
	if (defined ('ACCESS')) {
	define('QUADODO_IN_SYSTEM', true);
	require_once('includes/header.php');

	define('include', TRUE);
	require_once '../config/db.php';
	
	include 'inc/head.php';
	print '<body>';
	include 'inc/header.php';
	include 'inc/sidebar.php'; 
	include 'core/switch.php';
	} else {
		print 'Direct Access Not Allowed';
		die;
	}
?>
		

		
		<!--/.main-->

	
	<script>
		//$('#calendar').datepicker({
		//});

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
