<?php

/*
|--------------------------------------------------------------------------
| Formatted with phpformatter.com
|--------------------------------------------------------------------------
|
| K&R style (One true brace style) is selected
|
*/

/*
|--------------------------------------------------------------------------
| 1-бис) Простая функция добавления классов тегу <body>
|--------------------------------------------------------------------------
*/
function polylog_preprocess_html(&$vars) {
    $path    = drupal_get_path_alias($_GET['q']);
    $aliases = explode('/', $path);
    
    foreach ($aliases as $alias) {
        $vars['classes_array'][] = drupal_clean_css_identifier($alias);
    }
}

/*
|--------------------------------------------------------------------------
| 1) Функция добавления классов тегу <body> в зависимости от текущего адреса
|--------------------------------------------------------------------------
|
| TODO — solve the problem with class, object and for…in
|
| class foo {
|     function do_foo() {
|         echo "Doing foo."; 
|     }
| }
|
| $bar = new foo;
| $bar->do_foo();
|
*/
function polylog_body_classes() {
    /*
	|
	| Делим путь от корневого каталога: заменяем в URL-ах с параметрами знак '?' на '/',
	| затем выбрасываем первый слэш и папку /ru/, остальные части записываем в четыре переменных
	|
	*/
    $path = str_replace('?', '/', $_SERVER['REQUEST_URI']);
    list(, , $path_section, $path_subsection1, $path_subsection2, $path_page) = explode('/', $path);
    
    /*
	|
    | Определяем, какому типу может принадлежать набор полученных переменных и метим их:
    | страницы раздела - 1i и 1
    | страницы подраздела 1-го уровня - 2i и 2
    | страницы подраздела 2-го уровня - 3i и 3
	|
    */
    // $path_section=pr-help $path_subsection1=btl.htm $path_subsection2=empty 1
    if (empty($path_subsection1) || strpos($path_subsection1, '.htm')) {
        $page = empty($path_subsection1) || strpos($path_subsection1, 'ndex.htm') ? '1i' : '1';
        if ($page == '1') {
            $path_page = $path_subsection1;
        }
    } elseif (empty($path_subsection2) || strpos($path_subsection2, '.htm')) {
        $page = empty($path_subsection2) || strpos($path_subsection2, 'ndex.htm') ? '2i' : '2';
    } else {
        $page = empty($path_page) || strpos($path_page, 'ndex.htm') ? '3i' : '3';
    }
    
    /*
	|
    | Чистим переменные от seo-слов.
    | TODO: проконсультироваться, как использовать массив для исходных строк.
    | $path_parts = array($path_section, $path_subsection1, $path_page);
    | $path_parts = str_replace($seo, '', $path_parts);
    | не получается - видимо, как-то связано с использованием массива переменных
	|
    */
    $seo              = array(
        'btl-pr',
        'pr-btl',
        'btl',
        'marketing-communications',
        'corporate',
        'government-relations',
        'campaigns',
        'planning',
        'relations',
        '-pr'
    );
    $path_section     = str_replace($seo, '', $path_section);
    $path_subsection1 = str_replace($seo, '', $path_subsection1);
    $path_page        = str_replace($seo, '', $path_page);
    
    // Проверяем, заменяем, чистим значение $path_section
    switch ($path_section) {
        case '--firm':
            $path_section = 'company';
            break;
        case '-':
            $path_section = 'services';
            break;
        case 'reply': //stay
            $path_section = 'blog';
            break;
        case 'case-studies': //new
            $path_section = 'case_studies';
            break;
        case 'pr-blog': //new
            $path_section = 'blog';
            break;
        case 'pr-help': //new
            $path_section = 'help';
            break;
        case 'pr-tutorials': //new
            $path_section = 'tutorials';
            break;
    }
    $path_section = trim($path_section, '-');
    
    
    // Проверяем, заменяем, чистим значение $path_subsection1
    switch ($path_subsection1) {
        case 'company-magazines-brochures-newsletters':
            $path_subsection1 = 'company_media';
            break;
        case '-case-studies':
            $path_subsection1 = 'case_studies';
            break;
    }
    $path_subsection1 = trim($path_subsection1, '-');
    
    // Страницы новостей. Обрезаем значение года — $path_subsection2 и $path_subsection1 
    $path_subsection2 = substr($path_subsection2, 2);
    if ($path_section == 'news') { //New
        $path_subsection1 = substr($path_subsection1, 2);
    }
    
    // Проверяем, заменяем, чистим значение $path_page
    $path_page = str_replace('.htm', '', $path_page);
    switch ($path_page) {
        case 'list':
            $path_page = 'clients_list';
            break;
        case 'integrated--':
            $path_page = 'integrated_services';
            break;
        case '-event-':
            $path_page = 'events';
            break;
        case 'government-authority-consulting':
            $path_page = 'strategies';
            break;
        case 'event-management':
            $path_page = 'events';
            break;
    }
    $path_page = trim($path_page, '-');
    
    // Возвращаем значения
    switch ($page) {
        case '1i':
            if ($path_section == 'case_studies') {
                return " class=\"clients\" id=\"$path_section\""; //New
            } else {
                return " class=\"$path_section\" id=\"$path_section\""; //Stay
            }
            break;
        case '1':
            if ($path_section == 'blog' || $path_section == 'help') {
                return " class=\"$path_section\""; //New
            } else {
                return " class=\"$path_section\" id=\"$path_page\"";
            }
            break;
        case '2i':
            // $path_section=news $path_subsection1=2004 $path_subsection2=empty 2i
            if ($path_subsection1 == 'blog' || $path_subsection1 == 'news' || $path_subsection1 == 'press') {
                return " class=\"$path_subsection1\" id=\"$path_subsection1\"";
            } elseif ($path_section == 'blog') {
                return " class=\"$path_section\"";
            } elseif ($path_section == 'news') {
                return " class=\"$path_section arj_$path_subsection1\" id=\"{$path_section}_$path_subsection1\""; //New
            } else {
                return " class=\"$path_section\" id=\"$path_subsection1\"";
            }
            break;
        case '2':
            if ($path_section == 'news') {
                return " class=\"$path_section arj_$path_subsection1\""; //New
            } else {
                return " class=\"$path_subsection1\"";
            }
            break;
        case '3i':
            if ($path_subsection1 == 'blog') {
                return " class=\"$path_subsection1\"";
            } else {
                return " class=\"$path_subsection1 arj_$path_subsection2\" id=\"{$path_subsection1}_$path_subsection2\"";
            }
            break;
        case '3':
            if ($path_subsection1 == 'blog') {
                return " class=\"$path_subsection1\"";
            } else {
                return " class=\"$path_subsection1 arj_$path_subsection2\"";
            }
            break;
    }
}

