<?php
/*
 *Template name: Reviews
 */
get_header(); 
?>
<div class="row column">
    <div class="review-page">
         <?php //while(have_posts()){ the_post(); the_content(); } ?>
        <?php echo do_shortcode('[WPCR_SHOW POSTID="123" SHOWFORM="1" ]'); ?>
        <?php //wp_customer review custom post type
           $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	  $loop = new WP_Query(array('post_type' => 'wpcr3_review','posts_per_page' => 2, 'paged' => $paged));
          if ( $loop->have_posts() ) :
          while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="item">
          <h3><?php the_title(); ?></h3>
          <?php $count_star=get_field('wpcr3_review_rating'); ?>
              <div class="ratingBlock">
              <?php for($i=0;$i<$count_star;$i++){ ?>
              <img src="<?php bloginfo('template_url');  ?>/img/rating1.png" alt="no-image">
              <?php } for($i=$count_star;$i<5;$i++){ ?>
              <img src="<?php bloginfo('template_url');  ?>/img/rating2.png" alt="no-image">
              <?php } ?>
              </div>
              <p>"<?php echo get_the_content(); ?>"</p>
              <span>- <?php the_field('wpcr3_review_name'); ?></span>
        </div>
        <?php endwhile; else : endif; wp_reset_query();
         wp_pagenavi( array( 'query' => $loop ) );
        ?>
      </div>
</div>
<?php get_footer(); ?>