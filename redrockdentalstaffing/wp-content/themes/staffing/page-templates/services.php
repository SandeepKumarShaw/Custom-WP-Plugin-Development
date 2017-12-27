<?php
/*
 *Template name: Services
 */
get_header();
//global $post;
if($post->post_content){ ?>
  <div class="row column" id="service_matches">
    <?php while(have_posts()){ the_post(); the_content(); } ?>
  </div>
<?php } ?>


<?php if( have_rows('business_matches_positions') ):?>
  <div class="row small-up-1 medium-up-2 large-up-2 businessList">
    <div class="column">
      <ul class="menu vertical">
        <?php if( have_rows('business_matches_positions') ):
       // $count=1;
	while ( have_rows('business_matches_positions') ) : the_row();
  //$count++;
	
  //echo $count;
	?>
        <li>
          <span class="float-left"><?php the_sub_field('dental_position_field_name');?></span>  
          <span class="float-right"><?php the_sub_field('dental_position_field_rate_per_day');?> per day</span>  
        </li>
        
         <?php endwhile; endif; ?>
      </ul>
    </div>
    <div class="column">
      <ul class="menu vertical">
        <?php if( have_rows('business_matches_positions') ):
       // $count=1;
	while ( have_rows('business_matches_positions') ) : the_row();
  //$count++;
	
  //echo $count;
	?>
        <li>
          <span class="float-left"><?php the_sub_field('dental_position_field_name');?></span>  
          <span class="float-right"><?php the_sub_field('dental_position_field_rate_per_month');?></span>  
        </li>
        
         <?php endwhile; endif; ?>
      </ul>
    </div>
    
  </div>
<?php endif; ?>

  <?php if( have_rows('for_job_seekers') ): ?>
    <div class="row column">
      <h3 class="title"><span>THE</span> BENEFITS</h3>
    </div>
    <div class="row small-up-1 medium-up-2 large-up-2 benefitList">
      <?php if( have_rows('for_job_seekers') ): ?>
	<div class="column">
	  <h3>For Job seekers</h3>
	  <ul class="menu vertical">
	     <?php //if( have_rows('for_job_seekers') ):
	   // $count=1;
	    while ( have_rows('for_job_seekers') ) : the_row();
      //$count++;
	    
      //echo $count;
	    ?>
	    <li> 
	      <?php the_sub_field('for_job_seekers_item');?> 
	    </li>
	    
	     <?php endwhile; ?>
	  </ul>
	</div>
      <?php endif;?>
      
      <?php if( have_rows('for_those_who_are_hiring') ):?>
	<div class="column">
	  <h3>For those who are hiring</h3>
	  <ul class="menu vertical">
	     <?php //if( have_rows('for_those_who_are_hiring') ):
	   // $count=1;
	    while ( have_rows('for_those_who_are_hiring') ) : the_row();
      //$count++;
	    
      //echo $count;
	    ?>
	    <li>
	      <?php the_sub_field('for_those_who_are_hiring_item');?>
	    </li>
	    
	     <?php endwhile; ?>
	  </ul>
	</div>
      <?php endif;?>
    </div>
  <?php endif; ?>
  <div class="callout large secondary buttonBlock bottomFtSec">
    <!-- Job and Candidate Section -->
    <?php get_template_part( 'template-parts/job-candidate' ); ?>
  </div>
<?php get_footer(); ?>