/*
|--------------------------------------------------------------------------
| 2) Удаляем из title bbcode: em, strong, span, b, small —
| print polylog_strip($head_title)
|--------------------------------------------------------------------------
|
| Для того, что bbcode не выводился в RSS-лентах, ханкуть ядро:
| В файле includes/common.inc найти функцию format_rss_item и перед первым $output-ом
| добавить $title = polylog_strip($title);
|
*/
function polylog_strip($text) {
    $bbcode = array(
        "[strong]",
        "[/strong]",
        "[em]",
        "[/em]",
        "[span]",
        "[/span]",
        "[b]",
        "[/b]",
        "[small]",
        "[/small]"
    );
    return str_replace($bbcode, '', $text);
}

/*
|--------------------------------------------------------------------------
| 3) Переводим bbcode в основном заголовке в html - print polylog_bb2html($title)
|--------------------------------------------------------------------------
*/
function polylog_bb2html($text) {
    $bbcode   = array(
        "[strong]",
        "[/strong]",
        "[em]",
        "[/em]",
        "[span]",
        "[/span]",
        "[b]",
        "[/b]",
        "[small]",
        "[/small]"
    );
    $htmlcode = array(
        "<strong>",
        "</strong>",
        "<em>",
        "</em>",
        "<span>",
        "</span>",
        "<b>",
        "</b>",
        "<small>",
        "</small>"
    );
    return str_replace($bbcode, $htmlcode, $text);
}

