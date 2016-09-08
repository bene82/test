<?php get_header(); ?>


<?php
if (function_exists('category_image_src')) {
$category_image = category_image_src( array( 'size' => 'full' ) , false );
} else {
$category_image = ''; 
}
?>
<div class="slider" style="background: url('<?php echo $category_image; ?>') center/cover no-repeat;"></div>
</div>


<div class="container">
<div class="breadcrumb">
<?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>
</div>
<div class="row content">
	<div class="col-md-3 sidebar">
		<ul class="category_list">
		<?php 
		$category = get_terms('product_category', array('hide_empty' => false));
		//var_dump($category);
		if($category){
			$current_cat = ($category[0]->term_id);
		} else {
			$current_cat = '';
		}
		$categorie = get_terms(array(
			'taxonomy' => 'product_category',
			'hide_empty' => false,
			'parent' => 0
		));
		
		//$cat_parent = get_terms('product_category', array('hide_empty' => false, 'parent'=>(get_queried_object()->term_id)));
		$cat_parent = (get_ancestors( (get_queried_object()->term_id), 'product_category' ));
		//echo $cat_parent[0];
		
		foreach($categorie as $categoria){
			$active = '';
			$subcats = get_terms(array(
				'taxonomy' => 'product_category',
				'parent' => $categoria->term_id,
				'hide_empty' => false
				
			));
			
			if(get_query_var('product_category') == $categoria->slug){
				$active = 'active';
			}
			
			$active_parent = '';
			if($cat_parent){
				if($cat_parent[0] == $categoria->term_id){
					$active_parent = 'active';
				}
			}	
			/* 
			var_dump($cat_parent[0]);
			var_dump($categoria->term_id);
				 */
			echo '<li class="'.$active.' '.$active_parent.'"><a class="'.$active.' '.$active_parent.'" href="'.get_category_link( $categoria->term_id ).'">'.$categoria->name.'</a>';
			
			if($subcats){
				echo '<ul class="subcats">';
				foreach($subcats as $subcat){
					$active = '';
					$my_subcats = get_terms('product_category', array(
						'hide_empty' => false,
						'parent' => $subcat->parent
					));
					$current_subcat = get_query_var('product_category');
					
					if($current_subcat == $subcat->slug){
						$active = 'active';
					} 
					echo '<li><a class="'.$active.'" href="'.get_category_link( $subcat->term_id ).'">'.$subcat->name.'</a></li>';
				}
				echo '</ul>'; 
			}
			
			echo '</li>';
		}
		?>
		<?php
		 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar')) : //  Sidebar name
		?>
		<?php
		     endif;
		?>
		</ul>
	</div>
	<div class="col-md-8 col-md-offset-1">

		<?php if(have_posts()) : ?>
		   <?php while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="col-md-4 product_container" <?php post_class(); ?> >
				<div class="cover">
				<a href="<?php echo get_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) { // controlla se il post ha un'immagine in evidenza assegnata.
					  the_post_thumbnail('blog-thumb', array( 'class' => 'img-responsive' ));
					} ?>
					</div>
				</a>
				<div class="content">
					<a href="<?php echo get_permalink(); ?>">
						<?php the_title('<h3 class="title">','</h2>'); ?>
					</a>
		 		</div>
			</div>
			
		   <?php endwhile; ?>

		<?php else: ?>
			<h3>No results</h3>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>