                <!-- =================================== -->
                <!-- DISPLAYING EVENTS LIST -->
                <!-- =================================== -->
             <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink();?>">
                    <span class="event-summary__month">
                      <?php 
                        //the_field('event_date', ); //TO ADD OUR CUSTOM FIELD DATE 
                        $eventDate = new DateTime(get_field('event_date')); //Creating new object that uses DateTime class as a blueprint
                        echo $eventDate->format('M'); //Looking inside that object and printing out 3 letter month
                      ?>
                    </span>
                    <span class="event-summary__day">
                      <?php 
                        echo $eventDate->format('d'); //Looking inside that object and printing out day number
                      ?>
                    </span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                    <p><?php 
                  if (has_excerpt()) { //If the post has handmade custom excerpt
                    echo get_the_excerpt(); //Display it
                  } else {
                    echo wp_trim_words(get_the_content(), 18); //first 18 words 
                  } ?> <a href="<?php the_permalink();?>" class="nu gray">Learn more</a></p>
                  </div> 
                </div>
                <!-- =================================== -->