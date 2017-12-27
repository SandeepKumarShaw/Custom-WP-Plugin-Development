<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header('archive'); ?>
<div id="content" class="row blogPage">
  <div class="medium-8 columns">
   <?php if ( have_posts() ) : the_archive_title( '<h3 class="page-title">', '</h3>' ); endif;
    /* Start the Loop */
    while ( have_posts() ) : the_post();
    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
    $featuredImage=wp_get_attachment_image_src( $post_thumbnail_id,'blog_post_thumbnail',1);
    ?>
    <div class="blog-post">
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="callout">
          <ul class="menu simple">
            <li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">by <?php echo get_the_author(); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo get_the_date('M j, Y'); ?></a></li>
            <li><?php echo get_the_category_list(); ?></li>	
            <li><a href="<?php comments_link(); ?>"><?php comments_number( 'no Comments', 'One Comment', '% Comments' ); ?></a></li>
          </ul>
        </div>
        <?php if($post_thumbnail_id!=''){ ?>
            <img src="<?php echo $featuredImage[0]; ?>" class="thumbnail" alt="">
        <?php }else{ ?>
			<img src="<?php bloginfo('template_url');  ?>/img/no-image759x261.jpg" class="thumbnail" alt="">
		<?php } ?>
        <p><?php echo wp_trim_words(get_the_content(),45); ?></p>
    </div>
     <?php
     endwhile;  
     ?>
  </div>
        <div class="medium-4 columns">
         <div class="is-at-top is-stuck">
            <h4>Categories</h4>
            <ul>
			  <?php
			  $categories = get_categories();
			  if ( ! empty( $categories ) ) {
			  foreach( $categories as $category ) { ?>
              <li><a href="<?php echo get_category_link($category->term_id) ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo esc_attr( $category->name ); ?> (<?php echo esc_attr( $category->count ); ?>)</a></li>
              <?php } } ?>
            </ul>
            <h4>Top 5 Posts</h4>
            <ul>
			  <?php
			  $query2 = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 5, 'order' => 'DESC'));
			  while ( $query2->have_posts() ) : $query2->the_post(); 
			  $post_thumbnail_id1 = get_post_thumbnail_id(get_the_ID());
			  $featuredImage1=wp_get_attachment_image_src( $post_thumbnail_id1,'popular_blog_post_thumbnail',1); ?>
              <li>
                  <div class="media-object stack-for-small">
                  <div class="media-object-section">
                  <img class="thumbnail" src="<?php echo $featuredImage1[0]; ?>" alt="no-image">
                  </div>
                  <div class="media-object-section">
                  <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                  <p>by <?php echo get_the_author(); ?> | <?php echo get_the_date('M j, Y'); ?> | 		  
			<?php 
			    $postcats = get_the_category();
			    //print_r($postcats);
			    if ($postcats) {
			      $i=0;
			    ?>			    
			    <?php
			      foreach($postcats as $cat) {
				if($i != 0){
				  echo ",";
				}
			    ?>	
				<a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a>
			    <?php
			    $i++;
			      }
			    ?>			    
			    <?php
			    } 
			?>     
		  
		  | <?php comments_number( 'no Comments', 'One Comment', '% Comments' ); ?></p>
                  </div>
                  </div>
              </li>
              <?php endwhile; ?>
            </ul>
        </div>
    </div>
  </div>
  <div class="callout large secondary buttonBlock bottomFtSec">
    <!-- Job and Candidate Section -->
    <?php get_template_part( 'template-parts/job-candidate' ); ?>
  </div>


<?php get_footer();
