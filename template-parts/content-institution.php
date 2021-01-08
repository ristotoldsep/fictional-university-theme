<div class="post-item">
          <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

          <div class="generic-content">
            <?php the_excerpt(  );?> <!-- SHows just a little bit !!!!! -->
            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">View institution &raquo;</a></p> <!--  raquo adds arrows-->
          </div>
          
</div>