/*
|--------------------------------------------------------------------------
| 4) Переписываем theme_item_list
|--------------------------------------------------------------------------
|
| TODO: Moжет, убрать класс item_list.
| И проверить, нужна ли функция в принципе — убрать и посмотреть на разметку
| генерируемых списков
|
*/
function polylog_item_list($items = array(), $title = NULL, $type = 'ul', $attributes = NULL) {
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
|--------------------------------------------------------------------------
| 4-бис) Переписываем html списков, создаваемый модулем Views -
| оригинальная функция находится в views.module
|--------------------------------------------------------------------------
|
| TODO: проверить, нужна ли функция — убрать и посмотреть на разметку
| генерируемых списков
|
*/
function polylog_views_view($view, $type, $nodes, $level = NULL, $args = NULL) {
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
function polylog_views_view_list($view, $nodes, $type) {
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
        $items[] = _polylog_callback('views-news-teasers', $vars);
    }
    if ($items) {
        return theme('item_list', $items);
    }
}

/*
|--------------------------------------------------------------------------
| 5) Пэйджер
|--------------------------------------------------------------------------
*/
function polylog_pager($tags = array(), $limit = 10, $element = 0, $parameters = array()) {
    global $pager_total;
    $output = '';
    
    if ($pager_total[$element] > 1) {
        $output .= '<div class="pager cfx"><span class="caption">' . t('Pages') . ':</span>';
        $output .= theme('pager_previous', ($tags[1] ? $tags[1] : t('‹ previous')), $limit, $element, 1, $parameters);
        $output .= theme('pager_list', $limit, $element, ($tags[2] ? $tags[2] : 9), '', $parameters);
        $output .= theme('pager_next', ($tags[3] ? $tags[3] : t('next ›')), $limit, $element, 1, $parameters);
        $output .= '</div>';
        
        return $output;
    }
}

/*
|--------------------------------------------------------------------------
| 6) Короткие ссылки — TinyURL
|--------------------------------------------------------------------------
*/
function polylog_get_tinyurl($url) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=" . $url);
    return $tinyurl;
}

/*
|--------------------------------------------------------------------------
| 7) Переписываем формат вывода массива $links в заметке блога
|--------------------------------------------------------------------------
|
| TODO: переписать — выводить из массива не все ссылки,
| убрать все классы с LI, рефакторинг
|
*/
function polylog_links($links, $attributes = array('class' => 'links')) {
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
|--------------------------------------------------------------------------
| 8) Редирект на статичную страницу maintenance
|--------------------------------------------------------------------------
|
| TODO: проверить, нужна ли функция — убрать и посмотреть
| на сайт переведенный в режим профилактики
|
*/
function polylog_maintenance_page($content, $messages = TRUE, $partial = FALSE) {
    drupal_goto('/maintenance.htm');
}


/*
|--------------------------------------------------------------------------
| В предыдущей версии остались функции:
|--------------------------------------------------------------------------
|
| - «различных задач»
| - разметки формы комментариев comment_form
| - форматирования отдельного элемента формы
| - удаления вложенного div-а в форме
|
*/

/*
|--------------------------------------------------------------------------
| Override or insert variables
| I don't use this functions yet since practicing pure HTML.
| But maybe someday they prove useful
|--------------------------------------------------------------------------
|
| // maintenance.tpl.php — Useful. Get the variables from other template
| function polylog_preprocess_maintenance_page(&$vars) {
|	polylog_preprocess_html($vars);
| }
|
|--------------------------------------------------------------------------
| // page.tpl.php - Hook into color.module; разметка «шапки», слоган сайта
| function polylog_process_page(&$vars) {
| 	if (module_exists('color')) {
| 		_color_page_alter($vars);
| 	}
| }
|
| function polylog_preprocess_page(&$vars) {
| 	$site_fields = array();
| 	if (!empty($vars['site_name'])) {
| 		$site_fields[] = $vars['site_name'];
| 	}
| 	if (!empty($vars['site_slogan'])) {
| 		$site_fields[] = $vars['site_slogan'];
| 	}
| 	
| 	$vars['site_title'] = implode(' ', $site_fields);
| 	if (!empty($site_fields)) {
| 		$site_fields[0] = '<span>' . $site_fields[0] . '</span>';
| 	}
|	
| 	$vars['site_html'] = implode(' ', $site_fields);
| 	
| 	$slogan_text = $vars['site_slogan'];
| 	$site_name_text = $vars['site_name'];
| 	$vars['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;
| }
|
|--------------------------------------------------------------------------
| // node.tpl.php
| function polylog_preprocess_node(&$vars) {
|	$vars['submitted'] = $vars['date'] . ' — ' . $vars['name'];
| }
|
|--------------------------------------------------------------------------
| // region.tpl.php
| function polylog_preprocess_region(&$vars) {
| 	if ($vars['region'] == 'header') {
| 		$vars['classes_array'][] = 'cfx';
| 	}
| }
|
|--------------------------------------------------------------------------
| // comment.tpl.php
| function polylog_preprocess_comment(&$vars) {
| 	$vars['submitted'] = $vars['created'] . ' — ' . $vars['author'];
| }
|
|--------------------------------------------------------------------------
| // block.tpl.php
| function polylog_preprocess_block(&$vars) {
| 	$vars['title_attributes_array']['class'][] = 'title';
| 	$vars['classes_array'][] = 'cfx';
| }
|
*/

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('zen_rebuild_registry') && !defined('MAINTENANCE_MODE')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}


