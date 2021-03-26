<?php

if ( ! is_active_sidebar( 'main-sidebar-top' ) ) {
	return;
}


?>

<aside id="secondary" class="sidebar-front-page">
	<?php dynamic_sidebar( 'main-sidebar-top' ); ?>
</aside>




