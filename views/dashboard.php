<?php

	date_default_timezone_set("Europe/Rome");

    $siteArticleCountSQL = $DB_CON -> query("SELECT count('id') FROM `article`");
    $siteArticleCount = $siteArticleCountSQL -> fetchAll(PDO::FETCH_ASSOC);
    $siteArticleCountResult = $siteArticleCount[0]["count('id')"];
	$siteViewsPrintResult = $DB_CON->query("SELECT count(*) FROM statistics")->fetchColumn();
	$siteViewsDaily = $DB_CON->query("SELECT count(*), date(dt) as dt FROM statistics WHERE dt BETWEEN ADDDATE(NOW(),-6) AND NOW() GROUP BY date(dt)")->fetchAll();
	$siteViewsThisWeek = $DB_CON->query("SELECT count(*), date(dt) FROM statistics WHERE WEEK(dt,1) = WEEK(NOW()) GROUP BY date(dt)")->fetchAll();
	$siteViewsThisMonth = $DB_CON->query("SELECT count(*), date(dt) FROM statistics WHERE MONTH(dt) = MONTH(NOW()) GROUP BY date(dt)")->fetchAll();
	$siteViewsDailyNewUser = $DB_CON->query("SELECT count(ip), date(dt) FROM statistics GROUP BY ip")->fetchAll();
	$siteViewsNewUsers = $DB_CON->query("SELECT count(*), ip FROM statistics GROUP BY ip")->fetchAll(PDO::FETCH_ASSOC);
	$siteViewsNewUsersCount = sizeof($siteViewsNewUsers);
	

	
	function convert_to_unit($number) {
		if ($number < 1000) { $result = $number; };
		if ($number > 1000 && $number < 100000) { $result = number_format($number,3,'.','') . ' K';}
		if ($number > 100000 && $number < 100000000) { $result = number_format($number,3,'.','') . ' M';}
		return $result;
	}
	function bd_nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
        
        // is this a number?
        if(!is_numeric($n)) return false;
        
        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),2).' T';
        else if($n>1000000000) return round(($n/1000000000),2).' B';
        else if($n>1000000) return round(($n/1000000),2).' M';
        else if($n>1000) return round(($n/1000),2).' K';
        
        return number_format($n);
    }
    function _group_by($array, $key) {
	    $return = array();
	    foreach($array as $val) {
	        $return[$val[$key]][] = $val;
	    }
	    return $return;
	}
	
    ?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked notepad "><use xlink:href="#stroked-notepad"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php print $siteArticleCountResult; ?></div>
							<div class="text-muted">Articoli</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">-</div>
							<div class="text-muted">Commenti</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php print bd_nice_number($siteViewsNewUsersCount); ?></div>
							<div class="text-muted">Nuovi Utenti</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php print bd_nice_number($siteViewsPrintResult); ?></div>
							<div class="text-muted">Visualizzazioni Pagine</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Traffico ultimi 7 giorni</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">Traffico questa settimana</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart-2" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">Traffico questo mese</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart-3" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>
	
<?php 



function format_date($date) {
	setlocale (LC_TIME, "it_IT.UTF8");
	return strtotime(strftime("%d %b %g",$date));
}

/*for ($i = 0; $i < 7; $i++) {
	$get_day_+$i = function  ($day) {
		if ($date == "") { 
			$current = date('d M Y', strtotime("$date +$i day"));
		} elseif ($date == date("d M Y")) { 
			$current = 'Oggi'; 
		} else { 
			$current = date("d M Y",strtotime($date)); 
		} 
	};
}*/
var_dump(date("w",strtotime($date)));

function get_day($date,$daynum) {
	$dayofweek = date("w",strtotime($date));

	if ($daynum == $dayofweek) { $daynum = 1; } else if($daynum == $dayofweek+1) { $daynum = 2; } else if($daynum == $dayofweek+2) { $daynum = 3; } else if($daynum == $dayofweek+3) {$daynum = 4; } else if($daynum == $dayofweek+4) {	$daynum = 5; } else if($daynum == $dayofweek+5) { $daynum = 6; } else if($daynum == $dayofweek+6) {	$daynum = 7; }
    if (is_null($date)) {
        $current = date('d M Y',strtotime("+$daynum day"));
    } elseif ($date == date("d M Y")) {
        $current = 'Oggi';
    } else {
        $current = date("d M Y",strtotime($date));
    }
    return $current; 
}

function next_30_days($day,$num) {
	$today = date("D",strtotime(($day)));
	for ($i=0; $i < 32; $i++) { 
		if($num == $today+$i) {
			$num = $i;
		}
	}
	if (is_null($date)) {
        $current = date('d',strtotime("+$num day"));
    } elseif ($date == date("d")) {
        $current = 'Oggi';
    } else {
        $current = date("d",strtotime($date));
    }
    return $current; 
}

