<?php echo doctype('xhtml1-trans'); ?>
<html>
    <meta name="keywords" content="<?php if (isset($meta_keywords)) echo $meta_keywords; else echo DEFAULT_ADMIN_KEYWORDS; ?>" />
    <meta name="description" content="<?php if (isset($meta_description)) echo $meta_description; else echo DEFAULT_ADMIN_DESCRIPTION; ?>" />
    <meta name="title" content="<?php if (isset($title)) echo $title; else echo DEFAULT_ADMIN_TITLE; ?>" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="author" content="www.infopowers.net" />
    <meta name="copyright" content="Copyright by PowerCMS. All rights reserved." />
    <title><?php if (isset($title)) echo $title; else echo DEFAULT_ADMIN_TITLE; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" href="/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/powercms/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/css/base/ui.all.css" />
    <link rel="stylesheet" type="text/css" href="/powercms/css/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="/powercms/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="/powercms/fa/css/font-awesome.min.css" />
    {IMPORT_CSS}
</head>
<body>
