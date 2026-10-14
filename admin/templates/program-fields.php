<?php

defined( 'ABSPATH' ) || exit;

use PedalCMS\Core\Plugin;
use PedalCMS\Core\Program;
?>

<div class="pdl-program-fields-wrapper">
	<ul data-tabs>
		<li><a href="#overview"><?php echo esc_html( __( 'Main', 'pedal-cms' ) ); ?></a></li>
		<?php
		foreach ( self::$subpages as $pedalcms_slug => $pedalcms_args ) :
			if ( 'index' !== $pedalcms_slug ) :
				?>
		<li><a href="#<?php echo esc_attr( $pedalcms_slug ); ?>"><?php echo esc_html( $pedalcms_args['title'] ); ?></a></li>
					<?php
		endif;
endforeach;
		?>
	</ul>
	<div class="tab-content">
		<div id="overview">
			<h3><?php echo esc_html( __( 'Main', 'pedal-cms' ) ); ?></h3>
			Render fields here.
		</div>
		<?php
		foreach ( self::$subpages as $pedalcms_slug => $pedalcms_args ) :
			if ( 'index' !== $pedalcms_slug ) :
				?>
		<div id="<?php echo esc_attr( $pedalcms_slug ); ?>">
			<h3><?php echo esc_html( $pedalcms_args['title'] ); ?></h3>
			Render fields here.
		</div>
					<?php
		endif;
endforeach;
		?>
	</div>
</div>
