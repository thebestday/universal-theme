

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!-- КАЗАЛОСЬ БЫ В ТЕГЕ НИЧЕГО НЕТ -ПУСТО но WP понимает что мы подключили шаблон и внутрь него он выводит nav и комменты -->
<!-- это будет общий файл для всех типов постов -->
<!-- но если создать файл content-post то он уже будет выводить контент для определенного поста -->



    <!-- выводиться  шапка поста -->
	<!-- сначала проверяем есть ли картинка - если нет то ставим заглушку -->
	<header class="entry-header <?php echo get_post_type();?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), 
		url(
			<?php 
				// выводим миниатюру поста
				if(has_post_thumbnail() ){
					echo get_the_post_thumbnail_url();																							
				} 
				else {
					echo get_template_directory_uri(). '/assets/images/img-default.png';
				}										
			?>

		);">

		<div class="container">
			<div class="post-header-wrapper">
				<div class="post-header-nav">

					<?php
						// перед тайтлом выдом категории
						foreach ( get_the_category() as $category) {
							printf(
								'<a href="%s" class="category-link %s">%s</a>', 
								esc_url(get_category_link( $category ) ), 
								esc_html($category -> slug ), 
								esc_html($category -> name ),
							);
						};
					?>

					<!-- выводим ссылку на главную -->
					<a class="home-link" href="<?php echo get_home_url(); ?>">
						<svg width="18" height="17" class="icon comments-icon">
							<use xlink:href="<?php echo get_template_directory_uri()?> . ../assets/images/sprite.svg#home"></use>
						</svg>
						На главную
					</a>

					<?php
						// выводим ССЫЛКИ  вперед назад со стрелочками навигация
						the_post_navigation(
							array(
								'prev_text' => '<span class="post-nav-prev">
									<svg width="15" height="7" class="icon prev-icon">
										<use xlink:href="' . get_template_directory_uri() . './assets/images/sprite.svg#left-arrow"></use>
									</svg>
								' . esc_html__( 'Назад', 'universal-theme' ) . '</span>',
								// 'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Вперед:', 'universal-example' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="post-nav-next">' . esc_html__( 'Вперед', 'universal-theme' ) . '
									<svg width="15" height="7" class="icon next-icon">
										<use xlink:href="' . get_template_directory_uri() . './assets/images/sprite.svg#arrow"></use>
									</svg>
								</span>',
							)
						);
					?>
				</div>					
				<!-- /. post-header-nav -->	

				<div class="post-header-title-wrapper">
					<?php
						//выводим title
						// проверяем точно ли мы на странице поста - ф-я is_singular() выведет true если да 
						if ( is_singular() ) :
							// вешаем класс entry-title на заголовое h1
							the_title( '<h1 class="post-title">', '</h1>' );
						else :
							the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;
					?>
					<button class="bookmark">
						<svg width="30" height="30" class="icon icon-wrapper">
							<use xlink:href="<?php echo get_template_directory_uri()?> . /assets/images/sprite.svg#bookmark"></use>
						</svg>
					</button>

				</div>		
				<!-- /. post-header-title-wrapper -->

				<?php the_excerpt();?>
	
				<div class="post-header-info">
						<svg width="15" height="15" class="post-header-date">
							<use xlink:href="<?php echo get_template_directory_uri()?> . ../assets/images/sprite.svg#clock"></use>
						</svg>					
						<span class="post-header-date">
							<?php the_time('j F h:m') ?>
						</span>				
					<div class="comments post-header-comments">
						<svg width="15" height="14" class="icon comments-icon">
							<use xlink:href="<?php echo get_template_directory_uri() ?> . /assets/images/sprite.svg#comment"></use>
						</svg>
						<span class="comments-counter"><?php comments_number( '0', '1', '%') ?></span>
					</div>
				
					<div class="likes post-header-likes">
						<!-- <img src="<?php echo get_template_directory_uri() ?> . /assets/images/heart-grey.svg" alt="icon: like" class="likes-icon"> -->
			
						<svg width="19" height="15" fill="#BCBFC2" class="likes-icon">
							<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#heart"></use>
						</svg>

						<span class="likes-counter"><?php comments_number( '0', '1', '%') ?></span>
					</div>
				</div>
				<!-- /.post-header-info -->

				<div class="post-author">
					<div class="post-author-info">
						<?php $author_id = get_the_author_meta('ID'); ?>						
						<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="post-author-avatar">
				
						<span class="post-author-name"><?php the_author() ?></span>
						<span class="post-author-rank">Должность</span>
						<span class="post-author-posts">							
							<?php plural_form(count_user_posts($author_id), array('статья','статьи','статей'));	?>
						</span>

					</div>
					<!-- /. post-author-info -->

					<a href="<?php echo get_author_posts_url( $author_id); ?>"  class="post-author-link">Cтраница автора</a>
				
				</div>
				<!-- /. post-author	 -->

			</div>
			<!-- /. post-header-wrapper -->
		</div>		
	</header>	<!-- шапка поста  -->

	<div class="container">						
		<!-- ЭТО САМАЯ ВАЖНАЯ ЧАСТЬ КОТОРАЯ ВЫВОДИТ содержимое поста  -->
		<div class="post-content">
			<?php
				// выводим содержимое поста с помощью функции the_content, с помощью sprintf выводим на экране
				the_content(
					sprintf(
						// с помощью wp_kses wp_kses_post очищаем title от разных лишних тегов
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-theme' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				// Обертка для постраничной навигации
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-theme' ),
						'after'  => '</div>',
					)
				);
			?>
		</div>
		<!-- /. ЭТО САМАЯ ВАЖНАЯ ЧАСТЬ КОТОРАЯ ВЫВОДИТ содержимое поста  -->
	</div>

	<!-- Подвал поста  -->
	<footer class="entry-footer">
		<div class="container">
			<!-- из файла template-tags.php берем эту костнструкцию -->
			<!-- translators: used between list items, there is a space after the comma  -->
			<!-- ВЫВОДИТ КАКИЕ ТЕГИ ЕСТЬ У ЭТОГО ПОСТА -  Tagged freelance, portfolio  слово Tagged убираем оставляем сами теги-->
			<?php		
				$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'universal-theme' ) );
				if ( $tags_list ) {				
					printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-theme' ) . '</span>', $tags_list ); 
				}
			?>	
		</div>
	
		

	</footer>


</article> 