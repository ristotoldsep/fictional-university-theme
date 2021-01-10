<?php get_header(); //THIS IS THE PROFESSOR SINGLE PAGE
    while(have_posts()) {
        the_post(); 
    
    pageBanner();
        
?>
        <div class="container container--narrow page-section">
            
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
                        <?php the_post_thumbnail('professorPortrait'); ?>
                    </div>
                    <div class="two-thirds">

                        <?php 
                            //Querying how many likes belong to the professor ID
                            $likeCount = new WP_Query(array(
                                'post_type' => 'like',
                                'meta_query' => array(
                                    array(
                                        'key' => 'liked_professor_id',
                                        'compare' => '=',
                                        'value' => get_the_ID()
                                    )
                                )
                            ));
                            // print_r($likeCount);

                            $existStatus = 'no'; //Has user liked the professor initial state //HEART ICON IS NOT FILLED

                            //Only if user is logged in, can the user see if he has liked the professor
                            if (is_user_logged_in()) {
                                   //This query will only output something if the current user has already liked the professor with this ID
                                $existQuery = new WP_Query(array(
                                    'author' => get_current_user_id(),
                                    'post_type' => 'like',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'liked_professor_id',
                                            'compare' => '=',
                                            'value' => get_the_ID()
                                        )
                                    )
                                ));
                            
                                if ($existQuery->found_posts) { //if the current user has liked the professor
                                    $existStatus = 'yes'; //HEART IS FILLED 
                                }
                            }

                         
                        ?>

                        <!-- LIKE COUNTER BOX-->
                        <span class="like-box" 
                        data-likeid="<?php echo $existQuery->posts[0]->ID; // id number of the like post that we want to delete , for toggling like status?>" 
                        data-professorid="<?php the_ID(); ?>" 
                        data-exists="<?php echo $existStatus; //YES or NO, filling the heart ICON ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                        </span>

                        <!-- Professor content -->
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <!-- DISPLAYING CUSTOM FIELDS!!!!!!!!!!!!!!!!!!!! -->
            <?php 
                //DONT NEED A CUSTOM QUERY, HERE I CAN USE DEFAULT QUERY!
                $relatedPrograms = get_field('related_programs');
                //print_r($relatedPrograms);

                if ($relatedPrograms) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
                echo '<ul class="link-list min-list">';
                foreach($relatedPrograms as $program) { ?>
                    <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
                    
                <?php } 
                echo '</ul>';
                }

            
            ?>
                
        </div>
        
    <?php }

 get_footer();?>