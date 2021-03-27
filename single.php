<?php get_header('post'); ?>
<!-- <h1>Привет, это single.php - здесь не просто контент - здесь должно быть содержание поста - их наличие проверяется в начала</h1> -->

	<main class="site-main">
		<?php 
			// проверяем есть ли посты
			while ( have_posts() ) :
				// если пост есть то выводим содержимое то что в content-post.php или в content.php (если не создан  файл content-post.php)
				// мы пока будет использовать общий контент файл content.php
				the_post();

				// находим шаблон для вывода поста в папке template-parts(папку мы уже создали) и там в файле content.php получить тип поста(страницы)
				// Всего 3 типа записей ПОСТЫ КУРСЫ ВИДЕОУРОКИ
				// т.е. get_post_type() будет возврщать либо 'post' 'lesson' 'videolesson' те тпи контента для определенной страницы
				// по сути он ищет  файл такой конструкции template-parts/content-{post-type}.php например  template-parts/content-{post}.php или template-parts/content-{page}.php
				get_template_part('template-parts/content', get_post_type() );

				// выводим ссылки на предыдущий и следующий посты - ВСЕ В ДАЛЬНЕЙШЕМ ЗАБРАЛИ В contnent.php
				// the_post_navigation(
				// 	array(
				// 		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Назад:', 'universal-example' ) . '</span>',
				// 		// 'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Вперед:', 'universal-example' ) . '</span> <span class="nav-title">%title</span>',
				// 		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Вперед:', 'universal-example' ) . '</span>',
				// 	)
				// );

				// If comments are open or we have at least one comment, load up the comment template.
				// если комментарии к записи открыты, выводим комментарии при помощи функции comments_template()
				
				// Т.Е. У НАС ДАЖЕ ДЛЯ КОММЕНТАРИЙ БУДЕТ ОТДЕЛЬНЫЙ ШАБЛОН
				if ( comments_open() || get_comments_number() ) :
					// comments_template() находит файл comments.php и выводит его 
					comments_template();
				endif;

			endwhile; // End of the loop.
		?>		

	</main>
	<!-- #main -->


<?php get_footer(); ?>
