<?php
/*
|
|--------------------------------------------------------------------------
| ПЕРЕМЕННЫЕ
|--------------------------------------------------------------------------
| - $is_front - TRUE, если данная страница первая.    
| - $messages - Системные сообщения: оштбки обработки формы, подтверждения.
| - $site_name - Название сайта согласно настройкам.
| - $site_slogan - Слоган сайта согласно настройкам.
| - $title - Основной заголовок в разделе <body>.
|
|--------------------------------------------------------------------------
| ОБЛАСТИ
|--------------------------------------------------------------------------
| - $page['content'] - Основное содержание - <?php print render($page['content']); ?>
| - $page['sidebar'] - Боковая колонка.
| - $page['frontpage_content'] - Содержание первой страницы. TODO: Проверить — может, можно обойтись
|
|--------------------------------------------------------------------------
| НЕ ИСПОЛЬЗУЮ
|--------------------------------------------------------------------------
| - $action_links - Ссылки действий над данной страницей — например, «Добавить».
| - $base_path - Путь к каталогу, в котором установлен В. По умолчанию — /. Для ссылки на первую страницу рекомендуется использовать $front_page — в зависимости от языка и настроек будет добавлен субдомен или каталог.
| - $breadcrumb - «Хлебные крошки» для текущей страницы.
| - $directory - Директория, в которой содержится шаблон данного уровня. В случае с page.tpl.php - modules/system или themes/new_site2013.
| - $feed_icons — Строка пиктограмм-ссылок для всех RSS-лент доступных с текущей страницы.
| - $front_page — URL первой страницы. По умолчанию — /. В зависимости от языка и настроек будет добавлен субдомен или каталог.
| - $is_admin - TRUE, если пользователь имеет доступ к административному разделу.
| - $logged_in - TRUE, если сайт просматривает пользователь, который зарегистрирован и авторизован.
| - $logo — Путь к изображению логотипа согласно настройкам.
| - $main_menu - Массив ссылок основного меню. Пуст, если меню не настраивалось.
|     <?php if ($page['navigation'] || $main_menu): ?>
|         …
|         <?php print theme('links__system_main_menu', array(
|         'links' => $main_menu,
|         'attributes' => array(
|         'id' => 'main-menu',
|         'class' => array('links', 'inline', 'clearfix'),
|         ),
|         'heading' => array(
|         'text' => t('Main menu'),
|         'level' => 'h2',
|         'class' => array('element-invisible'),
|         ),
|         )); ?>
|         …
|         <?php print render($page['navigation']); ?>
|         …
|     <?php endif; ?>
| - $node - Узел, основное содержание страницы, если в системном URL ID узла находится во второй позиции. Например, node/1234 и node/1234/revisions, но не comment/reply/1234.
| - $secondary_menu - Массив ссылок вспомогательного меню. Пуст, если меню не настраивалось.
| - $secondary_menu_heading - Заголовок вспомогательного меню.
| - $tabs - Массив вкладок со ссылками на вложенные структуры и различные состояния текущей страницы — например, «Смотреть», «Правка».
|     <?php if ($tabs = render($tabs)): ?>
|     <?php print $tabs; ?>
|     <?php endif; ?>
| - $title_prefix - Массив дополнительной разметки, которые различные модули могут выводить до основного заголовка в разделе <body>.
| - $title_suffix - Массив дополнительной разметки, которые различные модули могут выводить после основного заголовка в разделе <body>.
|     <?php print render($title_prefix); ?>
|     <?php if ($title): ?>
|     <h1><?php print $title; ?></h1>
|     <?php endif; ?>
|     <?php print render($title_suffix); ?>
| 
|--------------------------------------------------------------------------
| «РОДИТЕЛЬСКИЕ» ФУНКЦИИ (см. includes/theme.inc и modules/system/html.tpl.php)
|--------------------------------------------------------------------------
| - template_preprocess()
| - template_preprocess_page()
| - template_process()
|
*/
?>

