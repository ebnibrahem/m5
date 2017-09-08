<?php
use M5\MVC\App;
use M5\MVC\Config;
use M5\Library\Page;
?>

<!DOCTYPE html>
<html lang="<?= APP::getRouter()->getLanguage() ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>  <?=!$data['title'] ? site_name : $data['title'] ; ?></title>

	<?php require view() . 'widgets/cdn_css.php'; ?>
	<link rel="stylesheet" href="<?= assets('css/style.css'.CACHE_VAR) ?> ">
	<link rel="stylesheet" href="<?= assets('css/smart.css'.CACHE_VAR) ?> ">

	<meta name="keywords"    content="<?=$this->website['other']?>,<?=$this->SEO?>">
	<meta name="description" content="<?=$this->SEO_DESC?>">
	<meta name="author"      content="<?=site_name?>">
	<meta property="image"   content="<?= !$this->SEO_IMG ? LOGO : $this->SEO_IMG?>" />
	<meta property="type"    content="article" />

	<meta property="og:title"       content="<?=!$data['title'] ? site_name : $data['title'] ; ?>" />
	<meta property="og:keywords"    content="<?=$this->website['other']?>,<?=$this->SEO?>">
	<meta property="og:description" content="<?=$this->SEO_DESC?>" />
	<meta property="og:image"       content="<?= !$this->SEO_IMG ? LOGO : $this->SEO_IMG?>" />
	<meta property="og:url"         content="<?=page::url()?>" />
	<meta property="og:type"        content="article" />

	<!-- ebnibrahem AT gmail.com -->
</head>