/*

	for ($i = 0; $i <= 8; $i++) {
		${'d' + $i} = date("D d M Y",strtotime($siteViewsDaily[$i][1]));
		${'v' + $i} = $siteViewsDaily[$i][0];
		${'v2' + $i} = $siteViewsThisWeek[$i][0];
		${'d2' + $i} = get_day($siteViewsThisWeek[$i][1],$i);
	}
	
	for ($i = 1; $i <= 31; $i++) {
		${'v3' + $i} = $siteViewsThisMonth[$i][0];
		${'d3' + $i} = date("D d M Y",strtotime($siteViewsThisMonth[$i][1]));
	}
*/	
$v1 = $siteViewsDaily[0][0];
$v2 = $siteViewsDaily[1][0];
$v3 = $siteViewsDaily[2][0];
$v4 = $siteViewsDaily[3][0];
$v5 = $siteViewsDaily[4][0];
$v6 = $siteViewsDaily[5][0];
$v7 = $siteViewsDaily[6][0];
	
$d1 = date("D d M Y",strtotime($siteViewsDaily[0][1]));
$d2 = date("D d M Y",strtotime($siteViewsDaily[1][1]));
$d3 = date("D d M Y",strtotime($siteViewsDaily[2][1]));
$d4 = date("D d M Y",strtotime($siteViewsDaily[3][1]));
$d5 = date("D d M Y",strtotime($siteViewsDaily[4][1]));
$d6 = date("D d M Y",strtotime($siteViewsDaily[5][1]));
$d7 = date("D d M Y",strtotime($siteViewsDaily[6][1]));

$v21 = $siteViewsThisWeek[0][0];
$v22 = $siteViewsThisWeek[1][0];
$v23 = $siteViewsThisWeek[2][0];
$v24 = $siteViewsThisWeek[3][0];
$v25 = $siteViewsThisWeek[4][0];
$v26 = $siteViewsThisWeek[5][0];
$v27 = $siteViewsThisWeek[6][0];

$d21 = get_day($siteViewsThisWeek[0][1],'1');
$d22 = get_day($siteViewsThisWeek[1][1],'2'); 
$d23 = get_day($siteViewsThisWeek[2][1],'3'); 
$d24 = get_day($siteViewsThisWeek[3][1],'4'); 
$d25 = get_day($siteViewsThisWeek[4][1],'5'); 
$d26 = get_day($siteViewsThisWeek[5][1],'6'); 
$d27 = get_day($siteViewsThisWeek[6][1],'7');

$v31 = $siteViewsThisMonth[0][0];
$v32 = $siteViewsThisMonth[1][0];
$v33 = $siteViewsThisMonth[2][0];
$v34 = $siteViewsThisMonth[3][0];
$v35 = $siteViewsThisMonth[4][0];
$v36 = $siteViewsThisMonth[5][0];
$v37 = $siteViewsThisMonth[6][0];
$v38 = $siteViewsThisMonth[7][0];
$v39 = $siteViewsThisMonth[8][0];
$v310 = $siteViewsThisMonth[9][0];
$v311 = $siteViewsThisMonth[10][0];
$v312 = $siteViewsThisMonth[11][0];
$v313 = $siteViewsThisMonth[12][0];
$v314 = $siteViewsThisMonth[13][0];
$v315 = $siteViewsThisMonth[14][0];
$v316 = $siteViewsThisMonth[15][0];
$v317 = $siteViewsThisMonth[16][0];
$v318 = $siteViewsThisMonth[17][0];
$v319 = $siteViewsThisMonth[18][0];
$v320 = $siteViewsThisMonth[19][0];
$v321 = $siteViewsThisMonth[20][0];
$v322 = $siteViewsThisMonth[21][0];
$v323 = $siteViewsThisMonth[22][0];
$v324 = $siteViewsThisMonth[23][0];
$v325 = $siteViewsThisMonth[24][0];
$v326 = $siteViewsThisMonth[25][0];
$v327 = $siteViewsThisMonth[26][0];
$v328 = $siteViewsThisMonth[27][0];
$v329 = $siteViewsThisMonth[28][0];
$v330 = $siteViewsThisMonth[29][0];
$v331 = $siteViewsThisMonth[30][0];

/*for ($i=0; $i < 32 ; $i++) { 
	${'d3' + $i} = next_30_days($siteViewsThisMonth[$i][1],$i);
}*/


