<?php

/* ПЕРЕОПРЕДЕЛЯЕМ ИЛИ ДОБАВЛЯЕМ ПЕРЕМЕННЫЕ */
/* Maintenance.tpl.php */

function polylog_2013_preprocess_maintenance_page(&$vars) {
  // Переносим переменные из шаблона html
  polylog_2013_preprocess_html($vars);
}

/* html.tpl.php */
function polylog_2013_preprocess_html(&$vars) {
	$path = drupal_get_path_alias($_GET['q']);
	$aliases = explode('/', $path);
	
	foreach($aliases as $alias) {
		$vars['classes_array'][] = drupal_clean_css_identifier($alias);
	} 
}

function polylog_2013_process_html(&$vars) {
}


/* page.tpl.php */
function polylog_2013_preprocess_page(&$vars) {
  // «Шапка»
  $site_fields = array();
  if (!empty($vars['site_name'])) {
    $site_fields[] = $vars['site_name'];
  }
  if (!empty($vars['site_slogan'])) {
    $site_fields[] = $vars['site_slogan'];
  }
  $vars['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  $vars['site_html'] = implode(' ', $site_fields);

  // Set a variable for the site name title and logo alt attributes text.
  $slogan_text = $vars['site_slogan'];
  $site_name_text = $vars['site_name'];
  $vars['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;
}

/**
 * Override or insert variables into the node template.
 */
function polylog_2013_preprocess_node(&$vars) {
  $vars['submitted'] = $vars['date'] . ' — ' . $vars['name'];
}

/**
 * Override or insert variables into the comment template.
 */
function polylog_2013_preprocess_comment(&$vars) {
  $vars['submitted'] = $vars['created'] . ' — ' . $vars['author'];
}

/**
 * Override or insert variables into the block template.
 */
function polylog_2013_preprocess_block(&$vars) {
  $vars['title_attributes_array']['class'][] = 'title';
  $vars['classes_array'][] = 'clearfix';
}

/**
 * Override or insert variables into the page template.
 */
function polylog_2013_process_page(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}

/**
 * Override or insert variables into the region template.
 */
function polylog_2013_preprocess_region(&$vars) {
  if ($vars['region'] == 'header') {
    $vars['classes_array'][] = 'clearfix';
  }
}
