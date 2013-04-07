<?php
/*
|
|-------------------------------------------------------------------------------
| ПЕРЕМЕННЫЕ и ФУНКЦИИ
|-------------------------------------------------------------------------------
|
| Переменные примитивных типов данных включаются в шаблон только через конструкцию print
| <?php print $variable; ?>
| переменные-массивы — еще и через функциюю render()
| <?php print render($tabs); ?>
|
| - $content - Массив элементов содержания. Команда для вывода всего содержания —
|   render($content). Для отдельного элемента — render($content['field_example']).
|   Чтобы не выводить тот или иной элемент - hide($content['field_example'])
| - $is_front - TRUE, если данная страница первая.
| - $title - Основной заголовок в разделе <body>.
| - $node_url - URL старницы
| - format_date() - дата в нужном вормате. Например, format_date($node->created, 'custom', 'd');
|
|-------------------------------------------------------------------------------
| НЕ ИСПОЛЬЗУЮ
|-------------------------------------------------------------------------------
|
| - $submitted - Информация об авторстве и дате публикации согласно template_preprocess_node().
| - $display_submitted - Выводить ли информацию об авторстве и дате публикации.
| - $user_picture - Портрет автора по шаблону user-picture.tpl.php.
| - $date - Дата публикации.
| - $name — Имя пользователя автора согласно theme_username().
| - $classes — Контекстно-зависимая строка классов элемента <body>. Наиболее
|   полезный класс по умолчанию .node-[node type]. Другие классы: front,
|   node-teaser, view-mode-[mode] ('full' или 'teaser')… Можно добавить классы через
|   template.php — http://stackoverflow.com/questions/7700838/adding-a-class-to-body/7700886#7700886
| - $title_prefix - Массив дополнительной разметки, которые различные модули
|   могут выводить до основного заголовка в разделе <body>.
| - $title_suffix - Массив дополнительной разметки, которые различные модули
|   могут выводить после основного заголовка в разделе <body>.
|   <?php print render($title_prefix); ?>
|   <?php if ($title): ?>
|   <h1><?php print $title; ?></h1>
|   <?php endif; ?>
|   <?php print render($title_suffix); ?>

 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content. Currently broken; see http://drupal.org/node/823380
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
|
|
|-------------------------------------------------------------------------------
| «РОДИТЕЛЬСКИЕ» ФУНКЦИИ (@see includes/theme.inc и modules/system/html.tpl.php)
|-------------------------------------------------------------------------------
|
|
|
|-------------------------------------------------------------------------------
| CHEATSHEET
|-------------------------------------------------------------------------------
|
| Стнадарты кодирования:
| http://drupal.org/coding-standards
| http://drupal.org/node/1354
| http://ellislab.com/codeigniter/user-guide/general/styleguide.html
|
| <?php if($this->value): ?>
| …В целях удобочитаемости в php-шаблонах используется альтернативный синтаксиса
| контрольных конструкций if () : … elseif(): …
| <?php elseif($this->asd): ?>
| …легче читаемый в HTML
| <?php else: ?>
| …HTML…
| <?php else: ?>
| …HTML…
| <?php endif; ?>
|
| <article<?php if ($page == 0): print ' class="tsr"'; elseif ($sticky): print ' class="tsr sticky"'; endif ?>>
|
| Стандарт Drupal: elseif, а не else if
|
| <?php if ($node->type == 'frontpage') { ?>
| …Универсальный синтаксис if () {}…
| <?php } elseif ($t<"20") { ?>
| …не используется…
| <?php } else { ?>
| …HTML…
| <?php } ?>
|
| switch ($favcolor) {
| case 'red':
| case 'black':
|   print 'Your favorite color are red or black';
|   break;
| case 'blue':
|   return 'Your favorite color is blue!';
| default:
|   print 'Your favorite color is neither red, blue, or green!';
|   // There is no need in break for default
| }
|
| $array_name = array('item1', 24, $some_var);
| if (in_array('string or variable',$array_name) or !in_array()
|
| <meta property="og:type" content="<?php ($node->type == 'frontpage') ? print 'website' : print 'article'; ?>">
|
| <?php require_once("ru/_inc/menu.inc"); ?>
|
| if (preg_match('^/en/company(.*)', $v3_path)):
|
| http://www.w3schools.com/php/
| http://www.phpf1.com/tutorial/php-regular-expression.html
| http://drupal.org/node/190815
| http://drupal.org/node/1089656
|
*/

/**
 * Available variables:
 *
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>


<?php print render($title_prefix); ?>
<?php if (!$page && $title): ?>
<h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
<?php endif; ?>
<?php print render($title_suffix); ?>

<?php if ($unpublished): ?>
<div class="unpublished"><?php print t('Unpublished'); ?></div>
<?php endif; ?>

<?php if ($display_submitted): ?>
<div class="submitted">
  <?php print $submitted; ?>
</div>
<?php endif; ?>

<div class="content"<?php print $content_attributes; ?>>
<?php
  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);
  print render($content);
?>
</div>

<?php print render($content['links']); ?>

<?php print render($content['comments']); ?>

</div><!-- /.node -->
