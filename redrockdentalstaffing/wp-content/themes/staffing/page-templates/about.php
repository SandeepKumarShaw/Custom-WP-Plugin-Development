<?php
/*
 *Template Name: About
 */
get_header(); ?>

  <div class="row column">
    <?php while(have_posts()){ the_post(); the_content(); } ?>
  </div>
  <!-- Services Section -->
  <div class="row column small-up-2 large-up-3 chartBlock aboutChart">
    <h3 class="title"><?php echo get_field('service_title'); ?></h3>
	<?php if( have_rows('services_list_section') ): 
	while ( have_rows('services_list_section') ) : the_row();
	$attachment_id = get_sub_field('service_image');
	$custom_feature = wp_get_attachment_image_src( $attachment_id, "what_we_do_img" );
	?>
    <div class="column">
      <div class="rotateBox"><span><img src="<?php echo $custom_feature[0]; ?>" alt="no-image"></span></div>
      <p class="lead"><?php  the_sub_field('service_text'); ?></p>
    </div>
    <?php endwhile; endif; ?>
  </div>
  <!-- Services Section -->
  <div class="callout large secondary buttonBlock">
    <!-- Job and Candidate Section -->
    <?php get_template_part( 'template-parts/job-candidate' ); ?>
  </div>

  <!-- Team Member Section -->
  <?php /*
  <div class="row column small-up-2 large-up-3 teamList">
    <h3 class="title"><span>Meet</span> Our team</h3>
	<?php $args = array( 'post_type' => 'our_team');
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
	$featuredImage=wp_get_attachment_image_src( $post_thumbnail_id,'member_thubmail',1);
	?>
    <div class="column">
      <div class="imgBox"><span>
	  <?php if($post_thumbnail_id!=''){ ?>
             <img src="<?php echo $featuredImage[0]; ?>" alt="">
        <?php }else{ ?>
			<img src="<?php bloginfo('template_url');  ?>/img/no-image335x383.jpg" alt="">
		<?php } ?>
	  </span></div>
      <p class="lead"><?php the_title(); ?> <span><?php echo get_field('member_designation'); ?></span></p>
    </div>
	<?php endwhile; endif; ?>
  </div>
  */?>
  <!-- Team Member Section -->
<?php get_footer(); ?>