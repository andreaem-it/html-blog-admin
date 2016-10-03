	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<!--<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>-->
		<ul class="nav menu">
			<li <?php if ($_GET['page'] == 'dashboard') { print 'class="active"';} ?>><a href="?page=dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li class="parent">
				<a href="?page=articles">
					<span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Articoli 
				</a>
				<ul class="children collapse <?php if($_GET['page'] == 'articles' || $_GET['page'] == 'articles-view') { print 'in'; } ?>" id="sub-item-1">
					<li <?php if ($_GET['page'] == 'articles-view') { print 'class="active selected"';} ?>>
						<a class="" href="?page=articles-view">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Nuovo
						</a>
					</li>
					<li <?php if ($_GET['page'] == 'articles') { print 'class="active selected"';} ?>>
						<a class="" href="?page=articles">
							<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Lista
						</a>
					</li>
				</ul>
			</li>
			<li <?php if ($_GET['page'] == 'newsletter') { print 'class="active"';} ?>><a href="?page=newsletter"><svg class="glyph stroked email"><use xlink:href="#stroked-email"/></svg> Newsletter</a></li>
			<li <?php if ($_GET['page'] == 'analytics') { print 'clas="active"';} ?>><a href="?page=analytics"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Analytics</a></li>
			<li <?php if ($_GET['page'] == 'admin') { print 'clas="active"';} ?>><a href="?page=admin"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Admin</a></li>
			<li <?php if ($_GET['page'] == 'earnings') { print 'clas="active"';} ?>><a href="?page=earnings"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Guadagni</a></li>
			<li role="presentation" class="divider"></li>
			<!--<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>-->
		</ul>

	</div><!--/.sidebar-->