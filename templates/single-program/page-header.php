<?php
/**
 * The template for displaying the single Program page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'link_terms' => true,
];

$pedalcms_args            = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_args['context'] = $template;

?>
<header class="single-program-page-header page-header entry-header">

	<?php pedalcms_get_template_part( 'common/page-header-backdrop' ); ?>

	<div class="page-header__content">
	<?php pedalcms_get_template_part( 'common/post-featured-image', $pedalcms_args ); ?>

	<div class="page-header__title-group">
		<h1 class="page-title entry-title">
		<?php the_title(); ?>
		</h1>
		<?php if ( taxonomy_exists( 'pedalcms_program_type' ) ) : ?>
		<div class="program-type taxonomy">
			<?php echo wp_kses_post( pedalcms_get_the_term_list( get_the_ID(), 'pedalcms_program_type', '', ', ', '', $pedalcms_args['link_terms'] ) ); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php pedalcms_get_template_part( 'single-program/program-meta' ); ?>
	<?php pedalcms_get_template_part( 'single-program/subnav' ); ?>
	</div>
</header><!-- .page-header -->
