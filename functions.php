<?php
// Добавление расширенных возможностей
if ( ! function_exists( 'universal_theme_setup' ) ) :	
	function universal_theme_setup() {
		// Добавление тега title-tag
		add_theme_support( 'title-tag' );

		// Добавление миниатюр - только для постов
		add_theme_support( 'post-thumbnails', array( 'post' ) );

		// Добавление пользовательского логотипа
		add_theme_support( 'custom-logo', [			
			'width'       => 163,			
			'flex-height' => true,			
			'header-text' => 'Universal',
			'unlink-homepage-logo' => true, // WP 5.5
		] );

		// Регистрация меню
		register_nav_menus( [
			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале'
		] );

		// Новый тип записи - функция register_post_types позволяет создать несколько типов постов(ф-я цепляется к хуку init)
		add_action( 'init', 'register_post_types' );
		function register_post_types(){
			register_post_type( 'lesson', [
				'label'  => null,
				'labels' => [
					'name'               => 'Уроки', // основное название для типа записи
					'singular_name'      => 'Урок', // название для одной записи этого типа
					'add_new'            => 'Добавить урок', // для добавления новой записи
					'add_new_item'       => 'Добавление урока', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Редактирование урока', // для редактирования типа записи
					'new_item'           => 'Новый урок', // текст новой записи
					'view_item'          => 'Смотреть уроки', // для просмотра записи этого типа.
					'search_items'       => 'Искать уроки', // для поиска по этим типам записи
					'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
					'parent_item_colon'  => '', // для родителей (у древовидных типов)
					'menu_name'          => 'Уроки', // название меню
				],
				'description'         => 'Раздел с видеоуроками',
				'public'              => true,
				// 'publicly_queryable'  => null, // зависит от public
				// 'exclude_from_search' => null, // зависит от public
				// 'show_ui'             => null, // зависит от public
				// 'show_in_nav_menus'   => null, // зависит от public
				'show_in_menu'        => true, // показывать ли в меню адмнки
				// 'show_in_admin_bar'   => null, // зависит от show_in_menu
				'show_in_rest'        => true, // добавить в REST API. C WP 4.7
				'rest_base'           => null, // $post_type. C WP 4.7
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-welcome-learn-more',
				'capability_type'   => 'post',
				//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
				//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
				'hierarchical'        => false,
				'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
				'taxonomies'          => [],
				'has_archive'         => true,
				'rewrite'             => true,
				'query_var'           => true,
			] );
		}	



	}	
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );


// Подключение сайдбара на главной - регистрация области под виджеты

function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной сверху', 'universal-theme' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной снизу', 'universal-theme' ),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Добавьте меню сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Посты одной категории', 'universal-theme' ),
			'id'            => 'sidebar-category',
			'description'   => esc_html__( 'Добавьте текст сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

}
add_action( 'widgets_init', 'universal_theme_widgets_init' );
// конец подключения области сайдбара



// ВИДЖЕТЫ
// Добавление нового виджета Downloader_Widget.  Регистрация виджета используя основной класс
class Downloader_Widget extends WP_Widget {

