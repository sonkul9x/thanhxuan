<?php echo doctype('xhtml1-trans'); ?>
<html>
    <meta name="keywords" content="<?php if (isset($meta_keywords)) echo $meta_keywords; else echo DEFAULT_ADMIN_KEYWORDS; ?>" />
    <meta name="description" content="<?php if (isset($meta_description)) echo $meta_description; else echo DEFAULT_ADMIN_DESCRIPTION; ?>" />
    <meta name="title" content="<?php if (isset($title)) echo $title; else echo DEFAULT_ADMIN_TITLE; ?>" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="author" content="www.infopowers.net" />
    <meta name="copyright" content="Copyright by PowerCMS. All rights reserved." />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php if (isset($title)) echo $title; else echo DEFAULT_ADMIN_TITLE; ?></title>
    <?php $config = get_cache('configurations_' .  get_language()); ?>
    <?php if(!empty($config)){
        $favicon = !empty($config['favicon'])?base_url().UPLOAD_URL_FAVICON.$config['favicon']:'/powercms/images/favicon.png';
    } ?>
    
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon">
<!--    <link rel="icon" href="/powercms/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/powercms/images/favicon.png" type="image/x-icon" />-->
    <link rel="stylesheet" type="text/css" href="/plugins/960/reset.css" />
    <link rel="stylesheet" type="text/css" href="/plugins/fa/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/plugins/base/ui.all.css" />
    <link rel="stylesheet" type="text/css" href="/powercms/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="/powercms/css/uploadify.css" />
    
    <link rel="stylesheet" type="text/css" href="/plugins/datetimepicker/jquery-ui.css" media="all" />
    <link rel="stylesheet" type="text/css" href="/plugins/datetimepicker/jquery-ui-timepicker-addon.min.css" media="all" />
    {IMPORT_CSS}

</head>
<body>
