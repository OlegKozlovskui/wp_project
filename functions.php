<?php

//SCRIPTS AND STYLES
function theme_name_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/style.css' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
	if ( is_singular() ) {
		wp_enqueue_script( "comment-reply" );
	}
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

//ENABLE THUMBNAILS
add_theme_support( 'post-thumbnails' );

//REGISTER MENU
function theme_register_nav_menu() {
	register_nav_menu( 'primary', 'Primary Menu' );
}

add_action( 'after_setup_theme', 'theme_register_nav_menu' );

//SUPPORT HTML5
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption'
) );

add_theme_support( 'post-formats', array() );

//REGISTER WIDGETS
function flying_register_widgets() {
	// register sidebars
	register_sidebar( array(
		'id'            => 'sidebar',
		'name'          => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s sidebar-entry">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="title">',
		'after_title'   => '</h3>',
		'description'   => 'Drag the widgets for sidebars.'
	) );
}
add_action( 'widgets_init', 'flying_register_widgets' );

//REGISTER NEW POST TYPE
function prefix_register_post_type()
{
	register_post_type(
		'prefix_portfolio',
		array(
			'labels'        => array(
				'name'               => __('Portfolio', 'text_domain'),
				'singular_name'      => __('Portfolio', 'text_domain'),
				'menu_name'          => __('Portfolio', 'text_domain'),
				'name_admin_bar'     => __('Portfolio Item', 'text_domain'),
				'all_items'          => __('All Items', 'text_domain'),
				'add_new'            => _x('Add New', 'prefix_portfolio', 'text_domain'),
				'add_new_item'       => __('Add New Item', 'text_domain'),
				'edit_item'          => __('Edit Item', 'text_domain'),
				'new_item'           => __('New Item', 'text_domain'),
				'view_item'          => __('View Item', 'text_domain'),
				'search_items'       => __('Search Items', 'text_domain'),
				'not_found'          => __('No items found.', 'text_domain'),
				'not_found_in_trash' => __('No items found in Trash.', 'text_domain'),
				'parent_item_colon'  => __('Parent Items:', 'text_domain'),
			),
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'custom-fields',
			),
			'taxonomies'    => array(
				'prefix_portfolio_categories',
			),
			'has_archive'   => true,
			'rewrite'       => array(
				'slug' => 'portfolio',
			),
		)
	);
}

add_action('init', 'prefix_register_post_type');

//REGISTER TAXONOMY
function prefix_register_taxonomy()
{
	register_taxonomy(
		'prefix_portfolio_categories',
		array(
			'prefix_portfolio',
		),
		array(
			'labels'            => array(
				'name'              => _x('Categories', 'prefix_portfolio', 'text_domain'),
				'singular_name'     => _x('Category', 'prefix_portfolio', 'text_domain'),
				'menu_name'         => __('Categories', 'text_domain'),
				'all_items'         => __('All Categories', 'text_domain'),
				'edit_item'         => __('Edit Category', 'text_domain'),
				'view_item'         => __('View Category', 'text_domain'),
				'update_item'       => __('Update Category', 'text_domain'),
				'add_new_item'      => __('Add New Category', 'text_domain'),
				'new_item_name'     => __('New Category Name', 'text_domain'),
				'parent_item'       => __('Parent Category', 'text_domain'),
				'parent_item_colon' => __('Parent Category:', 'text_domain'),
				'search_items'      => __('Search Categories', 'text_domain'),
			),
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => array(
				'slug' => 'portfolio/category',
			),
		)
	);
}

add_action('init', 'prefix_register_taxonomy', 0);

