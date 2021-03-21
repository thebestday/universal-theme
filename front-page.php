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
									<!-- <?php printf('Во дворе стоит %s,а на не висит %s. Его есть %s', 'дерево', 'яблоко', 'Вова'); ?> -->
									<!-- <?php the_category(); ?> -->
									<!-- ВОЛШЕБНАЯ КОНСТРУКЦИЯ -->
									<?php 
										foreach ( get_the_category() as $category) {
											printf(
												'<a href="%s" class="category-link %s">%s</a>', 
												esc_url(get_category_link( $category ) ), 
												esc_html($category -> slug ), 
												esc_html($category -> name ),
											);
										}									
									?>

									
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
								<!-- <?php the_category() ?> -->
								<!-- ВОЛШЕБНАЯ КОНСТРУКЦИЯ вместо того что выше -->
								<?php 
									foreach ( get_the_category() as $category) {
										printf(
											'<a href="%s" class="category-link %s">%s</a>', 
											esc_url(get_category_link( $category ) ), 
											esc_html($category -> slug ), 
											esc_html($category -> name ),
										);
									}									
								?>

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

<!-- 4 + 7 container -->
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
				<!-- Выводим записи -->
				<li class="article-item">	
					<a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
						<!-- <h4 class="article-title"><?php the_title(); ?></h4> -->
						<h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>
					</a>
					<img src="<?php						
						if(has_post_thumbnail() ){
							echo get_the_post_thumbnail_url(null, 'homepage-thumb');																
						} 
						else {
							echo get_template_directory_uri(). '/assets/images/img-default.png';
						}
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
	<!-- /. article-list -->
	
	<div class="main-grid">
		<ul class="article-grid">
			<?php		
				global $post;
				// формируем запрос из БД - получаем 7 постов
				$query = new WP_Query( [
					'tag' => 'popular',
					'posts_per_page' => 7,
					'category_not_in' => 35
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

													<svg width="19" height="15" fill="#BCBFC2" class="icon comments-icon">
														<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#comment"></use>
													</svg>

													<!-- <img src="<?echo get_template_directory_uri() . '/assets/images/comment.svg' ?>" alt="icon: comment" сlass="comments-icon"> -->
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
										<img src="<?php 
												if(has_post_thumbnail() ){
													echo get_the_post_thumbnail_url();																							
												} 
												else {
													echo get_template_directory_uri(). '/assets/images/img-default.png';
												}										
												?>" alt="" class="article-grid-thumb">
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
															<!-- <img src="<?echo get_template_directory_uri() . '/assets/images/comment-white.svg' ?>" alt="icon: comment" class="comments-icon"> -->
															
															<svg width="19" height="15" fill="#fff" class="icon comments-icon">
																<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#comment"></use>
															</svg>

															<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
														</div>
														<div class="likes">

															<svg width="19" height="15" fill="#BCBFC2" class="likes-icon">
																<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#heart"></use>
															</svg>


															<!-- <img src="<?php echo get_template_directory_uri() . '/assets/images/heart.svg' ?>" alt="icon: like" class="likes-icon"> -->

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
											<img src="<?php  
												if(has_post_thumbnail() ){
													echo get_the_post_thumbnail_url();																							
												} 
												else {
													echo get_template_directory_uri(). '/assets/images/img-default.png';
												}								
											
											?>" alt="" class="article-thumb">

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
											<h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 25, '...') ?></h4>										
											<p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 75, '...') ?></p>
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
		<!-- Подключаем сайдбар -->

		<!-- Переименовали сайдбар -->
		<!-- ПОДКЛЮЧАЕМ ВЕРХНИЙ САЙДБАР -->
		<?php get_sidebar('home-top'); ?>
		
				
	</div>
	<!-- /. main-grid -->
</div>
<!-- /. 4 + 7 container -->



<!-- статья про раследования investigation -->

