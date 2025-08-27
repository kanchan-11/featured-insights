<div class="featured-insights owlslider">
<section id="slider">
  <div class="container">
	  <div class="slider">
				<div class="owl-carousel">
                <?php
            
        $atts = shortcode_atts([
            'category' => '', 
            'type' => 'post', 
            'id' => ''
        ], $atts, 'featured_insights'); 

        $args = [
            'post_status' => 'publish',
            'post_type'   => 'post',
        ];

        if (!empty($atts['category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $atts['category']),
                ],
            ];
        } 
        if (!empty($atts['id'])) {
            $args['post__in'] = explode(',', $atts['id']); 
        }
        $my_query = new WP_Query($args);
                    
        if ($my_query->have_posts()) :
            while ($my_query->have_posts()) :
                $my_query->the_post();

                $terms = get_the_terms(get_the_ID(), 'post_type_category'); 
                $taxonomy_term = 'none';
                if ($terms && !is_wp_error($terms)) {
                    $taxonomy_term = $terms[0]->name; 
                }
            ?>
			<div class="insights-featured"><a class="" href="<?php echo esc_url(get_permalink()); ?>">         
                <div class="whole-card-cta"><img class=" manual-lazy-load" data-src="<?php echo has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')) : '/wp-content/uploads/2025/01/placeholder_azure.jpg'; ?>" alt="Insight Illustration" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 34 25'%3E%3C/svg%3E"></div>
                <p class="insights-featured-head smaller-size"><?php echo esc_html($taxonomy_term); ?></p>
                <div class="insights-featured-content">
                    
                        <h3 class="insights-featured-text smaller-size"><?php echo esc_html(get_the_title()); ?></h3>
                        <a class="insights-featured-cta smallest-size font-bold underline-on-hover service-button-cta" href="<?php echo esc_url(get_permalink()); ?>"><span>Read more</span></a>
                    </div>
                </div></a>
                <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
		    </div>
		</div>
    </div>
</section>
</div>