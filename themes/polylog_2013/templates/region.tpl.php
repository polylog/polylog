<?php
/*

  ПЕРЕМЕННЫЕ
- $content — содержание региона, как правило — блоки




   НЕ ИСПОЛЬЗУЮ
- $classes: String of classes that can be used to style contextually through
  Классы определяются в массиве $classes_array в функции template_preprocess_block() в modules/block/block.module
  Значения, которые D по умолчанию передает в шаблоны
  - region — тип шаблона, например, theming hook.
  - region-[name] — имя региона, в котором нижние подчеркивания заменены дефисами (например, region-news-teasers)
    dashes. For example, the page_top region would have a region-page-top class.
- $region — имя региона, как оно записано в info
- $is_front — Проверка: первая страница или нет
- $logged_in — Проверка: авторизован ли пользователь или нет
- $is_admin — Проверка: является ли пользователь администратором сайта

  «РОДИТЕЛЬСКИЕ» ФУНКЦИИ (все собраны в includes/theme.inc)
  template_preprocess()
  template_preprocess_region()
  template_process()
*/
?>
<?php print $content; ?>