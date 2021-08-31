<?php

function programs_shortcode($atts, $content = null)
{
  $atts = shortcode_atts(
    array(
      'college' => '',
      'format' => '',
      'level' => '',
      'paginate' => false,
    ),
    $atts,
    'programs'
  );
  $args = array(
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'post_type' => 'de_program',
    'order' => 'ASC',
    'orderby' => 'post_title',
  );
  if (!empty($_GET['search'])) {
    #$args['s'] = $_GET['search'];
    $args['meta_query'] = array(
      'relation' => 'OR',
      array(
        'key' => 'de_program_desc_short',
        'value' => $_GET['search'],
        'compare' => 'LIKE'
      ),
      array(
        'key' => 'de_program_desc',
        'value' => $_GET['search'],
        'compare' => 'LIKE'
      ),
      array(
        'key' => 'de_program_degree',
        'value' => $_GET['search'],
        'compare' => 'LIKE'
      )
    );
    $atts['paginate'] = false;
  }
  if ($atts['level']) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'de_program_levels',
        'field'    => 'slug',
        'terms'    => $atts['level'],
      ),
    );
  }
  if ($atts['format']) {
    $formats = array('online' => 2, 'onsite' => 3, 'hybrid' => 1);
    $args['meta_query'] = array(
      array(
        'key' => 'de_program_format',
        'value' => $formats[$atts['format']],
      )
    );
  }
  if ($atts['college']) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'de_program_colleges',
        'field'    => 'slug',
        'terms'    => $atts['college'],
      ),
    );
  }
  if ($atts['paginate']) {
    $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
    $posts_per_page = !empty($_GET['num']) ? intval($_GET['num']) : 5;
    $args['posts_per_page'] = $posts_per_page;
    $args['paged'] = $paged;
  } else {
    $args['posts_per_page'] = -1;
  }

  $priority = 10;
  add_filter('posts_where', 'programs_search_title_filter', $priority, 2);
  $query = new WP_Query;
  $programs = $query->query($args);
  remove_filter('posts_where', 'programs_search_title_filter', $priority);
  if ($atts['paginate']) {
    $paging = '<div style="margin-bottom: 20px;">View: ';
    $current = max(1, get_query_var('paged'));
    $url = explode('?', html_entity_decode(get_pagenum_link()));
    $pagelink = trailingslashit($url[0]);
    $pagequery = ($url[1]) ? '?' . $url[1] : '';
    $numquery = explode('&', $pagequery);
    if ($posts_per_page == 5) {
      $numlink = ($numquery[0]) ? $pagelink . $numquery[0] . '&num=-1' : $pagelink . '?num=-1';
      $paging .= '5 | <a href="' . $numlink . '">All</a>';
      $num_pages = $query->max_num_pages;
    } else {
      $numlink = ($numquery[0]) ? $pagelink . $numquery[0] : $pagelink;
      $paging .= '<a href="' . $numlink . '">5</a> | All';
      $num_pages = 1;
    }
    $paging .= ' - Page <strong>' . $current . '</strong> of ' . $num_pages;
    if ($current < $num_pages) {
      $next = $current + 1;
      $paging .= ' <a href="' . $pagelink . 'page/' . $next . '/' . $pagequery . '"><span class="glyphicon glyphicon-thin-arrow" aria-hidden="true"></span></a>';
    }
    $paging .= '</div>';
    $content .= $paging;
  }

  $upload_dir = wp_upload_dir();
  $formats = array(1 => '<span>Hybrid</span><img src="/wp-content/uploads/2016/06/hybrid_26x46.png">', 2 => '<span>Online</span><img src="/wp-content/uploads/2016/05/monitor_26x26.png">', 3 => '<span>Onsite</span><img src="/wp-content/uploads/2016/05/skyline_26x26.png">');
  foreach ($programs as $k => $post) {
    $image = get_post_meta($post->ID, '_de_program_small', true);
    $apply = get_post_meta($post->ID, 'de_program_apply', true);
    $image = ($image) ? $upload_dir['baseurl'] . '/programs/small/' . $image : $upload_dir['baseurl'] . '/programs/CALS.GradCertFeedScience.png';
    $format_key = get_post_meta($post->ID, 'de_program_format', true);
    $content .= '<div class="row"><div class="one_third"><a href="/program/' . $post->post_name . '/"><img class="img-responsive" src="' . $image . '" /></a></div>
	  <div class="one_half last">
		<h3 class="red"><a href="/program/' . $post->post_name . '/">' . get_the_title($post->ID) . ' <span aria-hidden="true" class="glyphicon glyphicon-roman-arrow"></span></a></h3>
		<h4>' . get_post_meta($post->ID, 'de_program_degree', true) . '</h4>
		<p class="prog-list">Delivery Format: <span><a href="/the-nc-state-difference/program-formats/">' . $formats[$format_key] . '</a></span></p>
		<p class="prog-list">Prerequisites: <span>Yes</span></p>';
    $exams = get_post_meta($post->ID, 'de_program_exams', true);
    if ($exams) $content .= '<p class="prog-list">Entrance Exam: <span>' . $exams . '</span></p>';
    $content .= '</div><div class="one_fifth last"><div class="" style="float:right;">
				<a class="btn btn-red normal" href="/program/' . $post->post_name . '/" style="background-color:#333;display:block;margin:0 0 5px;padding:5px;">Program&nbsp;Details<span aria-hidden="true" class="glyphicon glyphicon-thin-arrow"></span></a><a class="btn btn-red normal" href="/program/' . $post->post_name . '/#tabsPnl1-tab-3" style="background-color:#333;display:block;margin:0 0 5px;padding:5px;">&nbsp;&nbsp;Request&nbsp;Info<span aria-hidden="true" class="glyphicon glyphicon-thin-arrow"></span></a>' . ($apply ? '<a class="btn btn-red normal" href="' . esc_url($apply) . '" style="display:block;margin:0 0 5px;padding:5px;">&nbsp;&nbsp;APPLY&nbsp;NOW<span aria-hidden="true" class="glyphicon glyphicon-thin-arrow"></span></a>' : '') . '</div></div></div><div class="clearboth"></div>';
  }
  if ($atts['paginate']) {
    $content .= $paging;
  }

  return do_shortcode($content);
}
add_shortcode('programs', 'programs_shortcode');