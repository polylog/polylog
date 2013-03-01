<?php
/*
	ПЕРЕМЕННЫЕ
	- $classes — Контекстно-зависимая строка классов элемента <body>. Наиболее полезные классы по умолчанию: .front, .node-type-[node type]. Другие классы: not-front, logged-in, not-logged-in… Можно добавить классы через template.php — http://stackoverflow.com/questions/7700838/adding-a-class-to-body/7700886#7700886
	- $head — Мета-теги, генерируемые D: description, open graph
	- $head_title — Значение <title>
	- $language - Объект «язык страницы»: $language->language - двухбуквенный код; $language->dir — напрваление письма: ltr или rtl
	- $page — Содержание страницы.
	
	НЕ ИСПОЛЬЗУЮ
	- $css - «Массив ccs-файлов» (может, имеется в виду строчные стили?)

    For example, if the node is a Blog entry, this would be "node-type-blog".
	- $grddl_profile - Значение атрибута profile тега head, URI правил (GRDDL-профилей), позволяющих браузерам понимать RDF-значения мета-тегов; атрибут profile не поддерживается стандартом HTML5, рекомендуется использовать атрибут prefix
	- $head_title_array - Ассоциативный массив, ключи title, name, slogan
	- $is_front — Проверка: первая страница или нет
	- $jump_link_target - ID пункта назначения ссылки "Jump to Navigation" — обычно, основного меню
	- $page_top — Разметка динамически генерируемых элементов, выводимых в первых строчках кода
	- $page_bottom - Разметка динамически генерируемых элементов, выводимых в заключении кода
	- $rdf_namespaces —  Все пространства имен модели RDF, используемые в документе — http://habrahabr.ru/post/94707/ http://xmlhack.ru/texts/06/microformats/microformats.html http://richard.cyganiak.de/blog/2011/02/top-100-most-popular-rdf-namespace-prefixes/
	- $styles — Необходимые стили в представлении D
	- $scripts — Необходимые скрипты в представлении D
	
	«РОДИТЕЛЬСКИЕ» ФУНКЦИИ (см. includes/theme.inc и modules/system/html.tpl.php)
	- template_preprocess()
	- template_preprocess_html()
	- template_process()
 */
?>
<!DOCTYPE html>
<html lang="<?php print $language->language; ?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="utf-8">
    <title><?php print $head_title; ?></title>
	<?php print $head; ?>

    <!-- Mobile -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width">

    <link rel="alternate" href="http://feeds.feedburner.com/polylog/pr" type="application/rss+xml" title="RSS">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.gif" type="image/gif">
    <link rel="stylesheet" href="/a/css/styles.css?121220a">

    <meta name="author" content="Владимир Никишин, «Полилог» — www.nickysheen.ru">

    <!--[if (lt IE 9) & (!IEMobile)]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="/a/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="<?php print $classes; ?>">
 <?php print $page; ?>
</body>
</html>
