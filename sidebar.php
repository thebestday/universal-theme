<?php

if ( ! is_active_sidebar( 'main-sidebar' ) ) {
	return;
}

// if ( ! is_active_sidebar( 'lastpost-sidebar' ) ) {
// 	return;
// }
?>

<aside id="secondary" class="sidebar-front-page">
	<?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside>




<!-- <aside id="secondary" class="sidebar-front-page">
	<?php dynamic_sidebar( 'lastpost-sidebar' ); ?>
</aside> -->