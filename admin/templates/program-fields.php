<?php
use PedalCMS\Core\Plugin;
use PedalCMS\Core\Program;
?>

<div class="pdl-program-fields-wrapper">
	<ul data-tabs>
		<li><a href="#overview"><?php echo esc_html( __( 'Main', 'pedal-cms' ) ); ?></a></li>
		<?php
		foreach ( self::$subpages as $slug => $args ) :
			if ( 'index' !== $slug ) :
				?>
		<li><a href="#<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $args['title'] ); ?></a></li>
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
		foreach ( self::$subpages as $slug => $args ) :
			if ( 'index' !== $slug ) :
				?>
		<div id="<?php echo esc_attr( $slug ); ?>">
			<h3><?php echo esc_html( $args['title'] ); ?></h3>
			Render fields here.
		</div>
					<?php
		endif;
endforeach;
		?>
	</div>
</div>
