<?php
/*
 *Template Name: Contact
 */
get_header(); ?>
  <div class="row columns contactForm">
    <?php              
    while (have_posts()) : the_post();                               
             the_content();                                                           
    endwhile;
    ?>
  </div>
  <div class="callout large secondary buttonBlock bottomFtSec">
    <!-- Job and Candidate Section -->
    <?php get_template_part( 'template-parts/job-candidate' ); ?>
  </div>
<?php get_footer(); ?>