<div class="invest">
	<?php		
		global $post;

		$query = new WP_Query( [
			'posts_per_page' => 1,
			'category_name'  => 'investigation'
		] );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
					<section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.45), rgba(64, 48, 61, 0.45)), url(<?php 
					if(has_post_thumbnail() ){
						echo get_the_post_thumbnail_url();																
					} 
					else {
						echo get_template_directory_uri(). '/assets/images/img-default.png';
					}
					?>) no-repeat center">
						<div class="container">
							<h2 class="investigation-title"><? the_title(); ?></h2>
							<a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
						</div>
					</section>
				<?php 
			}
		} else {
			// Постов не найдено
		}

		wp_reset_postdata(); // Сбрасываем $post
	?>
		
</div>
<!-- /.investigation -->


<!-- шесть статей -->

<div class="container">
	<div class="main-grid">
		<div class="digest-wrapper">
			<ul class="digest">
				<?php
					$myposts = get_posts([ 
						'numberposts' => 6,
						'category_name' => 'news, opinions, collections, hotter',
						'order'   => 'ASC'
					]); 
						// Проверка постов
					if( $myposts ){
						// Если есть, запускаем цикл
						foreach( $myposts as $post ){
							setup_postdata( $post );
							?>
								<li class="digest-item">
									<a href="<?php the_permalink() ?>" class="digest-item-permalink">

										<img src="<?php 
											if(has_post_thumbnail() ){
												echo get_the_post_thumbnail_url();
												
											} 
											else {
												echo get_template_directory_uri(). '/assets/images/img-default.png';
											}
											?>" class="digest-thumb">
										
									</a>
                                

									<div class="digest-info">
										<button class="bookmark">						

											<svg width="14" height="18" fill="#BCBFC2" class="icon bookmark-icon">
												<use xlink:href="<?php echo get_template_directory_uri() ?> . /assets/images/sprite.svg#bookmark"></use>
											</svg>


										</button>
										<? $category = get_the_category(); ?>
										<a href="<?php echo $category[0]->name ?>" class="category-link"><? echo $category[0]->name ?></a>
										<a href="#" class="digest-item-permalink">
											<h3 class="digest-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?></h3>
										</a>
										<p class="digest-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...') ?></p>
										<div class="digest-footer">
											<span class="digest-date"><?php the_time('j F') ?></span>
											
											<div class="comments digest-comments">
												<!-- <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11.1346 10.9998V13.9998L8.36064 10.9998H2.25C1.42157 10.9998 0.75 10.3282 0.75 9.49976V1.99976C0.75 1.17133 1.42157 0.499756 2.25 0.499756H12.75C13.5784 0.499756 14.25 1.17133 14.25 1.99976V9.49976C14.25 10.3282 13.5784 10.9998 12.75 10.9998H11.1346Z" fill="#BCBFC2"/>						
												</svg> -->

												<svg width="15" height="14" class="icon comments-icon">
													<use xlink:href="<?php echo get_template_directory_uri() ?> . /assets/images/sprite.svg#comment"></use>
												</svg>

												<span class="comments-counter"><?php comments_number( '0', '1', '%') ?></span>
											</div>
											

											<div class="likes digest-likes">
												<!-- <img src="<?php echo get_template_directory_uri() ?> . /assets/images/heart-grey.svg" alt="icon: like" class="likes-icon"> -->

											

												<svg width="19" height="15" fill="#BCBFC2" class="likes-icon">
													<use xlink:href="<?php echo get_template_directory_uri() ?>. /assets/images/sprite.svg#heart"></use>
												</svg>

												<span class="likes-counter"><?php comments_number( '0', '1', '%') ?></span>
											</div>
										</div>
										<!-- /.digest-footer -->
									</div>
									<!-- /.digest-info -->
								</li>
							<?php 
						}
					} else {
						?><p>
								Постов нет
						</p> <?php
					}

					wp_reset_postdata(); // Сбрасываем $post
					
				?>
				
			</ul>
		
		</div>
	
		<?php get_sidebar('home-bottom'); ?>		
	</div>	

</div>	

<!-- /. шесть статей -->


