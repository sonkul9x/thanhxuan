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

<!-- style -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frontend/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frontend/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frontend/css/bootstrap-theme.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<style>
    body {padding: 0;}
    .demo_container {
        max-width: 100%;
        width: 100%;
        height: auto;
    }
    .demo_panel {
        background: none repeat scroll 0 0 darkred;
        color: #fff;
        height: 60px;
        max-width: 100%;
        padding: 10px 20px;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
    .demo_panel > h1 {
        color: #fff;
        font-size: 18px;
        margin: 10px 0;
    }
    .demo_panel > a {
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        padding: 7px;
    }
    .demo_panel > a > i {
        padding-right: 7px;
    }
    .demo_image {
        padding-top: 60px;
    }
    .demo_image img {
        max-width: 100%;
        width: 100%;
        height: auto;
    }
    .demo_iframe {
        position: absolute;
        height: 100%;
        max-width: 100%;
        padding-top: 60px;
        width: 100%;
        z-index: 999;
    }
</style>

</head>
<body>
<div class="demo_container">
    <?php if (isset($main_content)) {echo $main_content;} ?>
</div>
    
<?php 
if(!empty($config)){
    echo (isset($config['google_tracker']))?$config['google_tracker']:'';
}
?>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/home.js"></script>

<?php if(isset($scripts)){echo $scripts;} ?>
</body>
</html>