/**
 * Implements HOOK_theme().
 */
function zen_theme(&$existing, $type, $theme, $path) {
  include_once './' . drupal_get_path('theme', 'zen') . '/zen-internals/template.theme-registry.inc';
  return _zen_theme($existing, $type, $theme, $path);
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $variables
 *   - title: An optional string to be used as a navigational heading to give
 *     context for breadcrumb links to screen-reader users.
 *   - title_attributes_array: Array of HTML attributes for the title. It is
 *     flattened into a string within the theme function.
 *   - breadcrumb: An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function zen_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('zen_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('zen_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $breadcrumb[] = check_plain($item['title']);
        }
        else {
          $breadcrumb[] = drupal_get_title();
        }
      }
      elseif (theme_get_setting('zen_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users.
      if (empty($variables['title'])) {
        $variables['title'] = t('You are here');
      }
      // Unless overridden by a preprocess function, make the heading invisible.
      if (!isset($variables['title_attributes_array']['class'])) {
        $variables['title_attributes_array']['class'][] = 'element-invisible';
      }

      // Build the breadcrumb trail.
      $output = '<nav class="breadcrumb" role="navigation">';
      $output .= '<h2' . drupal_attributes($variables['title_attributes_array']) . '>' . $variables['title'] . '</h2>';
      $output .= '<ol><li>' . implode($breadcrumb_separator . '</li><li>', $breadcrumb) . $trailing_separator . '</li></ol>';
      $output .= '</nav>';
    }
  }

  return $output;
}

/**
 * Override or insert variables into the html template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered. This is usually "html", but can
 *   also be "maintenance_page" since zen_preprocess_maintenance_page() calls
 *   this function to have consistent variables.
 */
