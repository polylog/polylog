<?php
/*
|
| Использование глобальных переменных в функциях
|
| $x=5; // global scope
| $y=10; // global scope
|
| function myTest() {
|   global $x,$y;
|   $y=$x+$y;
| }
| в данном случае почему-то не работает. Может, оно и к лучшему:
| глобальные переменные считаются плохой практикой — видимо из-за возможности
| доступа злоумышленников
|
| debugging
| community
|       tutorials
|       blog
| промоблоки в боковой колонке
| также в этом разделе вв подвале
| IE
|
*/

/*
|-------------------------------------------------------------------------------
|   1) Функция добавления классов тегу <body> в зависимости от текущего адреса
|-------------------------------------------------------------------------------
*/
function v3_body_classes() {
    /**
    * Делим путь от корневого каталога: заменяем в URL-ах с параметрами знак '?' на '/',
    * затем выбрасываем первый слэш и папку /ru/, остальные части записываем в четыре переменных
    */
    $path = str_replace('?', '/', $_SERVER['REQUEST_URI']);
    list(, , $level_01, $level_02, $level_03, $level_04) = explode('/', $path);

    $class = '';

    // $level_01 - services | clients, case-studies | company, press, news | pr-blog, pr-tutorials, pr-help
    switch ($level_01) {
    case 'services':
        $class = 'p-services';
        break;

    // Clients
    case 'clients':
        $class = 'p-clients';
        break;
    case 'case-studies':
        $class = 'p-clients p-case-studies';
        break;

    // Company
    case 'company':
        $class = 'p-company';
        break;
    case 'press':
        $class = 'p-company p-press';
        break;
    case 'news':
        $class = 'p-company p-news';
        break;

    // Community
    case 'community':
        $class = 'p-community';
        break;
    case 'pr-blog':
        $class = 'p-community p-blog';
        break;
    case 'pr-tutorials':
        $class = 'p-community p-tutorials';
        break;
    case 'pr-help':
        $class = 'p-community p-help';
        break;
    }

    // Set classes to first level indexes
    if (strpos($level_02, 'index.htm') || empty($level_02)) {
        $class .= '-index'; }

    return ' class="' . $class . '"';
}


/*
|-------------------------------------------------------------------------------
| 2) Удаляем из title bbcode: em, strong, span, b, small —
| print v3_strip($head_title)
|-------------------------------------------------------------------------------
|
| Для того, что bbcode не выводился в RSS-лентах, ханкуть ядро:
| В файле includes/common.inc найти функцию format_rss_item и перед первым $output-ом
| добавить $title = v3_strip($title);
|
*/
function v3_strip($text) {
    $bbcode = array(
        '[strong]',
        '[/strong]',
        '[em]',
        '[/em]',
        '[span]',
        '[/span]',
        '[b]',
        '[/b]',
        '[small]',
        '[/small]'
    );
    return str_replace($bbcode, '', $text);
}

/*
|-------------------------------------------------------------------------------
| 3) Переводим bbcode в основном заголовке в html - print v3_bb2html($title)
|-------------------------------------------------------------------------------
*/
function v3_bb2html($text) {
    $bbcode   = array(
        '[strong]',
        '[/strong]',
        '[em]',
        '[/em]',
        '[span]',
        '[/span]',
        '[b]',
        '[/b]',
        '[small]',
        '[/small]'
    );
    $htmlcode = array(
        '<strong>',
        '</strong>',
        '<em>',
        '</em>',
        '<span>',
        '</span>',
        '<b>',
        '</b>',
        '<small>',
        '</small>'
    );
    return str_replace($bbcode, $htmlcode, $text);
}

/*
|-------------------------------------------------------------------------------
| 4) Переписываем theme_item_list
|-------------------------------------------------------------------------------
|
| TODO: Moжет, убрать класс item_list.
| И проверить, нужна ли функция в принципе — убрать и посмотреть на разметку
| генерируемых списков
|
*/
function v3_item_list($items = array(), $title = NULL, $type = 'ul', $attributes = NULL) {
    if (isset($title)) {
        $output = '<h3>' . $title . '</h3>';
    }

    if (!empty($items)) {
        $output .= "<$type class=\"item_list\">";
        foreach ($items as $item) {
            $attributes = array();
            $children   = array();
            if (is_array($item)) {
                foreach ($item as $key => $value) {
                    if ($key == 'data') {
                        $data = $value;
                    } elseif ($key == 'children') {
                        $children = $value;
                    } else {
                        $attributes[$key] = $value;
                    }
                }
            } else {
                $data = $item;
            }
            if (count($children) > 0) {
                $data .= theme_item_list($children, NULL, $type, $attributes); // Render nested list
            }
            $output .= '<li' . drupal_attributes($attributes) . '>' . $data . '</li>';
        }
        $output .= "</$type>";
    }
    return $output;
}

