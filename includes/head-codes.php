<base href="">
<meta charset="utf-8" />
<title>dERM <?= (!empty($pageTitle)) ? '| ' . $pageTitle : '' ?></title>
<!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!--begin::Fonts -->
<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">-->
<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed:500">-->
<link href="assets/css/font-asap.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<link href="assets/css/font-sanfrancisco.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<link href="assets/plugins/global/fontawesome.all.min.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<!--end::Fonts -->

<!--begin::Page Vendors Styles(used by this page) -->

<!--end::Page Vendors Styles -->

<!--begin::Global Theme Styles(used by all pages) -->
<link href="assets/plugins/global/plugins.bundle.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<link href="assets/css/style.bundle.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<!--end::Global Theme Styles -->

<!--begin::Layout Skins(used by all pages) -->
<link href="assets/css/custom.css?v=<?=$siteJsVersion?>" rel="stylesheet" type="text/css" />
<!--end::Layout Skins -->

<link rel="shortcut icon" href="assets/media/favicon/favicon.ico?v=<?=$siteJsVersion?>"/>
<!--<meta name="theme-color" content="#317EFB"/>-->

<!--begin::webapp conf -->
<link rel="manifest" href="manifest.json">
<link rel="icon" type="image/png" sizes="16x16" href="assets/media/favicon/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/media/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/media/favicon/favicon-96x96.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">
<meta name="apple-mobile-web-app-title" content="dERM">
<meta name="application-name" content="dERM">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-1242x2148.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-1536x2048.png" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-1668x2224.png" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="assets/media/splash/launch-2048x2732.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-icon" sizes="180x180" href="images/icons/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="57x57" href="assets/media/favicon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="assets/media/favicon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/media/favicon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="assets/media/favicon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/media/favicon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="assets/media/favicon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="assets/media/favicon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="assets/media/favicon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicon/apple-touch-icon-180x180.png">
<link rel="mask-icon" href="assets/media/favicon/safari-pinned-tab.svg" color="#000000">
<meta name="msapplication-TileColor" content="#000000">
<meta name="msapplication-TileImage" content="assets/media/favicon/mstile-144x144.png">
<meta name="msapplication-config" content="assets/media/favicon/browserconfig.xml">
<meta name="theme-color" content="#000000">
<!--end::webapp conf -->

<script type="text/javascript">
    var siteUrl = '<?=$siteUrl?>';
    var currentUserId = '<?=isset($CurrentUser['id']) ? $CurrentUser['id'] : ''?>';
    var currentUserName = '<?=isset($CurrentUser['name']) ? $CurrentUser['name'] : ''?>';
    var currentUserSurname = '<?=isset($CurrentUser['surname']) ? $CurrentUser['surname'] : ''?>';
</script>

<script src="assets/plugins/Highcharts-9.2.2/code/highcharts.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/highcharts-more.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/modules/stock.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/modules/exporting.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/modules/export-data.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/modules/accessibility.js?v=<?=$siteJsVersion?>"></script>
<script src="assets/plugins/Highcharts-9.2.2/code/themes/grid-light.js?v=<?=$siteJsVersion?>"></script>
