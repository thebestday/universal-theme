<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!-- КАЗАЛОСЬ БЫ В ТЕГЕ НИЧЕГО НЕТ -ПУСТО но WP понимает что мы подключили шаблон и внутрь него он выводит nav и комменты -->
<!-- это будет общий файл для всех типов постов --> <!-- но если создать файл content-post то он уже будет выводить контент для определенного поста -->

    <!-- выводиться  шапка поста --> 	<!-- сначала проверяем есть ли картинка - если нет то ставим заглушку -->
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
				</div>					
				<!-- /. post-header-nav -->	

				<div class="lesson-header-title-wrapper">
					<?php
						//выводим title
						// проверяем точно ли мы на странице поста - ф-я is_singular() выведет true если да 
						if ( is_singular() ) :
							// вешаем класс entry-title на заголовое h1
							the_title( '<h1 class="lesson-header-title">', '</h1>' );
						else :
							the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;
					?>

				</div>		
				<!-- /. post-header-title-wrapper -->

				<!-- ПЕРЕД тем как выводить title мы можем вывести блок с видео (который прописали с помощью Группы полей) -->
				<!-- <?php the_field('video_link')?> -->
				<div class="video">
					<?php
						$video_link = get_field('video_link');						
						$pos = stripos($video_link, 'youtu');
						if (($video_link) and $pos) {
							?>	
								<iframe width="100%" height="450" src="https://www.youtube.com/embed/
								<?php
									// $video_link = get_field('video_link');
									// $pos = stripos($video_link, 'youtu');
									if (($video_link) and $pos) {
										$tmp = explode('be/', get_field('video_link'));
										echo end ($tmp);
									} 							
						
								?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; 		clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
								</iframe>
							<?php
						} else {
							?>
								<iframe src="https://player.vimeo.com/video/
								<?php
									$video_link = get_field('video_link');
									$pos = stripos($video_link, 'vimeo');
									if (($video_link) and $pos) {
										$tmp = explode('om/', get_field('video_link'));
										echo end ($tmp);
									} 								
									
								?>" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
								</iframe>
							<?php
						}

					?>	

					<!-- <iframe src="https://player.vimeo.com/video/
					<?php
						$video_link = get_field('video_link');
						$pos = stripos($video_link, 'vimeo');
						if (($video_link) and $pos) {
							$tmp = explode('om/', get_field('video_link'));
							echo end ($tmp);
						} 								
						
					?>" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
					</iframe> -->

					

					<!-- <?php the_field('video_link')?>-->

				</div>			



				<div class="post-header-info">
						<svg width="15" height="15" class="post-header-date">
							<use xlink:href="<?php echo get_template_directory_uri()?> . ../assets/images/sprite.svg#clock"></use>
						</svg>					
						<span class="post-header-date">
							<?php the_time('j F h:m') ?>
						</span>		

				</div>
				<!-- /.post-header-info -->



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
	<div class="container">		
		<footer class="post-footer">			
			<!-- из файла template-tags.php берем эту костнструкцию -->
			<!-- translators: used between list items, there is a space after the comma  -->
			<!-- ВЫВОДИТ КАКИЕ ТЕГИ ЕСТЬ У ЭТОГО ПОСТА -  Tagged freelance, portfolio  слово Tagged убираем оставляем сами теги-->
			
			<?php		
				$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'universal-theme' ) );
				if ( $tags_list ) {				
					printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-theme' ) . '</span>', $tags_list ); 
				}
				// Подделиться в соцсетях
				meks_ess_share();
				// get_sidebar('category');
			?>	
			
		</footer>
		
	</div>			
				
</article> 