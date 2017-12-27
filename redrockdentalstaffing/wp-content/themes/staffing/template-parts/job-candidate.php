<div class="row">
    <!--<div class="button-area">
      <a href="#">SEARCH JOBS</a>
      <a href="#">SEARCH CANDIDATES</a>
    </div>-->
    <?php
    /********get  current user role*********/
    $current_user   = wp_get_current_user();
    $role_name      = $current_user->roles[0];
    ?>
    
    <?php if( have_rows('job_candidate', 'option') ): ?>

        <div class="button-area">
        <?php while( have_rows('job_candidate', 'option') ): the_row(); ?>
            <?php $user_type = get_sub_field('user_type'); //print_r($user_type); ?>
            
            <?php if($role_name == $user_type[0] || $role_name == $user_type[1]){ ?>
                <a href="<?php the_sub_field('job_candidate_classification_link'); ?>"><?php the_sub_field('job_candidate_classification_title'); ?></a>
            <?php } ?>
        <?php endwhile; ?>
    
        </div>

<?php endif; ?>



</div>
