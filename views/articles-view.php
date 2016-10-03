<?php
include_once '../lib/php-html-css-js-minifier.php';
function slugify($text)
{
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}

function get_author($name) {
  $get_data = $DB_CON->query("SELECT * FROM authors WHERE username = $name")->fetch();
  return $get_data[0];
}
function get_author_id($name) {
  $get_data = $DB_CON->query("SELECT ID FROM authors WHERE username = $name")->fetch();
  return $get_data[0];
}

if(isset($_POST['submit'])) {
  $inputArticle = $_POST['inputArticle'];
  $inputTitle = $_POST['inputTitle'];
  $inputSlug = slugify(minify_html($_POST['inputTitle']));
  $inputImageURL = $_POST['inputImageURL'];
  $inputData = $_POST['inputData'];
  $inputCategory = $_POST['inputCategory'];
  $inputAuthor = get_author_id($_POST['inputAuthor']);
  $putArticle = $DB_CON -> prepare("INSERT INTO `andreaem`.`article` ( `slug`, `title`, `date`, `category`, `image`, `html`, `author` ,`view_count`) VALUES ( '$inputSlug', '$inputTitle', '$inputData', '$inputCategory', '$inputImageURL', '$inputArticle', '$inputAuthor', '0');");
  $putArticle ->execute();
}

if(isset($_GET['slug'])) {
  $fillSlug = $_GET['slug'];
  $fillArticleData = $DB_CON ->query("SELECT * FROM `article` WHERE `slug` = '$fillSlug'")->fetch();
  $fillArticleSlug = $fillArticleData[1];
  $fillArticleTitle = $fillArticleData[2];
  $fillArticleDate = $fillArticleData[3];
  $fillArticleCategory = $fillArticleData[4];
  $fillArticleImage = $fillArticleData[5];
  $fillArticleHTML= $fillArticleData[6];
}

if(isset($_POST['update'])) {
  $articleSlug = $_GET['slug'];
  $inputArticle = addslashes(minify_html($_POST['inputArticle']));
  $inputTitle = $_POST['inputTitle'];
  $inputSlug = slugify($_POST['inputTitle']);
  $inputImageURL = $_POST['inputImageURL'];
  $inputData = $_POST['inputData'];
  $inputCategory = $_POST['inputCategory'];
  $inputAuthor = get_author_id($_POST['inputAuthor']);
  $putArticle = $DB_CON -> prepare("UPDATE  `andreaem`.`article` SET  `slug` =  '$inputSlug',`title` =  '$inputTitle',`date` =  '$inputData',`html` =  '$inputArticle',`category` = '$inputCategory',`author` = '$inputAuthor'  WHERE  `article`.`slug` ='$articleSlug';");
  $putArticle ->execute();
}
?>
<script src="js/dropzone.js"></script>
<link rel="stylesheet" type="text/css" href="css/dropzone.css"/>

<div class="modal fade" tabindex="-1" role="dialog" id="imageUploadModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload Foto</h4>
      </div>
      <div class="modal-body">
        <p>
          <form action="upload.php" method="post" class="dropzone">
            <input type="hidden" name="articleSlug" value="<?php print $articleSlug; ?>"/>
          </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div><
</div>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Articoli</li>
		</ol>
	</div><!--/.row-->
