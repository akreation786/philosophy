<?php

require_once get_theme_file_path("/inc/tgm.php");
require_once get_theme_file_path("/inc/attachments.php");
require_once get_theme_file_path("/widgets/social-icons-widget.php");

if (!isset($content_width)) {
 $content_width = 960;
}

// Script and style file caching problem sovle

if (site_url() == "http://lwhhalpha.com/wp") {
 define("VERSION", time());
} else {
 define("VERSION", wp_get_theme()->get("VERSION"));
}

function philosophy_setup_theme() {
 load_theme_textdomain("philosophy");
 add_theme_support("post-thumbnail");
 add_theme_support("custom-logo");
 add_theme_support("title-tag");
 add_theme_support( "automatic-feed-links" );
 add_theme_support("html5", array("search-form", "comment-list"));
 add_theme_support("post-formats", array("image", "video", "gallery", "audio", "link", "quote"));
 add_theme_support("/assets/css/editor-style.css");

 register_nav_menu("topmenu", __("Top Menu", "philosophy"));
 register_nav_menus(array(
  'footer-left'   => __("Footer Left Menu", "Philosophy"),
  'footer-middle' => __("Footer Middle Menu", "Philosophy"),
  'footer-right'  => __("Footer Right Menu", "Philosophy"),
 ));

 add_image_size("philosophy-home-square", 400, 400, true);
}
add_action("after_setup_theme", "philosophy_setup_theme");

function philosophy_assets() {
 wp_enqueue_style("fontAwesome-css", get_theme_file_uri("/assets/css/font-awesome/css/font-awesome.min.css"), null, "1.0");
 wp_enqueue_style("font-css", get_theme_file_uri("/assets/css/fonts.css"), null, "1.0");
 wp_enqueue_style("base-css", get_theme_file_uri("/assets/css/base.css"), null, "1.0");
 wp_enqueue_style("vandor-css", get_theme_file_uri("/assets/css/vendor.css"), null, "1.0");
 wp_enqueue_style("main-css", get_theme_file_uri("/assets/css/main.css"), null, "1.0");
 wp_enqueue_style("philosophy-css", get_stylesheet_uri(), null, VERSION);

 wp_enqueue_script("modernize-js", get_theme_file_uri("/assets/js/modernizr.js"), null, "1.0");
 wp_enqueue_script("pace-js", get_theme_file_uri("/assets/js/pace.min.js"), null, "1.0");
 wp_enqueue_script("plugin-js", get_theme_file_uri("/assets/js/plugins.js"), array("jquery"), "1.0", true);
 if (is_singular()) {
  wp_enqueue_script("comment-reply");
 }
 wp_enqueue_script("main-js", get_theme_file_uri("/assets/js/main.js"), array("jquery"), VERSION, true);
}
add_action("wp_enqueue_scripts", "philosophy_assets");

function philosophy_pagination() {
 global $wp_query;
 $links = paginate_links(array(
  'current'  => max(1, get_query_var('paged')),
  'total'    => $wp_query->max_num_pages,
  'type'     => 'list',
  'mid_size' => 3,
 ));

 $links = str_replace('page-numbers', 'pgn__num', $links);
 $links = str_replace("<ul class='pgn__num'>", "<ul>", $links);
 $links = str_replace("next pgn__num", "pgn__next", $links);
 $links = str_replace("prev pgn__num", "pgn__prev", $links);

 echo wp_kses_post($links);
}

add_action("tern_description", "wpautop");

function philosophy_widgets() {
 register_sidebar(array(
  'name'          => __('About Us page', 'philosophy'),
  'id'            => 'about-us',
  'description'   => __('Widgets in this area will be shown on about us pages.', 'philosophy'),
  'before_widget' => '<div id="%1$s" class="col-block %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="quarter-top-margin">',
  'after_title'   => '</h3>',
 ));

 register_sidebar(array(
  'name'          => __('Contact page Maps Section', 'philosophy'),
  'id'            => 'contact-maps',
  'description'   => __('Widgets in this area will be shown contact pages maps.', 'philosophy'),
  'before_widget' => '<div id="%1$s" class="%2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '',
  'after_title'   => '',
 ));

 register_sidebar(array(
  'name'          => __('Contact page info', 'philosophy'),
  'id'            => 'contact-info',
  'description'   => __('Widgets in this area will be shown on contact pages info.', 'philosophy'),
  'before_widget' => '<div id="%1$s" class="col-block %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="quarter-top-margin">',
  'after_title'   => '</h3>',
 ));

 register_sidebar(array(
  'name'          => __('Before Footer Section', 'philosophy'),
  'id'            => 'before-footer-right',
  'description'   => __('Before footer section, Right side.', 'philosophy'),
  'before_widget' => '<div id="%1$s" class="%2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3>',
  'after_title'   => '</h3>',
 ));

 register_sidebar(array(
  'name'          => __('Header Section', 'philosophy'),
  'id'            => 'header-section',
  'description'   => __('Widgets in this area will be shown on Header section.', 'philosophy'),
  'before_widget' => '<div id="%1$s" class="%2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3>',
  'after_title'   => '</h3>',
 ));

}
add_action("widgets_init", "philosophy_widgets");

function philosophy_search_form() {
 $homedir      = home_url("/");
 $label        = __("Search for:", "philosophy");
 $button_label = __("Search", "philosophy");

 $newForm = <<<FORM
     <form role="search" method="get" class="header__search-form" action="{$homedir}">
     <label>
         <span class="hide-content">{$label}</span>
         <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="{$label}" autocomplete="off">
     </label>
     <input type="submit" class="search-submit" value="{$button_label}">
 </form>

FORM;

 return $newForm;
}
add_filter("get_search_form", "philosophy_search_form");



function lwhh_social_icons_widget() {
    register_widget( 'LwhhSocialIcons_Widget' );
}

add_action( 'widgets_init', 'lwhh_social_icons_widget' );



?>