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
									<h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h4
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
					<img src="<?php echo get_the_post_thumbnail_url(null, 'homepage-thumb'); 
					?>" alt="">			
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
<!-- /.container -->




