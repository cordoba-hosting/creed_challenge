<?php
/*
 Template Name: Custom Page for Challenge
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<div id="content podcast-background">

	<div id="inner-content" class="wrap">

		<main id="main" class="m-all" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<section class="" itemprop="articleBody">
						<?php
						// the content (pretty self explanatory huh)
						the_content();

						wp_link_pages(array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'bonestheme') . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						));
						?>
					</section>
				<?php endwhile;
			else : ?>

				<article id="post-not-found" class="hentry cf">
					<header class="article-header">
						<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e('This is the error message in the page-custom.php template.', 'bonestheme'); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</main>



	</div>

</div>


<?php get_footer(); ?>