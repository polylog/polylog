<?php
/*
|
|--------------------------------------------------------------------------
| ПЕРЕМЕННЫЕ
|--------------------------------------------------------------------------
| Могут использоваться любые переменные, передаваемые в html.tpl.php и page.tpl.php.
| Но я не вижу в этом смысла. Страничку можно украсить: например, разводным ключом и
| ногами автослесаря, валяющегося под днищем. См. также
| http://www.smashingmagazine.com/2009/06/12/effective-maintenance-pages-examples-and-best-practices/
| 
|--------------------------------------------------------------------------
| «РОДИТЕЛЬСКИЕ» ФУНКЦИИ
|--------------------------------------------------------------------------
| @see template_preprocess() — includes/theme.inc
| @see template_preprocess_maintenance_page() — includes/theme.maintenance.inc
|
*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Polylog.ru закрыт на техобслуживание || Polylog.ru is currently down for maintenance</title>
    <meta name="description" content="«Полилог»: создаем интерес и уважение (маркетинговые коммуникации: BTL, пиар etc) // We offer integrated, full-service marketing solutions (PR, GR, IR, etc.)">

    <!-- Mobile -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.gif" type="image/gif">

    <meta name="author" content="Владимир Никишин, «Полилог» — www.nickysheen.ru">
    
    <style type="text/css">
	HTML { background: #E3E6EA}
	BODY { background: #FFF; border-radius: 20px; -moz-border-radius: 20px; -webkit-border-radius: 20px; box-shadow: 4px 3px 1px #000; -moz-box-shadow: 0px 1px 2px #B8BBBF; -webkit-box-shadow: 4px 3px 0 #000; color: #535659; font: 81.3%/1.54 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; text-align: center; margin: 60px auto 0; padding: 40px 40px 34px; width: 440px}
	
	HEADER { background: url(/a/img/base-graphics.png) no-repeat -60px 0; display: block; text-indent: -4000em; margin: 0 auto; height: 33px; width: 132px}
	ARTICLE:first-of-type { display: block; padding-bottom: 1.154em}
	H1 { font-size: 261.5%; font-weight: 300; letter-spacing: -.03em; line-height: 1.18; margin: 0; padding: .324em 0 .412em}
	P { margin: 0 0 1.54em}
	</style>

    <!--[if (lt IE 9) & (!IEMobile)]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="/a/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<header>NewSite.com</header>

<article>
    <h1>Извините, сайт polylog.ru закрыт на техобслуживание</h1>
    <p>Возвращайтесь через час — будем ждать.</p>
</article>

<article>
    <h1>Polylog.ru is currently down for maintenance</h1>
    <p>We're working improving the NewSite.com.<br>
    Don't worry, well be right back.</p>
</article>

</body>
</html>
