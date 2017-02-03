<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Тестовое задание для PowerCode</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>
    <header class="container-fluid">
		<div class="col-lg-11">
			<a href="/" class="header-title">Тестовое задание для PowerCode</a>
		</div>
		<div class="col-lg-1">
		<?php 
		//отображаем кнопку "обновить" на всех страницах кроме edit
		if(!isset($_GET['edit'])){
			echo '<a class="btn btn-default checknow" onclick="showAllTasks()"><span class="glyphicon glyphicon-refresh"></span></a>';
		}
		?>
		</div>
    </header>
    	<div class="container">
		<div class="wrapper">
  	        <div class="row">
				<div class="col-lg-12">
				<?php
				if(isset($_GET['edit'])){
					include_once 'includes/edit.php';
				} else {
					include_once 'includes/form.php';
				}
				?>
				</div>
    		</div><!-- row -->
    	</div><!-- container-->
    </div><!-- wrapper-->

    <footer>
		<div class="container">
			<div class="footer-content">
				<p>Тестовое задание для PowerCode</p>
			</div>
		</div>
		
    </footer>
 </body>
</html>
