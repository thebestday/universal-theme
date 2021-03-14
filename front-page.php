<?php get_header();?>

<main class="front-page-header">
	<div class="container">
		<div class="hero">
			<div class="left">
				<?php
					global $post;
					// обновляем глобальную переменную
					$myposts = get_posts([ 
						// последний пост
						// 'offset' => 1
						// 'orderby'	=> 'javascript',
						// 'order'   => 'ASC'	
						'numberposts' => 1,
						'category_name' => 'javascript, css, html, web-design'					
					]);

					if( $myposts ){
						foreach( $myposts as $post ){
							// переменную post передаем в ф-ю setup_postdata()
							setup_postdata( $post );
							?>
								<!-- Вывод заголовка текущей записи и миниатюры -->	
							<img src="<?php the_post_thumbnail_url() ?>" alt=""	class="post-thumb">
							<?php $author_id = get_the_author_meta('ID'); ?>		
							<a href="<?php echo get_author_posts_url( $author_id); ?>" class="author">
								<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="avatar">
								<div class="author-bio">
									<span class="author-name"><?php the_author() ?></span>
									<span class="author-rank">Должность</span>						
								</div>
							</a>
							<div class="post-text">
								<?php the_category(); ?>
								<h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h2>
								<a href="<?php echo get_the_permalink() ?>" class="more">Читать далее</a>
							</div>
					
							<?php 
							}
					} else {
						// Постов не найдено
						?> <p> Постов нет</p> <?php

					}
					wp_reset_postdata(); // Сбрасываем $post
				?>
			</div>
			<!-- /.left -->
			<div class="right">	
				<h3 class="recommend">Рекомендуем</h3>
				<ul class="posts-list">
					<?php
						global $post;
						// обновляем глобальную переменную
						$myposts = get_posts([
							// 'orderby'	=> 'javascript',
							// 'order'   => 'ASC'	
							'numberposts' => 5,
							'offset' => 1,
							'category_name' => 'javascript, css, html, web-design'					
						]);

						if( $myposts ){
							foreach( $myposts as $post ){
								// переменную post передаем в ф-ю setup_postdata()
								setup_postdata( $post );
							?>
					
							<li class="post">
								<?php the_category() ?>
								<a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
									<h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h4>
								</a>
								
							</li>
							<?php 
								}
							} else {
								// Постов не найдено
								?> <p> Постов нет</p> <?php

							}
						wp_reset_postdata(); // Сбрасываем $post
					?>			
				</ul>
			</div>
			<!-- /.right -->
		</div>
		<!-- /.hero -->
		



	</div>
	<!-- /.container -->

</main>