/*
|-------------------------------------------------------------------------------
| 4-бис) Переписываем html списков, создаваемый модулем Views -
| оригинальная функция находится в views.module
|-------------------------------------------------------------------------------
|
| TODO: проверить, нужна ли функция — убрать и посмотреть на разметку
| генерируемых списков
|
*/
function v3_views_view($view, $type, $nodes, $level = NULL, $args = NULL) {
    $num_nodes = count($nodes);

    if ($type == 'page') {
        drupal_set_title(filter_xss_admin(views_get_title($view, 'page')));
        views_set_breadcrumb($view);
    }

    if ($num_nodes) {
        $output .= views_get_textarea($view, $type, 'header');
    }

    if ($type != 'block' && $view->exposed_filter) {
        $output .= views_theme('views_display_filters', $view);
    }

    $plugins   = _views_get_style_plugins();
    $view_type = ($type == 'block') ? $view->block_type : $view->page_type;
    if ($num_nodes || $plugins[$view_type]['even_empty']) {
        if ($level !== NULL) {
            $output .= views_theme($plugins[$view_type]['summary_theme'], $view, $type, $level, $nodes, $args);
        } else {
            $output .= views_theme($plugins[$view_type]['theme'], $view, $nodes, $type);
        }
        $output .= views_get_textarea($view, $type, 'footer');

        if ($type == 'block' && $view->block_more && $num_nodes >= $view->nodes_per_block) {
            $output .= theme('views_more', $view->real_url);
        }
    } else {
        $output .= views_get_textarea($view, $type, 'empty');
    }

    if ($view->use_pager) {
        $output .= theme('pager', '', $view->pager_limit, $view->use_pager - 1);
    }

    if ($output) {
        $output = $output;
    }
    return $output;
}

// Добавляем функции оформления для отдельных видов.
function v3_views_view_list($view, $nodes, $type) {
    $fields = _views_get_fields();

    $taken = array();

    // Set up the fields in nicely named chunks.
    foreach ($view->field as $id => $field) {
        $field_name = $field['field'];
        if (isset($taken[$field_name])) {
            $field_name = $field['queryname'];
        }
        $taken[$field_name] = true;
        $field_names[$id]   = $field_name;
    }

    // Set up some variables that won't change.
    $base_vars = array(
        'view' => $view,
        'view_type' => $type
    );

    foreach ($nodes as $i => $node) {
        $vars           = $base_vars;
        $vars['node']   = $node;
        $vars['count']  = $i;
        $vars['stripe'] = $i % 2 ? 'even' : 'odd';
        foreach ($view->field as $id => $field) {
            $name        = $field_names[$id];
            $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
            if (isset($field['label'])) {
                $vars[$name . '_label'] = $field['label'];
            }
        }
        $items[] = _phptemplate_callback('views-news-teasers', $vars);
    }
    if ($items) {
        return theme('item_list', $items);
    }
}

/*
|-------------------------------------------------------------------------------
| 5) Пэйджер
|-------------------------------------------------------------------------------
| $tags — массив текста ссылок пейджера
| $limit — количество ссылок.
| $element — порядковый номер пейджера на странице
| $parameters — ассоциативный массив параметров ссылок
|
*/
function v3_pager($tags = array(), $limit = 10, $element = 0, $parameters = array()) {
    global $pager_total;
    $output = '';

    if ($pager_total[$element] > 1) {
        $output .= '<div class="paginator cfx">';
        $output .= theme('pager_previous', ($tags[1] ? $tags[1] : '«'), $limit, $element, 1, $parameters);
        $output .= theme('pager_list', $limit, $element, ($tags[2] ? $tags[2] : 4 ), '', $parameters);
        $output .= theme('pager_next', ($tags[3] ? $tags[3] : '»'), $limit, $element, 1, $parameters);
        $output .= '</div>';

        return $output;
    }
}

/*
|-------------------------------------------------------------------------------
| 6) Короткие ссылки — TinyURL
|-------------------------------------------------------------------------------
*/
function v3_get_tinyurl($url) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=" . $url);
    return $tinyurl;
}

/*
|-------------------------------------------------------------------------------
| 7) Переписываем формат вывода массива $links в заметке блога
|-------------------------------------------------------------------------------
|
| TODO: переписать — выводить из массива не все ссылки,
| убрать все классы с LI, рефакторинг
|
*/
function v3_links($links, $attributes = array('class' => 'links')) {
    $output = '';

    if (count($links) > 0) {
        $output = '<ul' . drupal_attributes($attributes) . '>';

        $num_links = count($links);
        $i         = 1;

        foreach ($links as $key => $link) {
            $class = '';

            // Automatically add a class to each link and also to each LI
            if (isset($link['attributes']) && isset($link['attributes']['class'])) {
                $link['attributes']['class'] .= ' ' . $key;
                $class = $key;
            } else {
                $link['attributes']['class'] = $key;
                $class                       = $key;
            }

            // Add first and last classes to the list of links to help out themers.
            $extra_class = '';
            if ($i == 1) {
                $extra_class .= 'first ';
            }
            $output .= '<li class="' . $extra_class . $class . '">';

            // Is the title HTML?
            $html = isset($link['html']) && $link['html'];

            // Initialize fragment and query variables.
            $link['query']    = isset($link['query']) ? $link['query'] : NULL;
            $link['fragment'] = isset($link['fragment']) ? $link['fragment'] : NULL;

            if (isset($link['href'])) {
                $output .= l($link['title'], $link['href'], $link['attributes'], $link['query'], $link['fragment'], FALSE, $html);
            } else if ($link['title']) {
                //Some links are actually not links, but we wrap these in <span> for adding title and class attributes
                if (!$html) {
                    $link['title'] = check_plain($link['title']);
                }
                $output .= '<span' . drupal_attributes($link['attributes']) . '>' . $link['title'] . '</span>';
            }

            $i++;
            $output .= "</li>\n";
        }

        $output .= '</ul>';
    }

    return $output;
}