//ADD NEW WIDGET
class info_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'info_wg',
			'Info Widget',
			array( 'description' => 'Info widget with logo, text and social buttons' )
		);
	}

	public function widget( $args, $instance ) {
		$text = apply_filters( 'widget_title', $instance['text'] );
		$tw = $instance['tw'];
		$fb = $instance['fb'];
		$in = $instance['in'];
		$is = $instance['is'];
		$pn = $instance['pn'];
		$img = $instance['img'];

		if ( ! empty( $img ) ) { ?>
			<div class="tt-footer-logo">
				<img class="img-responsive" src="<?php echo $img; ?>" height="55" width="258" alt="">
			</div>
		<?php } ?>
		<div class="empty-space marg-lg-b25"></div>
		<?php if ( ! empty( $text ) ) { ?>
			<div class="simple-text size-3 color-7">
				<p><?php echo $text; ?></p>
			</div>
		<?php } ?>
		<div class="empty-space marg-lg-b20"></div>
		<div class="tt-footer-social">
			<?php if ( ! empty( $tw ) ) { ?>
				<a href="<?php echo $tw; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if ( ! empty( $fb ) ) { ?>
				<a href="<?php echo $fb; ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if ( ! empty( $in ) ) { ?>
				<a href="<?php echo $in; ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if ( ! empty( $is ) ) { ?>
				<a href="<?php echo $is; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if ( ! empty( $pn ) ) { ?>
				<a href="<?php echo $pn; ?>"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>
			<?php } ?>
		</div>
	<?php }
	public function form( $instance ) {
		//widgetform in backend
		$text = (isset($instance['text'])) ? strip_tags($instance['text']) : '';
		$tw = (isset($instance['tw'])) ? $instance['tw'] : '';
		$in = (isset($instance['in'])) ? $instance['in'] : '';
		$fb = (isset($instance['fb'])) ? $instance['fb'] : '';
		$is = (isset($instance['is'])) ? $instance['is'] : '';
		$pn = (isset($instance['pn'])) ? $instance['pn'] : '';
		$img = (isset($instance['img'])) ? $instance['img'] : '';
		?>
		<p>
			<button class="uc_upload_image_button">Upload image</button>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'img' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'img' )); ?>" type="text" value="<?php echo esc_attr( $img ); ?>" />
		</p>
		<p>
			<label style="display: block;" for="<?php echo esc_attr($this->get_field_id( 'text' )); ?>"><?php  esc_html_e('Text ', 'educationwp'); ?> </label>
			<textarea style="width: 100%;" name="<?php echo esc_attr($this->get_field_name( 'text' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'text' )); ?>" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'tw' )); ?>"><?php  esc_html_e('Link twitter ', 'educationwp'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tw' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tw' )); ?>" type="text" value="<?php echo esc_attr( $tw ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'in' )); ?>"><?php  esc_html_e('Link linkedin ', 'educationwp'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'in' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'in' )); ?>" type="text" value="<?php echo esc_attr( $in ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'fb' )); ?>"><?php  esc_html_e('Link facebook ', 'educationwp'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'fb' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb' )); ?>" type="text" value="<?php echo esc_attr( $fb ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'is' )); ?>"><?php  esc_html_e('Link instagram ', 'educationwp'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is' )); ?>" type="text" value="<?php echo esc_attr( $is ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'pn' )); ?>"><?php  esc_html_e('Link pinterest ', 'educationwp'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pn' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pn' )); ?>" type="text" value="<?php echo esc_attr( $pn); ?>" />
		</p>

		<?php }

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		$instance['tw'] = ( ! empty( $new_instance['tw'] ) ) ? strip_tags( $new_instance['tw'] ) : '';
		$instance['in'] = ( ! empty( $new_instance['in'] ) ) ? strip_tags( $new_instance['in'] ) : '';
		$instance['fb'] = ( ! empty( $new_instance['fb'] ) ) ? strip_tags( $new_instance['fb'] ) : '';
		$instance['is'] = ( ! empty( $new_instance['is'] ) ) ? strip_tags( $new_instance['is'] ) : '';
		$instance['pn'] = ( ! empty( $new_instance['pn'] ) ) ? strip_tags( $new_instance['pn'] ) : '';
		$instance['img'] = ( ! empty( $new_instance['img'] ) ) ? strip_tags( $new_instance['img'] ) : '';
		return $instance;
	}
}

function educationwp_fw_info_widget_load() {
	register_widget( 'info_widget' );
}

add_action( 'widgets_init', 'educationwp_fw_info_widget_load' );

//COMMENTS FUNCTIONS
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

if ( ! function_exists( 'binaryrobot_comment_nav' ) ) :
	function binaryrobot_comment_nav() {
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'binaryrobot' ); ?></h2>
			<div class="nav-links">
				<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'binaryrobot' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;
				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'binaryrobot' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
				?>
			</div>
			<?php
		endif;
	}
endif;
