<?php

// LOAD Simply Read CORE (if you remove this, the theme will break)
require_once( 'library/simplyread.php' );

function simplyread_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'simplyread', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'simplyread_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'simplyread_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'simplyread_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'simplyread_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'simplyread_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'simplyread_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  simplyread_theme_support();
 

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'simplyread_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'simplyread_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'simplyread_excerpt_more' );

} /* end simplyread ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'simplyread_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
  $content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'simplyread-thumb-600', 600, 150, true );
add_image_size( 'simplyread-thumb-300', 300, 100, true );
add_image_size( 'simplyread-slider-image', 1280, 500, true );
add_image_size( 'simplyread-thumb-image-300by300', 300, 300, true );


add_filter( 'image_size_names_choose', 'simplyread_custom_image_sizes' );
function simplyread_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'simplyread-thumb-600' => '600px by 150px',
        'simplyread-thumb-300' => '300px by 100px',
        'simplyread-slider-image' => '1280px by 500px'
    ) );
}

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function simplyread_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Posts Sidebar', 'simplyread' ),
    'description' => __( 'The Posts sidebar.', 'simplyread' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'sidebar2',
    'name' => __( 'Page Sidebar', 'simplyread' ),
    'description' => __( 'The Page sidebar.', 'simplyread' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));


} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function simplyread_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'simplyread' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'simplyread' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'simplyread' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'simplyread' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!



/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function simplyread_fonts() {
  wp_register_style('simplyreadFonts', get_template_directory_uri() . '/fonts/raleway-font.css');
  wp_enqueue_style( 'simplyreadFonts');
}

add_action('wp_print_styles', 'simplyread_fonts');

/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
if ( ! function_exists( 'simplyread_theme_customizer' ) ) :
  function simplyread_theme_customizer( $wp_customize ) {
    
    $wp_customize->remove_section( 'title_tagline');
    $wp_customize->remove_section( 'static_front_page' );
  
  
    /* color scheme option */
    $wp_customize->add_setting( 'simplyread_color_settings', array (
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'simplyread_color_settings', array(
      'label'    => __( 'Theme Color Scheme', 'simplyread' ),
      'section'  => 'colors',
      'settings' => 'simplyread_color_settings',
    ) ) );

    
    /* logo option */
    $wp_customize->add_section( 'simplyread_logo_section' , array(
      'title'       => __( 'Site Logo', 'simplyread' ),
      'priority'    => 1,
      'description' => __( 'Upload a logo to replace the default site name in the header', 'simplyread' ),
    ) );
    
    $wp_customize->add_setting( 'simplyread_logo', array(
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'simplyread_logo', array(
      'label'    => __( 'Choose your logo (ideal width is 100-350px and ideal height is 35-40)', 'simplyread' ),
      'section'  => 'simplyread_logo_section',
      'settings' => 'simplyread_logo',
    ) ) );
  
    /* favicon option */
    $wp_customize->add_section( 'simplyread_favicon_section' , array(
      'title'       => __( 'Site favicon', 'simplyread' ),
      'priority'    => 2,
      'description' => __( 'Upload a favicon', 'simplyread' ),
    ) );
    
    $wp_customize->add_setting( 'simplyread_favicon', array(
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'simplyread_favicon', array(
      'label'    => __( 'Choose your favicon (ideal width and height is 16x16 or 32x32)', 'simplyread' ),
      'section'  => 'simplyread_favicon_section',
      'settings' => 'simplyread_favicon',
    ) ) );
    
    /* social media option */
    $wp_customize->add_section( 'simplyread_social_section' , array(
      'title'       => __( 'Social Media Icons', 'simplyread' ),
      'priority'    => 32,
      'description' => __( 'Optional media icons in the header', 'simplyread' ),
    ) );
    
    $wp_customize->add_setting( 'simplyread_facebook', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_facebook', array(
      'label'    => __( 'Enter your Facebook url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_facebook',
      'priority'    => 101,
    ) ) );
  
    $wp_customize->add_setting( 'simplyread_twitter', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_twitter', array(
      'label'    => __( 'Enter your Twitter url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_twitter',
      'priority'    => 102,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_google', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_google', array(
      'label'    => __( 'Enter your Google+ url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_google',
      'priority'    => 103,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_pinterest', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_pinterest', array(
      'label'    => __( 'Enter your Pinterest url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_pinterest',
      'priority'    => 104,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_linkedin', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_linkedin', array(
      'label'    => __( 'Enter your Linkedin url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_linkedin',
      'priority'    => 105,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_youtube', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_youtube', array(
      'label'    => __( 'Enter your Youtube url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_youtube',
      'priority'    => 106,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_tumblr', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_tumblr', array(
      'label'    => __( 'Enter your Tumblr url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_tumblr',
      'priority'    => 107,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_instagram', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_instagram', array(
      'label'    => __( 'Enter your Instagram url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_instagram',
      'priority'    => 108,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_flickr', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_flickr', array(
      'label'    => __( 'Enter your Flickr url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_flickr',
      'priority'    => 109,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_vimeo', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_vimeo', array(
      'label'    => __( 'Enter your Vimeo url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_vimeo',
      'priority'    => 110,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_yelp', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_yelp', array(
      'label'    => __( 'Enter your Yelp url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_yelp',
      'priority'    => 111,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_rss', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_rss', array(
      'label'    => __( 'Enter your RSS url', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_rss',
      'priority'    => 112,
    ) ) );
    
    $wp_customize->add_setting( 'simplyread_email', array (
      'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_email', array(
      'label'    => __( 'Enter your email address', 'simplyread' ),
      'section'  => 'simplyread_social_section',
      'settings' => 'simplyread_email',
      'priority'    => 113,
    ) ) );
    
    /* slider options */
    
    $wp_customize->add_section( 'simplyread_slider_section' , array(
      'title'       => __( 'Slider Options', 'simplyread' ),
      'priority'    => 33,
      'description' => __( 'Adjust the behavior of the image slider.', 'simplyread' ),
    ) );
    
    $wp_customize->add_setting( 'simplyread_slider_effect', array(
      'default' => 'scrollHorz',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control( 'effect_select_box', array(
      'settings' => 'simplyread_slider_effect',
      'label' => __( 'Select Effect:', 'simplyread' ),
      'section' => 'simplyread_slider_section',
      'type' => 'select',
      'choices' => array(
        'scrollHorz' => 'Horizontal (Default)',
        'scrollVert' => 'Vertical',
        'tileSlide' => 'Tile Slide',
        'tileBlind' => 'Blinds',
        'shuffle' => 'Shuffle',
      ),
    ));
    
    $wp_customize->add_setting( 'simplyread_slider_timeout', array (
      'sanitize_callback' => 'simplyread_sanitize_integer',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'simplyread_slider_timeout', array(
      'label'    => __( 'Autoplay Speed in Seconds', 'simplyread' ),
      'section'  => 'simplyread_slider_section',
      'settings' => 'simplyread_slider_timeout',
    ) ) );

     /* author bio in posts option */
    $wp_customize->add_section( 'simplyread_author_bio_section' , array(
      'title'       => __( 'Disable Author Bio', 'simplyread' ),
      'priority'    => 35,
      'description' => __( 'Option to disable the author bio in the posts.', 'simplyread' ),
    ) );
    
    $wp_customize->add_setting( 'simplyread_author_bio', array (
      'sanitize_callback' => 'simplyread_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control('author_bio', array(
      'settings' => 'simplyread_author_bio',
      'label' => __('Disable the Author Bio?', 'simplyread'),
      'section' => 'simplyread_author_bio_section',
      'type' => 'checkbox',
    ));
  
  }
endif;
add_action('customize_register', 'simplyread_theme_customizer');

/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'simplyread_sanitize_checkbox' ) ) :
  function simplyread_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
      return 1;
    } else {
      return '';
    }
  }
endif;


/**
 * Sanitize integer input
 */
if ( ! function_exists( 'simplyread_sanitize_integer' ) ) :
  function simplyread_sanitize_integer( $input ) {
    return absint($input);
  }
endif;
/**
* Apply Color Scheme
*/
if ( ! function_exists( 'simplyread_apply_color' ) ) :
  function simplyread_apply_color() {
    if ( get_theme_mod('simplyread_color_settings') ) {
  ?>
    <style>
       .divider-title span,body.home .pagination, body.blog .pagination{background:#<?php echo get_theme_mod( 'background_color' ); ?>;}
      .social-icons a,nav[role="navigation"] .nav li a,#logo a,footer.footer[role="contentinfo"] p,.blog-list .item h2,
      .divider-title span,.widget:first-child h4,.widgettitle,a, a:visited,.widget ul li,.article-header h1,h1,h2,h3,h4,h5,h6,a,
      a:hover,.social-icons a:hover,.pagination .current,body .pagination li a
       { 
        color: <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      .divider-title:before,.widget #wp-calendar thead
      {
        border-top:1px solid <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      .widgettitle,nav[role="navigation"] .nav li.current_page_item a{
        border-bottom: 2px solid <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      .entry-content blockquote{
        border-left: 1px solid <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      body .pagination li span{
        border:2px solid <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      .search-bar input.search-field[type="search"]:focus,nav[role="navigation"] .nav li ul li a{
        border:1px solid <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      button, body .comment-reply-link, .blue-btn, .comment-reply-link, #submit, html input[type="button"], input[type="reset"], input[type="submit"],.nav li ul.sub-menu, .nav li ul.children,
     nav[role="navigation"] .nav li ul li a:hover,nav[role="navigation"] .nav li ul li a:focus,nav[role="navigation"] .nav li ul li a,.entry-content th{
        background: <?php echo get_theme_mod('simplyread_color_settings'); ?>;
      }
      .blue-btn:hover, .comment-reply-link:hover, #submit:hover, .blue-btn:focus, .comment-reply-link:focus, #submit:focus {
       background-color: <?php echo get_theme_mod('simplyread_color_settings'); ?> }
      .blue-btn:active, .comment-reply-link:active, #submit:active {
       background-color: <?php echo get_theme_mod('simplyread_color_settings'); ?> }
      @media screen and (max-width: 1039px) {
        #main-navigation{
          background: <?php echo get_theme_mod('simplyread_color_settings'); ?>;
        }
      }
     
    </style>
  <?php
    }
    
  }
endif;
add_action( 'wp_head', 'simplyread_apply_color' );
/*-----------------------------------------------------------------------------------*/
/* custom functions below */
/*-----------------------------------------------------------------------------------*/
define('THEMEURL', get_template_directory_uri());
define('IMAGES', THEMEURL.'/images'); 
define('JS', THEMEURL.'/js');
define('CSS', THEMEURL.'/css');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_filter( 'post_thumbnail_html', 'simplyread_remove_thumbnail_dimensions', 10, 3 );

function simplyread_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

function simplyread_paginate() {
global $wp_query, $wp_rewrite;
$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

$pagination = array(
    'base' => @add_query_arg('page','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'show_all' => true,
    'type' => 'list',
    'next_text' => '&raquo;',
    'prev_text' => '&laquo;'
    );

if( $wp_rewrite->using_permalinks() )
    $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 'page', get_pagenum_link( 1 ) ) ) . '?page=%#%/', 'paged' );

if( !empty($wp_query->query_vars['s']) )
    $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

echo paginate_links( $pagination );
}
add_filter( 'the_content', 'simplyread_remove_br_gallery', 11, 2);

function simplyread_remove_br_gallery($output) {
    return preg_replace('/<br style=(.*)>/mi','',$output);
}

function simplyread_author_excerpt() {
      $text_limit = 50; //Words to show in author bio excerpt
      $read_more  = "Read more"; //Read more text
      $end_of_txt = "...";
      $name_of_author = get_the_author();
      $url_of_author  = get_author_posts_url(get_the_author_meta('ID'));
      $short_desc_author = wp_trim_words(strip_tags(
                          get_the_author_meta('description')), $text_limit, 
                          $end_of_txt.'<br/>
                        <a href="'.$url_of_author.'" style="font-weight:bold;">'.$read_more .'</a>');

      return $short_desc_author;
}

 function simplyread_catch_that_image() {
  global $post;
  $pattern = '|<img.*?class="([^"]+)".*?/>|';
  $transformed_content = apply_filters('the_content',$post->post_content);
  preg_match($pattern,$transformed_content,$matches);
  if (!empty($matches[1])) {
    $classes = explode(' ',$matches[1]);
    $id = preg_grep('|^wp-image-.*|',$classes);
    if (!empty($id)) {
      $id = str_replace('wp-image-','',$id);
      if (!empty($id)) {
        $id = reset($id);
        $transformed_content = wp_get_attachment_image($id,'full');  
        return $transformed_content;
      }
    }
  }
  
}

function simplyread_catch_that_image_thumb() {
  global $post;
  $pattern = '|<img.*?class="([^"]+)".*?/>|';
  $transformed_content = apply_filters('the_content',$post->post_content);
  preg_match($pattern,$transformed_content,$matches);
  if (!empty($matches[1])) {
    $classes = explode(' ',$matches[1]);
    $id = preg_grep('|^wp-image-.*|',$classes);
    if (!empty($id)) {
      $id = str_replace('wp-image-','',$id);
      if (!empty($id)) {
        $id = reset($id);
        $transformed_content = wp_get_attachment_image($id,'thumbnail');  
         return $transformed_content;
      }
    }
  }
 
}

function simplyread_catch_gallery_image_full()  { 
    global $post;
    $gallery = get_post_gallery( $post, false );
    if ( !empty($gallery['ids']) ) {
      $ids = explode( ",", $gallery['ids'] );
      $total_images = 0;
      foreach( $ids as $id ) {
        
        $title = get_post_field('post_title', $id);
        $meta = get_post_field('post_excerpt', $id);
        $link = wp_get_attachment_url( $id );
        $image  = wp_get_attachment_image( $id, 'full');
        $total_images++;
        
        if ($total_images == 1) {
          $first_img = $image;
          return $first_img;
        }
      }
    } 
}

function simplyread_catch_gallery_image_thumb()  { 
    global $post;
    $gallery = get_post_gallery( $post, false );
    if ( !empty($gallery['ids']) ) {
      $ids = explode( ",", $gallery['ids'] );
      $total_images = 0;
      foreach( $ids as $id ) {
        
        $title = get_post_field('post_title', $id);
        $meta = get_post_field('post_excerpt', $id);
        $link = wp_get_attachment_url( $id );
        $image  = wp_get_attachment_image( $id, 'thumbnail');
        $total_images++;
        
        if ($total_images == 1) {
          $first_img = $image;
          return $first_img;
        }
      }
    } 
}

/* social icons*/
function simplyread_social_icons()  { 

  $social_networks = array( array( 'name' => __('Facebook','simplyread'), 'theme_mode' => 'simplyread_facebook','icon' => 'fa-facebook' ),
                            array( 'name' => __('Twitter','simplyread'), 'theme_mode' => 'simplyread_twitter','icon' => 'fa-twitter' ),
                            array( 'name' => __('Google+','simplyread'), 'theme_mode' => 'simplyread_google','icon' => 'fa-google-plus' ),
                            array( 'name' => __('Pinterest','simplyread'), 'theme_mode' => 'simplyread_pinterest','icon' => 'fa-pinterest' ),
                            array( 'name' => __('Linkedin','simplyread'), 'theme_mode' => 'simplyread_linkedin','icon' => 'fa-linkedin' ),
                            array( 'name' => __('Youtube','simplyread'), 'theme_mode' => 'simplyread_youtube','icon' => 'fa-youtube' ),
                            array( 'name' => __('Tumblr','simplyread'), 'theme_mode' => 'simplyread_tumblr','icon' => 'fa-tumblr' ),
                            array( 'name' => __('Instagram','simplyread'), 'theme_mode' => 'simplyread_instagram','icon' => 'fa-instagram' ),
                            array( 'name' => __('Flickr','simplyread'), 'theme_mode' => 'simplyread_flickr','icon' => 'fa-flickr' ),
                            array( 'name' => __('Vimeo','simplyread'), 'theme_mode' => 'simplyread_vimeo','icon' => 'fa-vimeo-square' ),
                            array( 'name' => __('RSS','simplyread'), 'theme_mode' => 'simplyread_rss','icon' => 'fa-rss' )
                      );


  for ($row = 0; $row < 11; $row++)
  {
     
      if (get_theme_mod( $social_networks[$row]["theme_mode"])): ?>
         <a href="<?php echo esc_url( get_theme_mod($social_networks[$row]['theme_mode']) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( $social_networks[$row]['theme_mode'] ) ); ?>" target="_blank">
          <i class="fa <?php echo $social_networks[$row]['icon']; ?>"></i> 
          <span><?php echo $social_networks[$row]["name"]; ?></span>
        </a>
      <?php endif;
  }

  if(get_theme_mod('simplyread_email')): ?>
        <a href="mailto:<?php echo esc_attr(get_theme_mod('simplyread_email')); ?>" class="social-tw" title="<?php echo esc_attr( get_theme_mod('simplyread_email')); ?>" target="_blank">
          <i class="fa fa-envelope"></i> 
          <span><?php _e('Email','simplyread') ?></span>
        </a>
  <?php endif;                        
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/library/class/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'simplyread_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function simplyread_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
 
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Advanced Custom Fields',
            'slug'      => 'advanced-custom-fields',
            'required'  => false,
        ),
 
    );
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
 
    tgmpa( $plugins, $config );
 
}
/* DON'T DELETE THIS CLOSING TAG */ ?>