<div class="container">
	<ul class="article-list">
		<?php
			global $post;
			// обновляем глобальную переменную
			$myposts = get_posts([ 
				'numberposts' => 4,
				'category_name' => 'articles'
				// 'offset' => 1
				// 'orderby'	=> 'javascript',			
				// 'order'   => 'ASC'						
			]);

			if( $myposts ){
				foreach( $myposts as $post ){
					// переменную post передаем в ф-ю setup_postdata()
					setup_postdata( $post );
					?>
				
				<li class="article-item">	
					<a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
						<!-- <h4 class="article-title"><?php the_title(); ?></h4> -->
						<h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>
					</a>
					<img src="<?php echo get_the_post_thumbnail_url(null, 'homepage-thumb');?>" alt="">			
				</li>
				<?php 
				}
				} else {
					// Постов не найдено
					?> <p> Постов нет</p> <?php

				}
			wp_reset_postdata(); // Сбрасываем $post
		?>			
	</ul>
	<!-- /. article-list -->
	
	<div class="main-grid">
		<ul class="article-grid">
			<?php		
				global $post;
				// формируем запрос из БД - получаем 7 постов
				$query = new WP_Query( [
					'tag' => 'popular',
					'posts_per_page' => 7
				] );
				// проверяем есть ли посты
				if ( $query->have_posts() ) {
					// создаем переменную - счетчик постов
					$cnt = 0;
					// пока есть посты - выводим их
					while ( $query->have_posts())  {
						$query->the_post();
						// увеличиваем счетчик посто
						$cnt++;
						// echo $cnt;
						switch ($cnt) {
							// выводим 1 пост
							case '1':							
								?>
									<li class="article-grid-item article-grid-item-1">
										<a href="<?php the_permalink(); ?>" class="article-grid-permalink">
											<!-- вставляем фотку  -->
											<!-- <img class="article-grid-thumb" src="<?php echo get_the_post_thumbnail_url(null, 'homepage-thumb'); ?>" alt=""> -->

											<span class="category-name"><?php $category = get_the_category(); echo $category[0] -> name; ?></span>
											<!-- <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h4> -->
											
											<h4 class="article-grid-title"><?php echo get_the_title(); ?></h4>
											<p class="article-grid-excerpt">
												<?php echo mb_strimwidth(get_the_excerpt(), 0, 90, '...'); ?>
												
											</p>
											<!-- информация про автора  -->
											<div class="article-grid-info">
												<div class="author">
													<?php $author_id = get_the_author_meta('ID'); ?>
													<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">											
													<span class="author-name"><strong><?php the_author();?></strong>: <?php the_author_meta('description');?></span>
												</div>
												<!-- иконка и счетчик комментариев -->
												<div class="comments">
													<img src="<?echo get_template_directory_uri() . '/assets/images/comment.svg' ?>" alt="icon: comment" сlass="comments-icon">
													<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
												</div>		
											</div>
										</a>
									</li>
								<?php
								break;
							case '2':
								?>
									<li class="article-grid-item article-grid-item-2">
										<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="" class="article-grid-thumb">
										<a href="<?php the_permalink();  ?>" class="article-grid-permalink">
											<span class="tag">
												<!-- мета-тег Популярное -->
												<!-- <?php echo get_the_tag_list(); ?> -->
												<?php $posttags = get_the_tags();
													if ($posttags) {
														echo $posttags[0]->name . ' ';
													}
												?>
											</span>
											
											<span class="category-name"><?php $category = get_the_category(); echo $category[0] -> name; ?></span>
												<!-- <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>	 -->
											<h4 class="article-grid-title"><?php the_title(); ?></h4>
											

											<!-- информация про автора  -->
											<div class="article-grid-info">
												<div class="author">
													<?php $author_id = get_the_author_meta('ID'); ?>
													<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">

													<div class="author-info">
														<span class="author-name"><strong><?php the_author();?></strong></span>	
														<span class="date"><?php the_time('j F');?></span>

														<div class="comments">
															<img src="<?echo get_template_directory_uri() . '/assets/images/comment-white.svg' ?>" alt="icon: comment" class="comments-icon">
															<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
														</div>
														<div class="likes">
															<img src="<?php echo get_template_directory_uri() . '/assets/images/heart.svg' ?>" alt="icon: like" class="likes-icon">
															<span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
														</div>
													</div>
													<!-- /.author-info -->
												</div>
													<!-- /.author -->
											</div>
											
										</a>
									</li>
								<?php
								break;
							case '3':
								?>
									<li class="article-grid-item article-grid-item-3">
										<a href="<?php the_permalink(); ?>" class="article-grid-permalink">
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="article-thumb">									
											<h4 class="article-grid-title"><?php echo the_title() ?></h4>
										</a>
									</li>
								<?php
								break;
								// выводим остальные 4 поста
							default:
								?>
									<li class="article-grid-item article-grid-item-default">
										<a href="<?php the_permalink() ?>" class="article-grid-permalink">
											<h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 40, '...') ?></h4>										
											<p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 40, '...') ?></p>
											<span class="date"><?php the_time('j F Y') ?></span>
										</a>
									</li>
								<?php
								break;
						}
						?>
						<!-- Вывода постов, функции цикла: the_title() и т.д. -->
						<?php 
					}
				} else {
					// Постов не найдено
				}

				wp_reset_postdata(); // Сбрасываем $post
			?>	
		</ul>
		<!-- Подклаем сайдбар -->
		<?php get_sidebar(); ?>	
		<!-- <?php get_sidebar('lastpost-sidebar'); ?> -->
	</div>
	<!-- /. main-grid -->
</div>
<!-- /.container -->




