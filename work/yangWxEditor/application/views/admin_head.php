<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<title>文章传播系统</title>
<base href="<?php echo $this->config->item('base_url'); ?>" />

<link href="cp/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
<link href="cp/font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

<link href="cp/css/animate.css" rel="stylesheet">
<link href="cp/css/style.css?v=2.2.0" rel="stylesheet">
<link href="static/css/cp.css" rel="stylesheet">

<script src="cp/js/jquery-2.1.1.min.js"></script>
<script src="cp/js/bootstrap.min.js?v=3.4.0"></script>
<script src="static/js/cp.js"></script>
</head>
<body<?php if(isset($body_class))echo ' class="'.$body_class.'"' ?>>
<?php if(!isset($no_side) || $no_side!=1)echo '<div id="wrapper">'; ?>