/*
|-------------------------------------------------------------------------------
| 8) Определение типа материала по адресу
|-------------------------------------------------------------------------------
*/
function v3_content_type() {
    /*
    |   Делим путь от корневого каталога: заменяем в URL-ах с параметрами знак '?' на '/',
    |   затем выбрасываем первый слэш и папку /ru/, остальные части записываем в четыре переменных
    */
    $path = str_replace('?', '/', $_SERVER['REQUEST_URI']);
    list(, , $level_01, $level_02, $level_03, $level_04) = explode('/', $path);

    $content_type = '';

    if($level_01 == 'news') {
        if (empty($level_03) || strpos($level_03, 'index.htm')) {
            $content_type = 'news-index';
        } else {
            $content_type = 'news';
        }
    }

    return $content_type;
}

/*
|-------------------------------------------------------------------------------
| 9) Убираем инструкции по форматированию под формами
|-------------------------------------------------------------------------------
|
| TODO: проверить: может, надо перенести в Garland, здесь оставить
| закомментированной, чтобы не потерять
|
*/
function v3_filter_tips_more_info() {
    return '';
}

function v3_filter_tips() {
    return '';
}

/*
|-------------------------------------------------------------------------------
| 10) Регионы
|-------------------------------------------------------------------------------
|
| TODO: удалить в 7-й версии
|
*/
function v3_regions() {
    return array('sidebar_right' => t('right sidebar'), 'content' => t('content'), 'footer' => t('footer'), 'teasers_news' => t('news teasers in footer'), 'teasers_blog' => t('blog teasers in footer'), 'teasers_blog_billboard' => t('blog teasers in billboard'), 'teasers_blog_community' => t('blog teasers on index community page'), 'teasers_news_overview' => t('news teasers on company overview page'), 'frontpage_content' => t('frontpage content'), 'similar' => t('related links'), 'blog_roll_vip' => t('blog roll vip'), 'blog_roll' => t('blog roll'));
}

/*
|-------------------------------------------------------------------------------
| 11) Добавление и удаление переменных: подбор шаблонов по пути и регион similar
|-------------------------------------------------------------------------------
|
| http://drupal.org/node/201587
|
| TODO: удалить в 7-й версии
|
| @param $hook — название функции «ядра», которая дополняется/изменяется
| @param $vars - массив переменных, которые передаются в шаблоны
|
*/
function _phptemplate_variables($hook, $vars) {
    $vars = array();
    if ($hook == 'page') {

        /**
        * Add page template suggestions based on the aliased path.
        * For instance, if the current page has an alias of about/history/early,
        * we'll have templates of:
        * page-about-history-early.tpl.php
        * page-about-history.tpl.php
        * page-about.tpl.php
        * Whichever is found first is the one that will be used.
        */
        if (module_exists('path')) {
            $alias = drupal_get_path_alias($_GET['q']);
            if ($alias != $_GET['q']) {
                $suggestions = array();
                $template_filename = 'page';
                foreach (explode('/', $alias) as $path_part) {
                    $template_filename = $template_filename . '-' . $path_part;
                    $suggestions[] = $template_filename;
                }
            }
            $vars['template_files'] = $suggestions;
        }
    }

    // Привязываем тему админки к страницам добавления и редактирования материалов
    if ((arg(0) == 'node' && arg(1) == 'add') ||  (arg(0) == 'node' && arg(2) == 'edit') ||  arg(0) == 'user') {
        $vars['template_file'] = 'page-admin';
    }

    // Добавляем регион (similar) для шаблона node, его надо также создать в функции theme_name_regions (в данном случае - v3_regions)
    if ($hook == 'node' && !$vars['teaser']) {
        foreach (array('similar') as $region) {
            $vars[$region] = theme('blocks', $region);
        }
    }

    return $vars;
}

/**
* D6-D7
*
* function v3_preprocess_page(&$vars, $hook) {
*    if (arg(0) == 'blog') {
*        $vars['node_list'] = '';
*    }
*
*    return $vars;
*}
*/

/*
|-------------------------------------------------------------------------------
| В предыдущей версии остались функции:
|-------------------------------------------------------------------------------
|
| - разметки формы комментариев comment_form
| - форматирования отдельного элемента формы
| - удаления вложенного div-а в форме
|
*/
