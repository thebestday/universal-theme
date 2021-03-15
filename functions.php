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
	}	
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );


// Подключение сайдбара на главной - регистрация области под виджеты

function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной', 'universal-theme' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
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
			echo '<a target="blank" class="widget-link" href="' . $link . '"><img class="widget-link-icon"
			src=" ' . get_template_directory_uri(). '/assets/images/download.svg">Скачать</a>';
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
		$facebook = $instance['facebook'];
		$instagram = $instance['instagram'];
		$youtube = $instance['youtube'];
		$twitter = $instance['twitter'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// if ( ! empty( $description ) ) {
		// 	echo '<p>' . $description . '</p>';
		// }

		

		if ( ! empty( $facebook ) ) {
			echo ' <a target="blank" class="widget-link" href="' . $facebook . '"><img class="widget-link-icon"
			src=" ' . get_template_directory_uri(). '/assets/images/facebook.svg"></a>';
		}
		if ( ! empty( $instagram ) ) {
			echo '  <a target="blank" class="widget-link" href="' . $instagram . '"><img class="widget-link-icon"
			src=" ' . get_template_directory_uri(). '/assets/images/instagram.svg"></a>';
		}
		if ( ! empty( $youtube ) ) {
			echo '  <a target="blank" class="widget-link" href="' . $youtube . '"><img class="widget-link-icon"
			src=" ' . get_template_directory_uri(). '/assets/images/youTube.svg"></a>';
		}
		if ( ! empty( $twitter ) ) {
			echo '  <a target="blank" class="widget-link" href="' . $twitter . '"><img class="widget-link-icon"
			src=" ' . get_template_directory_uri(). '/assets/images/twitter.svg"></a>';
		}
        
		
		echo $args['after_widget'];
	}

	
	//Админ-часть виджета
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Наши соцсети';
		// $description = @ $instance['description'] ?: 'Вставьте ниже свои соцсети';
		$facebook = @ $instance['facebook'] ?: 'https://www.facebook.com/';
		$instagram = @ $instance['instagram'] ?: 'https://www.instagram.com/';
		$youtube = @ $instance['youtube'] ?: 'https://www.youtube.com/';
		$twitter = @ $instance['twitter'] ?: 'https://twitter.com/';

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
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
		</p>

		<?php 
	}

	
	//Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		// $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';

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


//----------------------- конец области подключения виджетов-------------------------------------------------------------------




// Правильный способ подключить стили и скрипты

function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time());	
	// добавляем Roboto Slab
	wp_enqueue_style('Roboto Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );




// ФИЛЬТРЫ
// ИЗМЕНЯЕМ НАСТРОЙКИ ОБЛАКА ТЕГОВ
add_filter('widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unut'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '10';
	$args['orderby'] = 'count';
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