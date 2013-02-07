
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Bootstrap, from Twitter</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="asset/css/bootstrap.min.css" rel="stylesheet">
		<link href="asset/css/main.css" rel="stylesheet">
		<style type="text/css">
		  body {
			padding-top: 60px;
			padding-bottom: 40px;
		  }
		  .sidebar-nav {
			padding: 9px 0;
		  }
		</style>
		<link href="asset/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link rel='stylesheet' id='open-sans-css'  href='http://fonts.googleapis.com/css?family=Open+Sans%3A300%2C800&#038;ver=3.4.2' type='text/css' media='all' />
		
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container-fluid">
			  <a class="brand" href="#">Nutshell BTL</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
					<li class="active"><a href="#">API Reference</a></li>
					<li><a href="#about">Request Builder</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</div>

		<div class="container-fluid">
		  <div class="row-fluid">
			<div class="span2">
			  <div id="apiNav" class="well sidebar-nav affix">
				<?php $tpl->navigation(); ?>
			  </div><!--/.well -->
			</div><!--/span-->
			<div class="span9">
				<div id="breadcrumbs"></div>
				<div id="content"></div>
			</div><!--/span-->
		  </div><!--/row-->

		 <div id="footer" class="navbar navbar-inverse navbar-fixed-bottom">
		  <div class="navbar-inner">
			<div class="container-fluid">
			  <a class="brand" href="#">Nutshell - Built on Faith</a>
			</div>
		  </div>
		</div>

		</div><!--/.fluid-container-->
		
		
		
		<div id="APIExample" class="template">
			<div class="row-fluid">
				<div class="span12">
					<div class="row-fluid exampleBox">
						<div class="span6 contentBox labeled" data-label="Example">
							<div class="editor">$1</div>
						</div>
						<div class="span6 contentBox labeled" data-label="Result">
							<div class="result">No Result. Click the "Run" button.</div>
						</div>
					</div>
					<div class="row-fluid exampleBox-actionBar">
						<div class="span6">
							<button data-action="reset" class="btn btn-primary pull-right" type="button">Reset <i class="icon-refresh"></i></button>
						</div>
						<div class="span6">
							 <button data-action="run" class="btn btn-primary" type="button">Run <i class="icon-play"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="APIDetails" class="template">
			<div class="row-fluid">
				<div class="span6">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th colspan="2">General</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>API Call</th>
								<td data-key="call"></td>
							</tr>
							<tr>
								<th>Data Type</th>
								<td data-key="type"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="span6">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th colspan="2">Parameters</th>
							</tr>
						</thead>
						<tbody data-key="parameters">
							<tr>
								<th>Name</th>
								<th>Reference</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div id="APIDescription" class="template">
			<div class="container-fluid">
				<div class="span12 contentBox">
					<p></p>
				</div>
			</div>
		</div>
		
		<script src="asset/js/jquery.js"></script>
		<script src="asset/js/bootstrap.min.js"></script>
		<script src="asset/js/markdown.js"></script>
		<script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
		<script src="asset/js/api.js"></script>
	</body>
</html>