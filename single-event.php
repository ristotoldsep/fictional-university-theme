<?php get_header(); 
    while(have_posts()) {
        the_post(); 
       // print_r(get_field('page_banner_background_image'));
        
       // IF THERE IS A BG IMAGE INSERTED FROM DASHBOARD, PASS THAT TO FX, ELSE PASS DEFAULT EVENTS PIC
        if (get_field('page_banner_background_image')) { 
            $customPic = get_field('page_banner_background_image')['sizes']['pageBanner'];
            //print_r($customPic);
        } else {
            $customPic = get_theme_file_uri('/images/events.jpg');
        }

        pageBanner(array(
            'photo' => $customPic
        )); //DONT NEED ANY ARGUMENTS BECAUSE THE TITLE IS WORDPRESS DEFAULT
        ?>
       <!--  <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php //echo get_theme_file_uri('/images/events.jpg') ?>);"></div>
                <div class="page-banner__content container container--narrow">
                     <h1 class="page-banner__title"><?php //the_title(); ?></h1>
                        <div class="page-banner__intro">
                            <p>DONT FORGET TO REPLACE ME!!</p>
                        </div>
                </div>  
        </div> -->
        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); /* dynamic function, if we ever change url we don't also need to change it here*/?>"><i class="fa fa-home" aria-hidden="true"></i> Event Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>

            <div class="generic-content">
                <?php the_content( );?>
            </div>
            <!-- DISPLAYING CUSTOM FIELDS!!!!!!!!!!!!!!!!!!!! -->
            <?php 
                $relatedPrograms = get_field('related_programs');
                //print_r($relatedPrograms);

                if ($relatedPrograms) {
                    echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
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