<style>
.mce-panel {border-radius: 8px; border:none;}
</style>	
	<div class="row">
		<div class="col-lg-12" style="float:left">
			<div class="page-header" style="float:left;margin: 10px 0 0px;"><h1 style="margin:0"><?php if(isset($_GET['slug'])) { print 'Modifica'; } else { print 'Nuovo'; } ?> Articolo <br></h1>
          <?php if(isset($_GET['slug'])) { ?><h6>Permalink:<a href="http://<?php print $_SERVER['SERVER_NAME']; ?>/article/<?php print $_GET['slug']; ?>/"> http://<?php print $_SERVER['SERVER_NAME']; ?>/article/<?php print $_GET['slug']; ?>/</a></h6> <?php } ?>
      </div>
			<form class="form-inline" method="POST" action="">
			  <div class="pull-right">
			    <input type="hidden" name="page" value="articles-view"/>
			    <input type="submit" class="btn btn-success" id="" name="<?php if(isset($_GET['slug'])) { print 'update';} else { print 'submit';} ?>" style="float:left;margin:35px 0 0 20px" value="<?php if(isset($_GET['slug'])) { print 'Aggiorna'; } else { print 'Salva';} ?>"/>
			    <a href="goBack();" class="btn btn-warning" style="float: left;margin: 35px 0 0 20px;">Annulla</a>
			    <?php if(isset($_GET['slug'])) { print '<a href="#delete" class="btn btn-danger" style="float: left;margin: 35px 0 0 20px;">Elimina</a>'; }  ?>
			  </div>
		</div>
	</div><!--/.row-->
	<br>
	<div class="row">
	    <div class="col-md-9">
        <div class="form-group">
          <textarea name="inputArticle" id="inputArticle" height="210px"><?php if(isset($fillArticleHTML)) { print $fillArticleHTML; } ?></textarea>
        </div>
	    </div>
	    <div class="col-md-3" style="padding-right:30px">
	      <div class="panel panel-default">
          <div class="panel-body">
              <div class="form-group">
                <label for="inpitTitle">Titolo</label>
                <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="" required value="<?php if(isset($fillArticleTitle)) { print $fillArticleTitle; } ?>"> 
              </div>
              <div class="form-group">
                <label for="inputSlug">Slug</label>
                <input type="text" class="form-control" name="inputSlug" id="inputSlug" placeholder="" disabled value="<?php if(isset($fillArticleSlug)) { print $fillArticleSlug; } ?>">
              </div>
              <div class="form-group">
                <label for="inputImageURL">URL Immagine</label>
                <input type="text" class="form-control" name="inputImageURL" id="inputImageURL" placeholder="" value="<?php if(isset($fillArticleImage)) { print $fillArticleImage; } ?>">
                <br>
                <img id="articleImg" class="img-responsive" src="<?php if(isset($fillArticleImage)) { print $fillArticleImage; } else { print '../img/placeholder.png';} ?>" width="275" height="175" style="border-top-left-radius:8px;border-top-right-radius:8px">
                <a data-toggle="modal" data-target="#imageUploadModal" style="display: block; width: 100%;border-top-left-radius:0px;border-top-right-radius:0px" class="btn btn-success" >Upload </a>
              </div>
              <div class="form-group" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <label for="inputData">Data</label>
                <input type="text" class="form-control datepicker" name="inputData" id="inputData" placeholder="" value="<?php if(isset($fillArticleDate)) { print $fillArticleDate; } else { print date("Y-m-d"); } ?>" data-language="it-IT" data-autoclose="true" data-today-highlight="true">
              </div>
              <div class="form-group">
                <label for="inputCategory" required>Categoria</label>
                <select class="form-control" name="inputCategory" id="inputCategory">
                     <option value="">-- Seleziona --</option>
                     <?php if(isset($fillArticleCategory)) { print "<option selected value='$fillArticleCategory'>$fillArticleCategory</option>"; } ?>
                    <?php
                        $getCategoryList = $DB_CON -> query("SELECT `category` FROM `article` GROUP BY `category`")->fetchAll();
                        
                        foreach($getCategoryList as $category) {
                            print '<option value="' . $category[0] . '">' . $category[0] . '</option>';
                        }
                    ?>
                   
                </select>
              </div>
                <input type="hidden" name="inputAuthor" value="<?php $qls->user_info['username']; ?>">
                 <div class="form-group">
                <label for="inputCategory" required>Pubblicato</label>
                <select class="form-control" name="inputPublished" id="inputPublished">
                     <option value="0">No</option>
                     <option value="1">Si</option>
                </select>
              </div>
                </form>
              
          </div>
        </div>
	    </div>
	</div>
</div>

<script>
function goBack() {
    window.history.back();
}
$('.inputData').datepicker({
       format: 'yyyy-mm-dd',
       todayBtn: "linked",
       language: "it-IT",
       autoclose: true,
       todayHighlight: true});
$( "#inputImageURL" ).change(function() {
  $('#articleImg').attr('src', $(this).val());
});
$('.inputData').focusout(function() {
  $(".inputData").datepicker("hide");
});
$('#imageUploadModal').on('shown.bs.modal', function () {
  $('#imageUploadModal').focus()
})
var myDropzone = new Dropzone(document.body, { 
url: "upload.php",
accept: '',
paramName: 'article_',
clickable: true,
maxFiles: 1,
autoProcessQueue: true,
maxFilesize: 2, 
acceptedFiles: "image/jpg, image/jpeg, image/png", 
});
myDropzone.on("complete", function(file) {
  myDropzone.removeFile(file);
});
Dropzone.options.Dropzone = {
  init: function() {
    this.on("addedfile", function(file) { alert("Added file."); });
  }
};
</script>