<!-- special photorubrica 1 + 1 +2  -->
<div class="special">
	<div class="container">
		<div class="special-grid">
			<?php		
				global $post;

				$query = new WP_Query( [
					'posts_per_page' => 1,
					'category_name'  => 'photo-report'
				] );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						?>
							<div class="photo-report">

								<!-- Slider main container -->
								<div class="swiper-container photo-report-slider">
									<!-- Additional required wrapper -->
									<div class="swiper-wrapper">
										<!-- Slides -->
										<?php $images = get_attached_media( 'image' ); 
											foreach ($images as $image) {										
												echo '<div class="swiper-slide"><img src="';
												print_r($image -> guid);
												echo '"></div>';
											}																
										?>

									</div>
									<!-- If we need pagination -->
									<div class="swiper-pagination"></div>

								</div>


								<!-- photo-report-content			 -->
								<div class="photo-report-content">
									<!-- <a href="#" class="category-name">Название категории</a> -->		
									<!-- ВОЛШЕБНАЯ КОНСТРУКЦИЯ вместо того что выше -->
									<?php 
										foreach ( get_the_category() as $category) {
											printf(
												'<a href="%s" class="category-link">%s</a>', 
												esc_url(get_category_link( $category ) ),												 
												esc_html($category -> name ),
											);
										}									
									?>

									<!-- Вывод заголовка текущей записи и миниатюры -->	
									<!-- athor -->									
									<?php $author_id = get_the_author_meta('ID'); ?>		
									<a href="<?php echo get_author_posts_url( $author_id); ?>" class="author">
										<img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
										<div class="author-bio">
											<span class="author-name"><?php the_author() ?></span>
											<span class="author-rank">Должность</span>						
										</div>
									</a>

									<h3 class="photo-report-title"><?php the_title()?></h3>
									<a href="<?php echo get_the_permalink() ?>" class="button photo-report-button">

										<svg width="19" height="15" class="icon photo-report-icon">
											<use xlink:href="<?php echo get_template_directory_uri() ?> . /assets/images/sprite.svg#images"></use>
										</svg>
										
											Смотреть фото
										<span class="photo-report-counter"><?php echo count($images) ?></span>
									</a>				
									<!-- /.athor -->

								</div>
								<!-- /. photo-report-content -->					
																
							</div>
							<!-- /. photo-report -->
						<?php 
					}
				} else {
					// Постов не найдено
				}

				wp_reset_postdata(); // Сбрасываем $post
			?>

			<div class="other">
				<?php		
					global $post;

					$query = new WP_Query( [
						'posts_per_page' => 1,
						'category_name'  => 'career'
					] );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							?>
								<div class="career-post">	
									<span class="category-link"><?php $category = get_the_category(); echo $category[0] -> name; ?></span>

									<h4 class="career-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 40, '...') ?></h4>

									<p class="career-post-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 40, '...') ?></p>	
									<a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
								</div>
						
								
							<?php 
						}
					} else {
						// Постов не найдено
					}

					wp_reset_postdata(); // Сбрасываем $post
				?>
				<?php		
					global $post;

					$query = new WP_Query( [
						'posts_per_page' => 2,
						'category_name'  => 'articles'
					] );

					if ( $query->have_posts() ) {
						$cn = 0;
						while ( $query->have_posts() ) {
							$query->the_post();
							$cn++;
							switch($cn) {
								case '1':
										?>
																	
											<div class="other-post">
												<div class="parent-item-1">
													<a href="<?php the_permalink() ?>" class="permalink">
														<h4 class="title"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...') ?></h4>										
														<p class="excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 20, '...') ?></p>
														<span class="date"><?php the_time('j F Y') ?></span>
													</a>
												</div>

												
											</div>
											
										<?php 
									break;
								case '2':
										?>
	
											<div class="other-post">
												<div class="parent-item-2">
													<a href="<?php the_permalink() ?>" class="permalink">
														<h4 class="title"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...') ?></h4>										
														<p class="excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 20, '...') ?></p>
														<span class="date"><?php the_time('j F Y') ?></span>
													</a>
												</div>						

											

											</div>

											
										<?php 
									break;
							}

						}
					} else {
						// Постов не найдено
					}

					wp_reset_postdata(); // Сбрасываем $post
				
				?>

			</div>
				<!-- /. other		 -->
	
		
		</div>
		<!-- /.special-grid -->
	</div>
</div>
<!-- /. special photorubrica 1 +1 + 2-->

<?php wp_footer(); ?>

