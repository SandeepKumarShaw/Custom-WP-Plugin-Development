<?php
/*
 *Template Name: Home
 */
get_header(); ?>

  <div class="row column">
    <?php
    //the content of about page
    $the_query = new WP_Query( 'page_id=9' );                               
    while ($the_query -> have_posts()) : $the_query -> the_post();                               
             the_content();                                                           
    endwhile;
    ?>
  </div>
  <div class="row small-up-1 medium-up-2 large-up-2 learnBlock">
    <?php if(get_field('need_job_links',4)){ ?>
    <div class="column">
      <div class="callout boxBlock">
        <h2 class="boxBg"><?php echo get_field('need_job_heading',4); ?></h2>
        <div class="contentBlock">
          <ul><?php echo get_field('need_job_links',4); ?></ul>
          <?php echo get_field('more_link',4); ?>
        </div>
      </div>
    </div>
    <?php } if(get_field('need_asistant_links',4)){ ?>
    <div class="column">
      <div class="callout boxBlock">
        <h2 class="boxBg"><?php echo get_field('need_asistant_heading',4); ?></h2>
        <div class="contentBlock">
          <ul><?php echo get_field('need_asistant_links',4); ?></ul>
          <?php echo get_field('asistant_more_link',4); ?>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="callout large secondary buttonBlock">
    <!-- Job and Candidate Section -->
    <?php get_template_part( 'template-parts/job-candidate' ); ?>
  </div>
  <div class="row small-up-2 large-up-3 chartBlock">
    <div class="column">
      <div class="rotateBox"><span>87%</span></div>
      <p class="lead">MATCH <span>RATE</span></p>
    </div>
    <div class="column">
      <div class="rotateBox"><span>18%</span></div>
      <p class="lead">YEARLY INDUSTRY <span>GROWTH</span></p>
    </div>
    <div class="column">
      <div class="rotateBox"><span>100%</span></div>
      <p class="lead">24/7 ACCESS <span>TO OPPORTUNITIES</span></p>
    </div>
  </div>
  <div class="row column">
    <a class="button centerButton" href="<?php echo site_url().'/about/';?>">SEE HOW WE DO IT</a>
  </div>
  <div class="callout large secondary sliderBlock">
    <div class="row">
    <div class="medium-9 columns">
      <div class="owl-carousel owl-theme">
        <?php //wp_customer review custom post type
          $args = array( 'post_type' => 'wpcr3_review','posts_per_page' => 4);
          $the_query = new WP_Query( $args );
          if ( $the_query->have_posts() ) :
          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
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
              <p>"<?php echo wp_trim_words(get_the_content(),30); ?>"</p>
              <span>- <?php the_field('wpcr3_review_name'); ?></span>
        </div>
        <?php endwhile; else : endif; wp_reset_query(); ?>
      </div>
    </div>
    <div class="medium-3 columns"></div>
  </div>
  </div>
  <div class="row column formCont">
    <h2 class="formtitle"><?php echo get_field('newsletter_title'); ?></h2>
    <p><?php echo get_field('newsletter_sub_title'); ?></p>
  </div>
  <div class="row small-up-1 medium-up-2 large-up-3 homeForm">
    <?php echo do_shortcode(get_field('newsletter_form_shortcode')); ?>
  </div>
<?php get_footer(); 