	function __construct() {
		// вызов конструктора выглядит так: __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader' )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ) );
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	
	//Вывод виджета во Фронт-энде

	function widget( $args, $instance ) {
		$title = $instance['title'];
		$description = $instance['description'];
		$link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if ( ! empty( $description ) ) {
			echo '<p>' . $description . '</p>';
		}
		if ( ! empty( $link ) ) {
			// echo '<a target="blank" class="widget-link" href="' . $link . '"><img class="widget-link-icon"
			// src=" ' . get_template_directory_uri(). '/assets/images/download.svg">Скачать</a>';	

			echo '<a target="blank" class="widget-link"  href="' . $link . '"><svg width="17" height="17" fill="#ffffff" class="widget-link-icon">
        <use xlink:href="' . get_template_directory_uri( ) . '/assets/images/sprite.svg#download"></use></svg>Скачать</a>';
            
		
		}

		echo $args['after_widget'];
	}

	
	//Админ-часть виджета
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Заголовок по умолчанию';
		$description = @ $instance['description'] ?: 'Описание';
		$link = @ $instance['link'] ?: 'http://disc.ru';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>

		<?php 
	}

	
	//Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_downloader_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		// wp_enqueue_script('my_downloader_widget_script', $theme_url .'/downloader_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_downloader_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Donwloader_Widget
// регистрация Donwloader_Widget в WordPress
function register_downloader_widget() {
	register_widget('Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );



// Добавление нового виджета Social_Widget.  Регистрация виджета используя основной класс
class Social_Widget extends WP_Widget {

	function __construct() {
		// вызов конструктора выглядит так: __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => 'Наши соцсети', 'classname' => 'widget-social' )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ) );
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	
	//Вывод виджета во Фронт-энде

	function widget( $args, $instance ) {
		$title = $instance['title'];
		// $description = $instance['description'];
		$link_Facebook = $instance['link_Facebook'];
		$link_Instagram = $instance['link_Instagram'];
		$link_Youtube = $instance['link_Youtube'];
		$link_Twitter = $instance['link_Twitter'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'] . '<div class="widget-social-wrapper">';
		}
		// if ( ! empty( $description ) ) {
		// 	echo '<p>' . $description . '</p>';
		// }

		

		if ( ! empty( $link_Facebook ) ) {
			echo ' <a target="blank" class="widget-link" href="' . $link_Facebook . '"><svg width="50" height="50" fill="#4267B2" class="widget-link-icon"><use xlink:href="' . get_template_directory_uri() . '../assets/images/sprite.svg#facebook"></use></svg></a>';
			
			// echo ' <a target="blank" class="widget-link" href="' . $link_Facebook . '"><img class="widget-link-icon"
			// src=" ' . get_template_directory_uri(). '/assets/images/facebook.svg"></a>';

			
		}
		if ( ! empty( $link_Instagram ) ) {			
			echo '<a target="blank" class="widget-link"  href="' . $link_Instagram . '"><svg width="50" height="50" fill="#7C7C7C" class="widget-link-icon"><use xlink:href="' . get_template_directory_uri() . '../assets/images/sprite.svg#instagram"></use></svg></a>';

			// echo '  <a target="blank" class="widget-link" href="' . $link_Instagram . '"><img class="widget-link-icon"
			// src=" ' . get_template_directory_uri(). '/assets/images/instagram.svg"></a>';

		}

		if ( ! empty( $link_Youtube ) ) {
			// echo '  <a target="blank" class="widget-link" href="' . $link_Youtube . '"><img class="widget-link-icon"
			// src=" ' . get_template_directory_uri(). '/assets/images/youTube.svg"></a>';
			echo '<a target="blank" class="widget-link"  href="' . $link_Youtube . '"><svg width="50" height="50" fill="red" class="widget-link-icon"><use xlink:href="' . get_template_directory_uri() . '../assets/images/sprite.svg#youtube"></use></svg></a>';

		}
		if ( ! empty( $link_Twitter ) ) {
			// echo '  <a target="blank" class="widget-link" href="' . $link_Twitter . '"><img class="widget-link-icon"
			// src=" ' . get_template_directory_uri(). '/assets/images/twitter.svg"></a>';

			echo '<a target="blank" class="widget-link"  href="' . $link_Twitter . '"><svg width="50" height="50" fill="#1DA1F2" class="widget-link-icon"><use xlink:href="' . get_template_directory_uri( ) . '../assets/images/sprite.svg#twitter"></use></svg></a>';
		}
        
		
		echo $args['after_widget'];
	}

	
	//Админ-часть виджета
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Наши соцсети';
		// $description = @ $instance['description'] ?: 'Вставьте ниже свои соцсети';
		$link_Facebook = @ $instance['link_Facebook'] ?: 'https://www.facebook.com/';
		$link_Instagram = @ $instance['link_Instagram'] ?: 'https://www.instagram.com/';
		$link_Youtube = @ $instance['link_Youtube'] ?: 'https://www.youtube.com/';
		$link_Twitter = @ $instance['link_Twitter'] ?: 'https://twitter.com/';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

		</p>
		<!-- <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p> -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link_Facebook' ); ?>"><?php _e( 'link_Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_Facebook' ); ?>" name="<?php echo $this->get_field_name( 'link_Facebook' ); ?>" type="text" value="<?php echo esc_attr( $link_Facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_Instagram' ); ?>"><?php _e( 'link_Instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_Instagram' ); ?>" name="<?php echo $this->get_field_name( 'link_Instagram' ); ?>" type="text" value="<?php echo esc_attr( $link_Instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_Youtube' ); ?>"><?php _e( 'link_Youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_Youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_Youtube' ); ?>" type="text" value="<?php echo esc_attr( $link_Youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_Twitter' ); ?>"><?php _e( 'link_Twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_Twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_Twitter' ); ?>" type="text" value="<?php echo esc_attr( $link_Twitter ); ?>">
		</p>

		<?php 
	}

	
	//Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		// $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link_Facebook'] = ( ! empty( $new_instance['link_Facebook'] ) ) ? strip_tags( $new_instance['link_Facebook'] ) : '';
		$instance['link_Instagram'] = ( ! empty( $new_instance['link_Instagram'] ) ) ? strip_tags( $new_instance['link_Instagram'] ) : '';
		$instance['link_Youtube'] = ( ! empty( $new_instance['link_Youtube'] ) ) ? strip_tags( $new_instance['link_Youtube'] ) : '';
		$instance['link_Twitter'] = ( ! empty( $new_instance['link_Twitter'] ) ) ? strip_tags( $new_instance['link_Twitter'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_social_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		// wp_enqueue_script('social_widget_script', $theme_url .'/social_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_social_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.social_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget


// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget('Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );


class Recent_Posts_Widget extends WP_Widget {

	function __construct() {
		// вызов конструктора выглядит так: __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Недавно опубликовано',
			array( 'description' => 'Последние посты', 'classname' => 'widget-recent-posts' )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ) );
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	
	//Вывод виджета во Фронт-энде

	function widget( $args, $instance ) {
		$title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
				
		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-posts-wrapper">';
			global $post;
			$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
			foreach ( $postslist as $post ){
				setup_postdata($post);
				?>
				<a href="<?php the_permalink(); ?>" class="recent-post-link">
					<img class="recent-post-thumb" src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail')?>" alt="">
					<div class='recent-post-info'>
						<h4 class="recent-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 30, '...'); ?></h4>
						
						<span class="recent-post-time">
							<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
							echo "$time_diff назад"; ?>
						</span>
					</div>
					
				</a>
				<?php
			}
			wp_reset_postdata();
			echo '</div>';
		}
		
		echo $args['after_widget'];
	}

	
	//Админ-часть виджета
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Недавно опубликовано';
		$count = @ $instance['count'] ?: '7';


		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>

		<?php 
	}

	
	//Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_posts_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		// wp_enqueue_script('recent_posts_widget_script', $theme_url .'/recent_posts_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_posts_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recent_posts_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Posts_Widget


// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget('Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );


// Добавление нового виджета Category_Widget.  Регистрация виджета используя основной класс
class Category_Widget extends WP_Widget {

	function __construct() {
		// вызов конструктора выглядит так: __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'category_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: category_widget
			'Посты одной категории',
			array( 'description' => 'Посты одной категории', 'classname' => 'widget-category' )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_category_widget_scripts' ) );
			add_action('wp_head', array( $this, 'add_category_widget_style' ) );
		}
	}

	
	//Вывод виджета во Фронт-энде

	function widget( $args, $instance ) {
		$count = $instance['count'];
		echo $args['before_widget'];
		if ($count%4 ===0) {
			echo '<div class="container post-widget-wrapper">';
			//Цикл
			global $post;
			$posts = get_posts( array(	'numberposts' => $count,) );
			$category = get_the_category();
			rsort($category);
			$cat_add_id = $category[0]->term_id;
			$real_id = get_the_ID();

			$set = array('cat' =>$cat_add_id);
			$posts = get_posts($set);

			foreach( $posts as $post ){
				setup_postdata($post);
				if ($post->ID <> $real_id){
				?>
					<a href="<?php the_permalink(); ?> class="post-widget-permalink"">
						<img src="<?php 
						if ( has_post_thumbnail() ) {
							echo get_the_post_thumbnail_url();
							}
							else {
								echo get_template_directory_uri() . '/assets/images/img-default.png';
							} ?>" alt="" class="post-widget-thumb">
							
						<h4 class="post-widget-title"><?php echo mb_strimwidth(get_the_title(),0, 45, '...'); ?></h4>

						<div class="post-widget-info">
							<div class="eye">
								<svg width="15" height="15" fill= "#BCBFC2" class="icon likes-icon">
									<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#eye"></use>
								</svg>
								<span class="eye-counter"><?php comments_number('0', '1', '%')?></span>
							</div>
							<div class="comments">
								<svg width="15" height="15" fill= "#BCBFC2" class="icon comments-icon">
									<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
								</svg>                                                        
								<span class="comments-counter"><?php comments_number('0', '1', '%')?></span>
							</div>
							
						</div>
					</a> 
				<?php
				}
			}
			wp_reset_postdata();
			echo '</div>';							
		}
		echo $args['after_widget'];
	}

	
	//Админ-часть виджета
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Заголовок по умолчанию';
		// $description = @ $instance['description'] ?: 'Описание';
		// $link = @ $instance['link'] ?: 'http://disc.ru';
		$count = @ $instance['count'] ?: '4';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

		<!-- </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p> -->
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов из категории:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>

		<?php 
	}

	
	//Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		// $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		// $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_category_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_category_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		// wp_enqueue_script('my_category_widget_script', $theme_url .'/category_widget_script.js' );
	}

	// стили виджета
	function add_category_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_category_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.category_widget a{ display:inline; }
		</style>
		<?php
	}

} 
function register_category_widget() {
	register_widget('Category_Widget' );
}