<!-- Здесь можно начинать разметку -->

<!-- Пример условной конструкции --><?php if ($condition): ?>
<?php else: /* Comment */ ?>
<?php endif; ?>

<!--Main Menu-->
<?php require_once("ru/_inc/menu.inc"); ?>

<a href="/" title="" rel="home"><?php print $site_name; ?></a>

<!-- Слоган -->
<?php if ($site_slogan): ?>
<h2><?php print $site_slogan; ?></h2>
<?php endif; ?>


<?php print render($page['content']); ?>


<?php print render($page['sidebar']); ?>

<?php
// Титульные страницы архива новостей — блок навигации
if (preg_match('/^\/ru/news/', $_SERVER['REQUEST_URI'])) {
	require_once("ru/_inc/news-archive.inc");
}

// Cтраницы новостей — Блок навигации по архиву и дата
global $i18n_langpath;

$var = 'Bob';

if (preg_match('/^\/ru/news/', $_SERVER['REQUEST_URI'])) {
	require_once("ru/_inc/news-archive.inc");
}

switch($node->type) {
case 'news_04':
case 'news_05':
case 'news_06':
case 'news_07':
case 'news_08':
case 'news_09':
case 'news_10':
case 'news_11':
case 'news_ru':
	if ($i18n_langpath == ru) {
  require_once("ru/_inc/news-archive.inc");
  } ?>
<div class="date"><?php print format_date($node->created, 'custom', "d.m"); ?> /</div>
<?php break;
}
?>
</header>

<?php print $content;

switch($_SERVER['REQUEST_URI']) { // Блок новостей на титульной странице раздела Компания. См. также TASK
case '/ru/company':
case '/ru/company/':
case '/ru/company/index.htm':
	require_once("ru/_inc/overview.inc");
break;
case '/ru/community':
case '/ru/community/':
case '/ru/community/index.htm':
	require_once("ru/_inc/community.inc");
break;
}

if ($node->type == 'video_tutorials'): ?>

<div class="fb-comments" data-href="<?php print $full_path; ?>" data-num-posts="10" data-width="580"></div>
</div><!--/ Synopsis and comments — .panes-->

<!-- Social media buttons / если тип материала video_tutorials-->
<ul id="share" class="floater">
<!-- Facebook. Remove .fb styles to show count -->
<li class="fb">
<div style="position: absolute; left: 16px; bottom: 0" class="fb-like" data-send="false" data-layout="box_count" data-width="78" data-show-faces="false" data-font="arial"></div>
</li>
<li class="tw">
<!-- Twitter. Set data-count="vertical" to show count -->
<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="none">Твит</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</li>
<li class="in">
<!-- LinkedIn. Add data-counter="top" to show count -->
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share"></script>
</li>
<li class="goo">
<!-- Google+. Required plusone.js. Remove data-annotation="none" to show count -->
<div class="g-plusone" data-size="tall" data-annotation="none"></div>
</li>
<li class="su"><iframe src="http://www.stumbleupon.com/badge/embed/6/?url=<?php print $full_path; ?>" id="iframe-stmblpn-widget-1" width="30" height="31" style="margin: 0; padding: 0; border: 0 none; overflow: hidden;"></iframe></li>
<li class="deli"><a href="http://www.delicious.com/save" onClick="window.open('http://www.delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=550,height=550'); return false;">Delicious</a></li>
<li class="red"><a href="http://reddit.com/submit?url=<?php print $full_path; ?>&amp;title=<?php print urlencode($title); ?>" title="в Reddit" target="_blank" rel="nofollow">Reddit</a></li>
<li class="pin"><a href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'>Pin It</a></li>
</ul>
<?php endif; ?>

</article>
<!-- /main content -->

</div>
<!-- /content -->

<!-- FOOTER ———————————————————————— -->
<footer id="footer">
<?php require_once("ru/_inc/footer.inc"); ?>
</footer>

</div><!--/container-->

<?php require_once("ru/_inc/scripts.inc"); ?>
