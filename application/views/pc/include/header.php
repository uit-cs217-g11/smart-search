<!DOCTYPE html>
<html>
<head>

<base href="<?=base_url()?>">

<!--<meta http-equiv="Cache-control" content="max-age=0">-->
<? if ($PROFILE_DEVICE == DEVICE_TABLET) { ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<? } ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="en-gb" />
<meta name="robots" content="index,follow" />

<title><?=$META_TITLE?></title>
<link rel="icon" type="image/ico" href="/statics/shared/favicon.ico" />

<meta name="keywords" content="<?=$META_KEYWORD?>" />
<meta name="description" content="<?=$META_DESC?>" />

<meta property="og:title" content="<?=$META_TITLE?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="<?=$META_IMG?>" />
<meta property="og:url" content="<?=$META_URL?>" />
<meta property="og:site_name" content="<?=$META_SITENAME?>" />
<meta property="og:description" content="<?=$META_DESC?>" />

<link rel="stylesheet" type="text/css" href="statics/pc/css_styles.css">

</head>

<body>

<header class="wrapper_section wrapper_header">
	<div class="wrapper_section_center wrapper_header_center">
		<div class="head_logo"><a href=""><img src="<?=URL_HOME?>/statics/shared/img_logo.png" alt="<?=$META_SITENAME?>" title="<?=$META_SITENAME?>"/></a></div>
		<div class="wrapper_menu">
			<a class="head_navigate_button<?=($SEGMENT_1==''||$SEGMENT_1=='home')?'_active':''?>" href=""><span>TRANG CHỦ</span></a>
			<a class="head_navigate_button<?=$SEGMENT_1=='articles'?'_active':''?>" href="articles"><span>BÀI VIẾT</span></a>
			<a class="head_navigate_button<?=$SEGMENT_1=='info'?'_active':''?>" href="info"><span>THÔNG TIN</span></a>
			<a class="head_navigate_button<?=$SEGMENT_1=='developers'?'_active':''?>" href="developers">NHÓM PHÁT TRIỂN</a>
		</div>
	</div>
</header>