function zen_preprocess_html(&$variables, $hook) {
  // Add variables and paths needed for HTML5 and responsive support.
  $variables['base_path'] = base_path();
  $variables['path_to_zen'] = drupal_get_path('theme', 'zen');
  $html5_respond_meta = theme_get_setting('zen_html5_respond_meta');
  $variables['add_respond_js']          = in_array('respond', $html5_respond_meta);
  $variables['add_html5_shim']          = in_array('html5', $html5_respond_meta);
  $variables['default_mobile_metatags'] = in_array('meta', $html5_respond_meta);

  // If the user is silly and enables Zen as the theme, add some styles.
  if ($GLOBALS['theme'] == 'zen') {
    include_once './' . $variables['path_to_zen'] . '/zen-internals/template.zen.inc';
    _zen_preprocess_html($variables, $hook);
  }

  // Attributes for html element.
  $variables['html_attributes_array'] = array(
    'lang' => $variables['language']->language,
    'dir' => $variables['language']->dir,
  );

  // Send X-UA-Compatible HTTP header to force IE to use the most recent
  // rendering engine or use Chrome's frame rendering engine if available.
  // This also prevents the IE compatibility mode button to appear when using
  // conditional classes on the html tag.
  if (is_null(drupal_get_http_header('X-UA-Compatible'))) {
    drupal_add_http_header('X-UA-Compatible', 'IE=edge,chrome=1');
  }

  $variables['skip_link_anchor'] = theme_get_setting('zen_skip_link_anchor');
  $variables['skip_link_text'] = theme_get_setting('zen_skip_link_text');

  // Return early, so the maintenance page does not call any of the code below.
  if ($hook != 'html') {
    return;
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$variables['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section, ) = explode('/', $path, 2);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node' && isset($arg[1])) {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $variables['classes_array'][] = drupal_html_class('section-' . $section);
  }
  if (theme_get_setting('zen_wireframes')) {
    $variables['classes_array'][] = 'with-wireframes'; // Optionally add the wireframes style.
  }
  // Store the menu item since it has some useful information.
  $variables['menu_item'] = menu_get_item();
  if ($variables['menu_item']) {
    switch ($variables['menu_item']['page_callback']) {
      case 'views_page':
        // Is this a Views page?
        $variables['classes_array'][] = 'page-views';
        break;
      case 'page_manager_page_execute':
      case 'page_manager_node_view':
      case 'page_manager_contact_site':
        // Is this a Panels page?
        $variables['classes_array'][] = 'page-panels';
        break;
    }
  }
}

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function zen_process_html(&$variables, $hook) {
  // Flatten out html_attributes.
  $variables['html_attributes'] = drupal_attributes($variables['html_attributes_array']);
}

/**
 * Override or insert variables in the html_tag theme function.
 */
function zen_process_html_tag(&$variables) {
  $tag = &$variables['element'];

  if ($tag['#tag'] == 'style' || $tag['#tag'] == 'script') {
    // Remove redundant type attribute and CDATA comments.
    unset($tag['#attributes']['type'], $tag['#value_prefix'], $tag['#value_suffix']);

    // Remove media="all" but leave others unaffected.
    if (isset($tag['#attributes']['media']) && $tag['#attributes']['media'] === 'all') {
      unset($tag['#attributes']['media']);
    }
  }
}

/**
 * Implement hook_html_head_alter().
 */
function zen_html_head_alter(&$head) {
  // Simplify the meta tag for character encoding.
  if (isset($head['system_meta_content_type']['#attributes']['content'])) {
    $head['system_meta_content_type']['#attributes'] = array('charset' => str_replace('text/html; charset=', '', $head['system_meta_content_type']['#attributes']['content']));
  }
}

/**
 * Override or insert variables into the page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function zen_preprocess_page(&$variables, $hook) {
  // Find the title of the menu used by the secondary links.
  $secondary_links = variable_get('menu_secondary_links_source', 'user-menu');
  if ($secondary_links) {
    $menus = function_exists('menu_get_menus') ? menu_get_menus() : menu_list_system_menus();
    $variables['secondary_menu_heading'] = $menus[$secondary_links];
  }
  else {
    $variables['secondary_menu_heading'] = '';
  }
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function zen_preprocess_maintenance_page(&$variables, $hook) {
  zen_preprocess_html($variables, $hook);
  // There's nothing maintenance-related in zen_preprocess_page(). Yet.
  //zen_preprocess_page($variables, $hook);
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function zen_process_maintenance_page(&$variables, $hook) {
  zen_process_html($variables, $hook);
  // Ensure default regions get a variable. Theme authors often forget to remove
  // a deleted region's variable in maintenance-page.tpl.
  foreach (array('header', 'navigation', 'highlighted', 'help', 'content', 'sidebar_first', 'sidebar_second', 'footer', 'bottom') as $region) {
    if (!isset($variables[$region])) {
      $variables[$region] = '';
    }
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function zen_preprocess_node(&$variables, $hook) {
  // Add $unpublished variable.
  $variables['unpublished'] = (!$variables['status']) ? TRUE : FALSE;

  // Add pubdate to submitted variable.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['node']->created, 'custom', 'c') . '">' . $variables['date'] . '</time>';
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['pubdate']));
  }

  // Add a class for the view mode.
  if (!$variables['teaser']) {
    $variables['classes_array'][] = 'view-mode-' . $variables['view_mode'];
  }

  // Add a class to show node is authored by current user.
  if ($variables['uid'] && $variables['uid'] == $GLOBALS['user']->uid) {
    $variables['classes_array'][] = 'node-by-viewer';
  }

  $variables['title_attributes_array']['class'][] = 'node-title';
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function zen_preprocess_comment(&$variables, $hook) {
  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $variables['node']->type, 1) == 0) {
    $variables['title'] = '';
  }

  // Add pubdate to submitted variable.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['comment']->created, 'custom', 'c') . '">' . $variables['created'] . '</time>';
  $variables['submitted'] = t('!username replied on !datetime', array('!username' => $variables['author'], '!datetime' => $variables['pubdate']));

  // Zebra striping.
  if ($variables['id'] == 1) {
    $variables['classes_array'][] = 'first';
  }
  if ($variables['id'] == $variables['node']->comment_count) {
    $variables['classes_array'][] = 'last';
  }
  $variables['classes_array'][] = $variables['zebra'];

  $variables['title_attributes_array']['class'][] = 'comment-title';
}

/**
 * Preprocess variables for region.tpl.php
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function zen_preprocess_region(&$variables, $hook) {
  // Sidebar regions get some extra classes and a common template suggestion.
  if (strpos($variables['region'], 'sidebar_') === 0) {
    $variables['classes_array'][] = 'column';
    $variables['classes_array'][] = 'sidebar';
    // Allow a region-specific template to override Zen's region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__sidebar');
  }
  // Use a template with no wrapper for the content region.
  elseif ($variables['region'] == 'content') {
    // Allow a region-specific template to override Zen's region--no-wrapper.
    array_unshift($variables['theme_hook_suggestions'], 'region__no_wrapper');
  }
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function zen_preprocess_block(&$variables, $hook) {
  // Use a template with no wrapper for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__no_wrapper';
  }

  // Classes describing the position of the block within the region.
  if ($variables['block_id'] == 1) {
    $variables['classes_array'][] = 'first';
  }
  // The last_in_region property is set in zen_page_alter().
  if (isset($variables['block']->last_in_region)) {
    $variables['classes_array'][] = 'last';
  }
  $variables['classes_array'][] = $variables['block_zebra'];

  $variables['title_attributes_array']['class'][] = 'block-title';

  // Add Aria Roles via attributes.
  switch ($variables['block']->module) {
    case 'system':
      switch ($variables['block']->delta) {
        case 'main':
          // Note: the "main" role goes in the page.tpl, not here.
          break;
        case 'help':
        case 'powered-by':
          $variables['attributes_array']['role'] = 'complementary';
          break;
        default:
          // Any other "system" block is a menu block.
          $variables['attributes_array']['role'] = 'navigation';
          break;
      }
      break;
    case 'menu':
    case 'menu_block':
    case 'blog':
    case 'book':
    case 'comment':
    case 'forum':
    case 'shortcut':
    case 'statistics':
      $variables['attributes_array']['role'] = 'navigation';
      break;
    case 'search':
      $variables['attributes_array']['role'] = 'search';
      break;
    case 'help':
    case 'aggregator':
    case 'locale':
    case 'poll':
    case 'profile':
      $variables['attributes_array']['role'] = 'complementary';
      break;
    case 'node':
      switch ($variables['block']->delta) {
        case 'syndicate':
          $variables['attributes_array']['role'] = 'complementary';
          break;
        case 'recent':
          $variables['attributes_array']['role'] = 'navigation';
          break;
      }
      break;
    case 'user':
      switch ($variables['block']->delta) {
        case 'login':
          $variables['attributes_array']['role'] = 'form';
          break;
        case 'new':
        case 'online':
          $variables['attributes_array']['role'] = 'complementary';
          break;
      }
      break;
  }
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function zen_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Implements hook_page_alter().
 *
 * Look for the last block in the region. This is impossible to determine from
 * within a preprocess_block function.
 *
 * @param $page
 *   Nested array of renderable elements that make up the page.
 */
function zen_page_alter(&$page) {
  // Look in each visible region for blocks.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_VISIBLE) as $region => $name) {
    if (!empty($page[$region])) {
      // Find the last block in the region.
      $blocks = array_reverse(element_children($page[$region]));
      while ($blocks && !isset($page[$region][$blocks[0]]['#block'])) {
        array_shift($blocks);
      }
      if ($blocks) {
        $page[$region][$blocks[0]]['#block']->last_in_region = TRUE;
      }
    }
  }
}

/**
 * Implements hook_form_BASE_FORM_ID_alter().
 *
 * Prevent user-facing field styling from screwing up node edit forms by
 * renaming the classes on the node edit form's field wrappers.
 */
function zen_form_node_form_alter(&$form, &$form_state, $form_id) {
  // Remove if #1245218 is backported to D7 core.
  foreach (array_keys($form) as $item) {
    if (strpos($item, 'field_') === 0) {
      if (!empty($form[$item]['#attributes']['class'])) {
        foreach ($form[$item]['#attributes']['class'] as &$class) {
          if (strpos($class, 'field-type-') === 0 || strpos($class, 'field-name-') === 0) {
            // Make the class different from that used in theme_field().
            $class = 'form-' . $class;
          }
        }
      }
    }
  }
}
