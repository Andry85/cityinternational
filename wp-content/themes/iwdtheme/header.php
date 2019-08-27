<?php
namespace IllicitWeb;

?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
<meta charset="<?php bloginfo('charset') ?>">
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title(' | ', true, 'right') ?></title>
<link rel="shortcut icon" href="/favicon.ico">
<?php 

wp_head();

?>
<link rel="stylesheet" type="text/css" href="<?= THEME_URL 
	?>scss/build/main.css?<?php if (debugging()) echo time().rand(0, 999) ?>">
</head>
<body <?php body_class() ?>>
<?php

if (!debugging())
{
	dynamic_sidebar('ga');
}

?>
<div id="global-wrapper">
	<?= new SimpleHeaderPrinter() ?>
	<div id="body-wrapper">
