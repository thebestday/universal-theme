<?php get_header();?>

<div class="container">
	<h1 class="search-title">Результаты поиска по запросу:</h1>
	<div class="main-grid">
		<div class="digest-wrapper">
			<ul class="digest">
				<!-- Вывода постов, функции цикла: the_title() и т.д. -->
				<?php 
					if ( have_posts() ) { 
						while ( have_posts() ) { 
							the_post(); 
							?>
								<!-- <li>
									<a href="<?php echo get_the_permalink(); ?>">
										<h2><?php the_title(); ?></h2>
									</a>			
								</li> -->
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
										<!-- <button class="bookmark">				
											<svg width="14" height="18" fill="#BCBFC2" class="icon bookmark-icon">
												<use xlink:href="<?php echo get_template_directory_uri() ?> . /assets/images/sprite.svg#bookmark"></use>
											</svg>
										</button> -->

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
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11.1346 10.9998V13.9998L8.36064 10.9998H2.25C1.42157 10.9998 0.75 10.3282 0.75 9.49976V1.99976C0.75 1.17133 1.42157 0.499756 2.25 0.499756H12.75C13.5784 0.499756 14.25 1.17133 14.25 1.99976V9.49976C14.25 10.3282 13.5784 10.9998 12.75 10.9998H11.1346Z" arrow/>						
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
					} 
					else { ?> Записей нет. <?php }
				?>
				
			</ul>
			<?php
				$args = array(
					'prev_text' => '&larr; Назад',
					'next_text' => 'Вперед &rarr;',
				);
				the_posts_pagination($args)
			?>	
		</div>			
	<?php get_sidebar('home-bottom'); ?>	
	</div>
		
</div>

<?php get_footer();?>
