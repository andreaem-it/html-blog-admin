<?php 

	error_reporting(E_ALL);

	function get_percentage($num,$total) {
		return $num/$total*100;
	}
	function get_earning($total,$percent) {
		$math = $total * ((100-$percent) / 100);
		return $total - $math;
	}
	$getAuthor = $qls->user_info['username'];
	$setAuthor = $DB_CON -> query ("SELECT ID FROM authors WHERE username = '$getAuthor'")->fetch();
	$getArticleNum = $DB_CON -> query ("SELECT count(*) FROM article WHERE author = $setAuthor[0]")->fetch();
	$getTotalArticle = $DB_CON -> query ("SELECT count(*) FROM article")->fetch();
	$getArticleViews = $DB_CON -> query ("SELECT count('view_count') FROM article WHERE author = '$getAuthor'")->fetchColumn();

	// RevenueHits API
	$url = 'http://revenuehits.com/publishers/report?pid=andreaem&key=0e6018a694e05f9de53141810efa8f57&from=2016-07-24';
	$xml = simplexml_load_file($url);
	$revenuehitsCurrentEarnings = $xml['date']['publisher']['subid']['money'];
	$revenuehitsCurrentClicks = $xml['date']['publisher']['subid']['clicks'];
	$revenuehitsCurrentInvalid = $xml -> invalidcliks;
	$revenuehitsCurrentRequests = $xml -> requests;
	$revenuehitsCurrentSales = $xml -> sales;
	//

	// Amazon
	$amazonCurrentEarnings = 0.00;
	//

	$currentEarnings = $amazonCurrentEarnings + $revenuehitsCurrentEarnings;

	$yourPercentage = round(get_percentage($getArticleNum[0],$getTotalArticle[0]),2);
	$yourEarnings = round(get_earning($currentEarnings,$yourPercentage),2);

	
	?>

<div class="modal fade" tabindex="-1" role="dialog" id="payout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Richiedi Pagamento</h4>
      </div>
      <div class="modal-body">
        <p>Puoi richiedere il pagamento una volta raggiunti i 15.00 &euro;</p>
        <p><strong>Hai guadagnato</strong> un totale di <strong><?php print round($yourEarnings,2); ?> &euro;</strong></p>
        <p><?php if ($yourEarnings > 15.00) { print 'Puoi richiedere il pagamento!'; } else { print 'Non puoi ancora richiedere il pagamento, torna quando avrai raggiunto la cifra minima!';} ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" <?php if ($yourEarnings > 15.00) { } else { print 'disabled';} ?> class="btn btn-primary" data-toggle="modal" data-target="#payoutRequested">Richiedi</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="payoutRequested">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3><strong>Pagamento Richiesto!</strong></h3>
        <br>
        <p>La tua richiesta &egrave; in coda, dovresti ricevere il pagamento entro 48 ore!</p>
        <p><small>Nota: Non richiedere pi&ugrave; volte il pagamento, ne verr&aacute; processato soltanto uno.</small></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Guadagni</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12" style="float:left">
			<h1 class="page-header" style="float:left">Guadagni <small>Totale: <?php print round($currentEarnings,2); ?> &euro;</small></h1>
		</div>
	</div><!--/.row-->
	<h6>Dividiamo i guadagni dei banner Amazon e RevenueHits secondo la percentuale dei tuoi articoli scritti sul totale degli articoli, mentre per AdSense viene conteggiato l'effettivo click sul banner</h6>
	<p><small>Le statistiche devono essere aggiornate manualmente, pertanto non saranno in tempo reale, questo &egrave; dato dalla mancanza di API pubbliche da parte di Amazon.</small></p>
	<br>
	<div class="panel panel-default">
	  <div class="panel-body">
	    <h4>Hai scritto: <?php print $getArticleNum[0]; ?> Articoli, che corrispondono al <?php print $yourPercentage; ?>% degli articoli totali, pertanto il tuo guadagno netto &eacute; di <?php print $yourEarnings; ?> &euro;  <a href="#" data-toggle="modal" data-target="#payout" style="margin-top:-10px" class="btn btn-success pull-right">Richiedi Pagamento</a></h4>
	  </div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Amazon
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						<p>Articoli scritti <span class="pull-right"><?php print $getArticleNum[0] . ' / ' .$getTotalArticle[0]; ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Visualizzazioni Articoli <span class="pull-right"><?php print $getArticleViews[0]; ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Guadagni Totali <span class="pull-right"><?php print round($yourEarnings,2); ?> &euro;</span></p>
					</li>
				</ul>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				Revenue Hits
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						<p>Richieste <span class="pull-right"><?php print $revenuehitsCurrentRequests ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Click <span class="pull-right"><?php print $revenuehitsCurrentClicks ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Click non validi <span class="pull-right"><?php print $revenuehitsCurrentInvalid ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Vendite <span class="pull-right"><?php print $revenuehitsCurrentSales ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Guadagni Totali <span class="pull-right"><?php print round($revenuehitsCurrentEarnings,2); ?> &euro;</span></p>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				AdSense
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						<p>Articoli scritti <span class="pull-right"><?php print $getArticleNum[0] . ' / ' .$getTotalArticle[0]; ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Click sui Banner <span class="pull-right"><?php print 0; ?></span></p>
					</li>
					<li class="list-group-item">
						<p>Guadagni Totali <span class="pull-right"><?php print 0 ?> &euro;</span></p>
					</li>
				</ul>
				<p><small>Non abbiamo ancora ricevuto l'abilitazione da parte di Google per l'utilizzo di AdSense, questo dipende sostanzialmente dalla mancanza di contenuti (Google richiede minimo 50 articoli da almeno 500 parole), pertanto esortiamo i nostri Autori a pubblicare nuovi contenuti giornalmente che siano di qualit&aacute; e univoci.</small></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		
	</div>
</div>