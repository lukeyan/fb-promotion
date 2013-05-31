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
		<div class="span4">
			<h3>
				我的社团
			</h3>
			<ol class="unstyled">
                            <?php foreach($groups['data'] as $key =>$val){ ?>
				<li>
					<?php echo "<a href='http://www.facebook.com/".$val['id']."'>".$val['name']."</a>";?>
				</li>
                                
                                <?php }?>
				
			</ol>
		</div>
		<div class="span4">
			 <button class="btn btn-success btn-block btn-large" type="button">发布消息</button>
		</div>
		<div class="span4">
			<h3>
				消息列表 <button class="btn btn-primary" onclick="javascript:location.href='/facebook/addmsg'" type="button">Add Message</button>
			</h3>
			<ol>
                            <?php foreach($my_msg as $k =>$v){ ?>
				<li>
					<?php echo $v['content'];?> <span class="label label-inverse"><a href="/facebook/delmsg/<?php echo $v['id'];?>">删除</a></span> 
				</li>
                                
                                <?php }?>
				
			</ol>
		</div>
	</div>
</div>
</body>
</html>
