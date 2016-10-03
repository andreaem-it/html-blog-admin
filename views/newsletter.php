<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Newsletter</li>
		</ol>
	</div><!--/.row-->
	<?php $countData = $DB_CON->query("SELECT count(*) FROM newsletter")->fetch(); ?>
	<div class="row">
		<div class="col-lg-12" style="float:left">
			<h1 class="page-header" style="float:left">Newsletter <small><?php print $countData[0][0]; ?> contatti</small></h1>
		</div>
	</div><!--/.row-->
	<?php
	    $getData = $DB_CON->query("SELECT * FROM  `newsletter` ORDER BY `ID`")->fetchAll( PDO::FETCH_ASSOC );
	    $getJSON = json_encode($getData, JSON_PRETTY_PRINT);
	    
	    
	    
	?>
	<textarea col="100" row="100" style="width:100%;height:750px"><?php print $getJSON; ?></textarea>
</div>