add_action( 'widgets_init', 'register_category_widget' );

//----------------------- конец области подключения виджетов-------------------------------------------------------------------




// Правильный способ подключить стили и скрипты

function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	//скрипт для swiper.css	
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style', time());
	wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time());
	
	// добавляем Roboto Slab
	wp_enqueue_style('Roboto Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
	// для подключения jQuery
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.6.0.min.js');
	wp_enqueue_script( 'jquery' );
	
	//скрипт для swiper.js
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true);
    // наш файл js
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

// Достучаться до файла admin-ajax.php
add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){

	// Первый параметр 'twentyfifteen-script' означает, что код будет прикреплен к скрипту с ID 'twentyfifteen-script'
	// 'twentyfifteen-script' должен быть добавлен в очередь на вывод, иначе WP не поймет куда вставлять код локализации
	// Заметка: обычно этот код нужно добавлять в functions.php в том месте где подключаются скрипты, после указанного скрипта
	wp_localize_script( 'jquery', 'adminAjax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}
// создаем обработчик формы
add_action( 'wp_ajax_contacts_form', 'ajax_form' );
add_action( 'wp_ajax_nopriv_contact_form', 'ajax_fomr' );
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	// $headers = array(
	// 	'From' => 'webmaster@example.com',
	// 	'Reply-To' => 'webmaster@example.com',
	// 	'X-Mailer' => 'PHP/' . phpversion()
	// );
	// echo 'Имя пользователя: ' . $contact_name . '</b> Его email: ' . $contact_email;
	// $message = 'Пользователь ' . $contact_name . ' задал вопрос: ' . $contact_comment;
	// mail('web@mail.ru', 'Новая заявка', $message, $headers);
	// echo 'ok';
	$message = 'Данные пользователя: ' . $contact_name . ' задал вопрос: ' . $contact_comment;	
	// wp_mail вместо mail()
	$headers = 'From: Maksim <thebestweb@mail.ru>' . "\r\n";
	$sent_message = wp_mail('thebestweb@yandex.ru', 'Новая заявка с сайта', $message, $headers);
	if ($sent_message) {
		echo 'Все получилось';
	} else {
		echo 'Где-то ошибка';
	}

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}



// ФИЛЬТРЫ
// ИЗМЕНЯЕМ НАСТРОЙКИ ОБЛАКА ТЕГОВ
add_filter('widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unut'] = 'px';
	$args['smallest'] = '12';
	$args['largest'] = '12';
	$args['number'] = '15';
	// $args['orderby'] = 'count';
	return $args;

}


# отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

//добавление миниатюр

if ( function_exists( 'add_image_size' ) ) {	
	add_image_size( 'homepage-thumb', 65, 65, true ); // Кадрирование изображения
}

// меняем стиль многоточия в открывках - т.е убираем  […] - ставим просто ...
add_filter('excerpt_more', function($more) {
	return '...';
});

// Склоняем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}