			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">

					<div class="social-icons footer-social">
		           		<?php echo simplyread_social_icons(); ?>
                	</div> <!-- social-icons-->

					<p class="source-org copyright">
						 &#169; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> 
						<span><?php if(is_home()): ?>
							- <a href="http://wordpress.org/" target="_blank">Powered by WordPress</a> and <a href="http://wpsimplyread.com/" target="_blank">WP Simply Read</a> 
						<?php endif; ?>
						</span>
					</p>

				</div>

			</footer>

		</div>

		<?php wp_footer(); ?>
	</body>

</html> <!-- end of site. what a ride! -->