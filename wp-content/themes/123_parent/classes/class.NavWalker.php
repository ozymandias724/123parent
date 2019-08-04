<?php

/**
 * Create HTML list of pages.
 *
 * @since 1.0
 * @uses Walker_Page
 */
class Rational_Walker_Page extends Walker_Page
{
	/**
	 * @see Walker_Page::start_lvl()
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 * @param array $args
	 */
	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='sub-menu'>\n";
	}

	/**
	 * @see Walker_Page::start_el()
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0)
	{
		if ($depth) {
			$indent = str_repeat("\t", $depth);
		} else {
			$indent = '';
		}

		// Removed the page item and page id classes
		$css_class = array();

		if (isset($args['pages_with_children'][$page->ID])) {
			// simpler, parent class
			$css_class[] = 'parent';
		}

		// simpler, ancestor classes
		if (!empty($current_page)) {
			$_current_page = get_post($current_page);
			if ($_current_page && in_array($page->ID, $_current_page->ancestors)) {
				$css_class[] = 'active-ancestor';
			}
			if ($page->ID == $current_page) {
				$css_class[] = 'active';
			} elseif ($_current_page && $page->ID == $_current_page->post_parent) {
				$css_class[] = 'active-parent';
			}
		} elseif ($page->ID == get_option('page_for_posts')) {
			$css_class[] = 'active-parent';
		}

		/**
		 * Filter the list of CSS classes to include with each page item in the list.
		 *
		 * @since 1.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array   $css_class    An array of CSS classes to be applied
		 *                             to each list item.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page, used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */
		$css_classes = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

		if ('' === $page->post_title) {
			$page->post_title = sprintf(__('#%d (no title)'), $page->ID);
		}

		$args['link_before'] = empty($args['link_before']) ? '' : $args['link_before'];
		$args['link_after'] = empty($args['link_after']) ? '' : $args['link_after'];

		/** This filter is documented in wp-includes/post-template.php */
		// only add the class attribute if needed
		$output .= $indent . sprintf(
			'<li %s><a href="%s">%s%s%s</a>',
			!empty($css_classes) ? "class='{$css_classes}'" : '',
			get_permalink($page->ID),
			$args['link_before'],
			apply_filters('the_title', $page->post_title, $page->ID),
			$args['link_after']
		);

		if (!empty($args['show_date'])) {
			if ('modified' == $args['show_date']) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$date_format = empty($args['date_format']) ? '' : $args['date_format'];
			$output .= " " . mysql2date($date_format, $time);
		}
	}
} // Rational_Walker_Page

/**
 * Create HTML list of nav menu items.
 *
 * @since 1.0
 * @uses Walker_Nav_Menu
 */
class Rational_Walker_Nav_Menu extends Walker_Nav_Menu
{
	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 *
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Cleaner class array to replace default
		$new_classes = array();
		if (in_array('menu-item-has-children', $classes))
			$new_classes[] = 'parent';
		if (in_array('current-menu-item', $classes))
			$new_classes[] = 'active';
		if (in_array('current-menu-ancestor', $classes))
			$new_classes[] = 'active-ancestor';
		if (in_array('current-menu-parent', $classes))
			$new_classes[] = 'active-parent';
		$classes = $new_classes;

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 1.0
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		// removed the ID
		$output .= $indent . '<li' . $class_names . '>';

		$atts = array();
		$atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target)     ? $item->target     : '';
		$atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
		$atts['href']   = !empty($item->url)        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 1.0
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 1.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
} // Rational_Walker_Nav_Menu
?>