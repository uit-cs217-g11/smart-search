<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? if ($PROFILE_DEVICE == DEVICE_TABLET) { ?>
<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0"> -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<? } ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="en-gb" />
<meta name="robots" content="index,follow" />

<title><?=$META_TITLE?></title>
<link rel="icon" type="image/ico" href="/statics/<?=$PATH_VIEW?>/favicon.ico" />

<meta name="keywords" content="<?=$META_KEYWORD?>" />
<meta name="description" content="<?=$META_DESC?>" />

<meta property="og:title" content="<?=$META_TITLE?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="<?=$META_IMG?>" />
<meta property="og:url" content="<?=$META_URL?>" />
<meta property="og:site_name" content="<?=$META_SITENAME?>" />
<meta property="og:description" content="<?=$META_DESC?>" />
<meta property="fb:app_id" content="<?=FB_APP_ID?>" />

<?	
	$STATICS_CSS = '';
	$STATICS_JS = '';
	
	$STATICS_CSS .= '<link type="text/css" rel="stylesheet" href="' . $URL_STATICS . '/100/shared/styles/stdio/css_articles_printing.css" />';
?>

<?=$STATICS_CSS . $STATICS_JS?>

</head>
<body>
<div class="container">
	<div class="cover">
		<div class="link">
			<div class="qrcode"><img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?=urlencode(URL_HOME.'/articles/read/'.$Article->a_id.'-'.$Article->a_friendly_url)?>" height="100%" /></div>
			<div class="title"><?=$Article->a_title?></div>
		</div>
		<div class="brief">
			<?=$Article->a_brief?>
		</div>
		<div class="author">
			<div class="name">
				<?=GetNameByOrder($Article->a_first_name, $Article->a_last_name, $Article->a_name_order)?> • <?=date('d/m/Y', strtotime($Article->a_date_created))?>
			</div>
		</div>
		<div class="article_meta">
			<h2>THÔNG TIN</h2>
			<p>
				<?=URL_HOME?>/articles/read/<?=$Article->a_id.'/'.$Article->a_friendly_url?><br/>
				<?=GetNameByOrder($Article->a_first_name, $Article->a_last_name, $Article->a_name_order)?> - <?=URL_HOME?>/users/index/<?=$Article->a_author_id.'/'.$Article->aa_friendly_url?>
			</p>
		</div>
		<div class="brand">
			<div class="logo"><img src="<?=$URL_STATICS?>/100/shared/styles/stdio/img_logo_printing.png" alt="<?=$META_SITENAME?>"/></div>
		</div>
	</div>
	<div class="article_box">
		<article class="article_content">
			<?=$Article->a_content?>
		</article>
	</div>
</div>

</body>