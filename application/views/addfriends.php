<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Facebook Promotion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="<?php echo base_url();?>statics/less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="<?php echo base_url();?>statics/less/responsive.less" type="text/css" /-->
	<!--script src="<?php echo base_url();?>statics/js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="<?php echo base_url();?>statics/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>statics/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>statics/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>statics/js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="<?php echo base_url();?>statics/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>statics/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>statics/js/scripts.js"></script>
</head>

<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
				</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<h2>
				添加朋友的朋友
			</h2>
			<p>
				因为facebook Ajax 动态加载数据的缘故，因为采取<br/>
				1. 每次随机获取第一页自己的好友（比如数目为50）<br/>
				2. 抓取50个好友对应的朋友（可能一页是20个），录入数据库，已经是好友的跳过<br/>
				3. 然后读取数据库，尚未是好友的发送好友请求，并标示isfriend 为1<br/>
				4. 按刷新键再重复一次上述<br/>
			</p>
			<p>
				<a class="btn" href="#">刷新发送添加好友请求»</a>
			</p>
			<div class="progress progress-striped active">
				<div class="bar" style="width: 60%;">
				</div>
			</div>
			
		</div>
	</div>
</div>
</body>
</html>
