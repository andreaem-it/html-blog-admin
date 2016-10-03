<?php
	$DB_CON->exec("set names utf8");
    switch ($_GET['order']) {
        case 'id':
            $order = 'id';
            break;
        case 'title':
            $order = 'title';
            break;
        case 'slug':
            $order = 'slug';
            break;
        case 'category':
            $order = 'category';
            break;
        case 'data':
            $order = 'date';
            break;
        case 'views':
            $order = 'view_count';
            break;
        case 'author':
            $order = 'author';
            break;
        default:
            $order = 'id';
            break;
    }
    $getArticlesList = $DB_CON -> query("SELECT * FROM article ORDER BY $order")->fetchAll();
    $countArticles = $DB_CON -> query("SELECT count(*) FROM article ORDER BY id")->fetch();
    mb_internal_encoding("UTF-8");
    

    include '../lib/limit_text.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
    .table-title {
        line-height: 34px;
        font-weight: 500;
        text-align:center;
    }
    .table-item {
        line-height: 30px;
        font-weight: 100;
    }
    .table-item:hover {
        
    }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Articoli</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12" style="float:left">
			<h1 class="page-header" style="float:left">Articoli</h1>
			<h2><small class="pull-right" style="margin:15px 15px 0 0">Totale: <?php print $countArticles[0]; ?></small></h2>
			<a class="btn btn-success" href="admin.php?page=articles-view" style="float:left;margin:15px 0 0 20px">Aggiungi Nuovo</a>
		</div>
	</div><!--/.row-->
	<br>
    <div class="row" style="background-color: #FFF;margin: 0px;border: 1px solid #eee;">
        <div class="col-xs-1" style="width:2%">
            <span class="table-title"><a href="?page=articles&order=id">ID</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<span class='table-item'>$articleList[0]</span>";
                }
            ?>
        </div>
        <div class="col-xs-3">
            <span class="table-title"><a href="?page=articles&order=title">Titolo</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<a href='admin.php?page=articles-view&slug=" . $articleList[1]. "'><span class='table-item'>" .limit_text($articleList[2],6) . "</a></span>";
                }
            ?>
        </div>
        <div class="col-xs-4">
            <span class="table-title"><a href="?page=articles&order=slug">Slug</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<a href='admin.php?page=articles-view&slug=" . $articleList[1]. "'><span class='table-item'>" . $articleList[1] . "</a></span>";
                }
            ?>
        </div>
        <div class="col-xs-1">
            <span class="table-title"><a href="?page=articles&order=category">Categoria</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<span class='table-item'>$articleList[4]</span>";
                }
            ?>
        </div>
        <div class="col-xs-1">
            <span class="table-title"><a href="?page=articles&order=data">Data</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<span class='table-item'>$articleList[3]</span>";
                }
            ?>
        </div>
        <div class="col-xs-1">
            <span class="table-title"><a href="?page=articles&order=views">Views</a></span>
            <?php 
                foreach ($getArticlesList as $articleList) {
                    print '<br>';
                    print "<span class='table-item'>$articleList[8]</span>";
                }
            ?>
        </div>
        <div class="col-xs-1">
        	<span class="table-title"><a href="?page=articles&order=author">Autore</a></span>
        	<?php 
                foreach ($getArticlesList as $articleList) {
                	$author = $DB_CON -> query("SELECT * FROM authors WHERE ID = $articleList[7]")->fetch();
                    print '<br>';
                    print "<span class='table-item'>$author[1]</span>";
                }
            ?>
        </div>
    </div>
</div>