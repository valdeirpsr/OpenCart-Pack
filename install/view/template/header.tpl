<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen" />
<link href="view/javascript/bootstrap/stylesheet.css" rel="stylesheet" media="screen" />
<script src="view/javascript/bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="view/javascript/common.js" type="text/javascript"></script>

<?php foreach($scripts as $script) { ?>
<script src="<?php echo $script ?>" type="text/javascript"></script>
<?php } ?>

<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />

<?php foreach($styles as $style) { ?>
<link rel="<?php echo $style['rel'] ?>" media="<?php echo $style['media'] ?>" type="text/css" href="<?php echo $style['href'] ?>" />
<?php } ?>
</head>
<body>