$d31 =  next_30_days($siteViewsThisMonth[0][1],1);
$d32 =  next_30_days($siteViewsThisMonth[1][1],2);
$d33 =  next_30_days($siteViewsThisMonth[2][1],3);
$d34 =  next_30_days($siteViewsThisMonth[3][1],4);
$d35 =  next_30_days($siteViewsThisMonth[4][1],5);
$d36 =  next_30_days($siteViewsThisMonth[5][1],6);
$d37 =  next_30_days($siteViewsThisMonth[6][1],7);
$d38 =  next_30_days($siteViewsThisMonth[7][1],8);
$d39 =  next_30_days($siteViewsThisMonth[8][1],9);
$d310 =  next_30_days($siteViewsThisMonth[9][1],10);
$d311 =  next_30_days($siteViewsThisMonth[10][1],11);
$d312 =  next_30_days($siteViewsThisMonth[11][1],12);
$d313 =  next_30_days($siteViewsThisMonth[12][1],13);
$d314 =  next_30_days($siteViewsThisMonth[13][1],14);
$d315 =  next_30_days($siteViewsThisMonth[14][1],15);
$d316 =  next_30_days($siteViewsThisMonth[15][1],16);
$d317 =  next_30_days($siteViewsThisMonth[16][1],17);
$d318 =  next_30_days($siteViewsThisMonth[17][1],18);
$d319 =  next_30_days($siteViewsThisMonth[18][1],19);
$d320 =  next_30_days($siteViewsThisMonth[19][1],20);
$d321 =  next_30_days($siteViewsThisMonth[20][1],21);
$d322 =  next_30_days($siteViewsThisMonth[21][1],22);
$d323 =  next_30_days($siteViewsThisMonth[22][1],23);
$d324 =  next_30_days($siteViewsThisMonth[23][1],24);
$d325 =  next_30_days($siteViewsThisMonth[24][1],25);
$d326 =  next_30_days($siteViewsThisMonth[25][1],26);
$d327 =  next_30_days($siteViewsThisMonth[26][1],27);
$d328 =  next_30_days($siteViewsThisMonth[27][1],28);
$d329 =  next_30_days($siteViewsThisMonth[28][1],29);
$d330 =  next_30_days($siteViewsThisMonth[29][1],30);
$d331 =  next_30_days($siteViewsThisMonth[30][1],31);

/*$n1= $siteViewsDailyNewUser[0][0];
$n2= $siteViewsDailyNewUser[1][1];
$n3= $siteViewsDailyNewUser[2][2];
$n4= $siteViewsDailyNewUser[3][3];
$n5= $siteViewsDailyNewUser[4][4];
$n6= $siteViewsDailyNewUser[5][5];
$n7= $siteViewsDailyNewUser[6][6];
*/
//var_dump($siteViewsDailyNewUser);

    print '
    <script>
    var lineChartData = {
			labels : ["' .$d1 .'","' . $d2 .'","' . $d3 . '","' . $d4 . '","' . $d5 . '","' . $d6 .'","' . $d7 . '"],
			datasets : [
				{
					label: "Visite",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : ["' . $v1 .'","' . $v2 .'","' . $v3 .'","' . $v4 .'","' . $v5 .'","' . $v6 .'","' . $v7 .'"] 
				}
			]

		}
	var lineChartData2 = {
			labels : ["' .$d21 .'","' . $d22 .'","' . $d23 . '","' . $d24 . '","' . $d25 . '","' . $d26 .'","' . $d27 . '"],
			datasets : [
				{
					label: "Nuovi",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : ["' . $v21 .'","' . $v22 .'","' . $v23 .'","' . $v24 .'","' . $v25 .'","' . $v26 .'","' . $v27 .'"] 
				}
			]
		}
	var lineChartData3 = {
			labels : ["' .$d31 .'","' . $d32 .'","' . $d33 . '","' . $d34 . '","' . $d35 . '","' . $d36 .'","' . $d37 . '","' .$d38 .'","' . $d39 .'","' . $d310 . '","' . $d311 . '","' . $d312 . '","' . $d313 .'","' .$d314 .'","' . $d315 .'","' . $d316 . '","' . $d317 . '","' . $d318 . '","' . $d319 .'","' . $d320 . '","' .$d321 .'","' . $d322 .'","' . $d323 . '","' . $d324 . '","' . $d325 . '","' . $d326 .'","' . $d327 . '","' .$d328 .'","' . $d329 .'","' . $d330 . '","' . $d331 . '"],
			datasets : [
				{
					label: "Nuovi",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : ["' .$v31 .'","' . $v32 .'","' . $v33 . '","' . $v34 . '","' . $v35 . '","' . $v36 .'","' . $v37 . '","' .$v38 .'","' . $v39 .'","' . $v310 . '","' . $v311 . '","' . $v312 . '","' . $v313 .'","' .$v314 .'","' . $v315 .'","' . $v316 . '","' . $v317 . '","' . $v318 . '","' . $v319 .'","' . $v320 . '","' .$v321 .'","' . $v322 .'","' . $v323 . '","' . $v324 . '","' . $v325 . '","' . $v326 .'","' . $v327 . '","' .$v328 .'","' . $v329 .'","' . $v330 . '","' . $v331 . '"], 
				}
			]
		}
		window.onload = function(){
	var chart1 = document.getElementById("line-chart").getContext("2d");
	var chart2 = document.getElementById("line-chart-2").getContext("2d");
	var chart3 = document.getElementById("line-chart-3").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
		responsive: true
	});
	window.myLine = new Chart(chart2).Line(lineChartData2, {
		responsive: true
	});
	window.myLine = new Chart(chart3).Line(lineChartData3, {
		responsive: true
	});
		};
		</script>';

?>