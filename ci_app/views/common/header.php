<?php echo doctype('xhtml1-trans'); ?>
<html>
<head>
<title><?php if(!empty($title)){echo htmlspecialchars($title);}else{echo __('IP_DEFAULT_TITLE');} ?></title>
<meta http-equiv="Content-language" content="vi" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="title" content="<?php if (!empty($title)){echo htmlspecialchars($title);}else{echo __('IP_DEFAULT_TITLE');} ?>" />
<meta name="keywords" content="<?php if (!empty($keywords)){echo htmlspecialchars($keywords);}else{echo __('IP_DEFAULT_KEYWORDS');} ?>" />
<meta name="description" content="<?php if (!empty($description)){echo htmlspecialchars($description);}else{echo __('IP_DEFAULT_DESCRIPTION');} ?>" />

<meta name="format-detection" content="telephone=no">
<?php 
$config = get_cache('configurations_' .  get_language());
?>
<?php 
if(!empty($config)){
    echo (isset($config['webmaster_tracker']))?$config['webmaster_tracker']:'';
    $favicon = !empty($config['favicon'])?base_url().UPLOAD_URL_FAVICON.$config['favicon']:base_url().'images/favicon.png';
}
?>
<link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon">


<link href="frontend/css/style.css" type="text/css" rel="stylesheet" media="screen" /> <!-- General style -->
<link href="frontend/css/prettyPhoto.css" type="text/css" rel="stylesheet" media="screen"><!-- prettyPhoto -->
<link href="frontend/css/tipsy.css" type="text/css" rel="stylesheet" media="screen"><!--tooltip-->
<link href="frontend/css/camera.css" type="text/css" rel="stylesheet" media="screen"><!--camera-->
<link href="frontend/css/jquery.jqzoom.css" type="text/css" rel="stylesheet" media="screen"><!--zoom-->
<link href="frontend/css/jcarousel.css" type="text/css" rel="stylesheet" media="screen" /> <!-- list_work -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Arvo:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="frontend/js/jquery-1.8.2.min.js"></script>

<script type="text/javascript" src="frontend/js/css3-mediaqueries.js"></script><!--mediaqueries-->
<script type="text/javascript" src="frontend/js/modernizr-1.7.min.js"></script><!--modernizr-->
<script type="text/javascript" src="frontend/js/jquery.prettyPhoto.js"></script><!-- prettyPhoto -->
<script type="text/javascript" src="frontend/js/jquery.tipsy.js"></script><!--tooltip-->
<script type='text/javascript' src='frontend/js/jquery.easing.1.3.js'></script> <!--camera slider-->
<script type='text/javascript' src='frontend/js/camera.min.js'></script> <!--camera slider-->
<script type="text/javascript" src="frontend/js/jquery.jcarousel.min.js"> </script> <!-- list_work -->
<script type="text/javascript" src="frontend/js/jquery-hover-effect.js"></script><!--Image Hover Effect-->
<script type='text/javascript' src='frontend/js/jquery.hoverIntent.minified.js'></script><!--menu-->
<script type='text/javascript' src='frontend/js/jquery.dcmegamenu.1.3.3.js'></script><!--menu-->
<script type='text/javascript' src="frontend/js/jquery.tweet.js"></script><!--twitter plugin-->
<script type="text/javascript" src="frontend/js/jquery.quovolver.js"></script><!--blockquote-->
<script type='text/javascript' src="frontend/js/jquery.jqzoom-core.js"></script><!--image zoom-->
<script type="text/javascript" src="frontend/js/organictabs.jquery.js"></script><!--tabs-->
<script type="text/javascript" src="frontend/js/custom.js"></script><!--custom-->

<!--MENU-->
<script type="text/javascript">
$(document).ready(function($){
    $('#mega-menu-3').dcMegaMenu({
        rowItems: '2',
        speed: 'fast',
        effect: 'fade'
    });
});
</script>

<script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-73158602-1', 'auto');  ga('send', 'pageview');</script>
</head>
<body>

