<?php 

function gridsby_admin_page_styles() {
    wp_enqueue_style( 'gridsby-font-awesome-admin', get_template_directory_uri() . '/fonts/font-awesome.css' ); 
	wp_enqueue_style( 'gridsby-style-admin', get_template_directory_uri() . '/panel/css/theme-admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'gridsby_admin_page_styles' );
     
    add_action('admin_menu', 'gridsby_setup_menu'); 
     
    function gridsby_setup_menu(){
            add_theme_page( __( 'Gridsby Theme Details', 'gridsby' ), __( 'Gridsby Theme Details', 'gridsby' ), 'edit_theme_options', 'gridsby-setup', 'gridsby_init' );
    } 
     
 	function gridsby_init(){
	 	echo '<div class="grid grid-pad"><div class="col-1-1"><h1 style="text-align: center;">';
		printf( __('Thank you for using Gridsby!', 'gridsby' ));
        echo "</h1></div></div>";
			
		echo '<div class="grid grid-pad" style="border-bottom: 1px solid #ccc; padding-bottom: 40px; margin-bottom: 30px;" ><div class="col-1-3"><h2>'; 
		printf( __('Gridsby Theme Setup', 'gridsby' ));
        echo '</h2>';
		
		echo '<p>';
		printf( __('We created a quick theme setup video to help you get started with Gridsby. Watch the video with the link below', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<a href="http://modernthemes.net/documentation/gridsby-documentation/gridsby-theme-setup/" target="_blank"><button>';
		printf( __('View Video', 'gridsby' )); 
		echo "</button></a></div>";
		
		echo '<div class="col-1-3"><h2>'; 
		printf( __('Documentation', 'gridsby' )); 
        echo "</h2>";  
		
		echo '<p>';
		printf( __('Check out our Gridsby documentation to learn how to use Gridsby and for tutorials on theme functions. Click the link below.', 'gridsby' ));  
		echo "</p>";
		
		echo '<a href="http://modernthemes.net/documentation/gridsby-documentation/" target="_blank"><button>';
		printf( __('Read Docs', 'gridsby' ));
		echo "</button></a></div>";
		
		echo '<div class="col-1-3"><h2>'; 
		printf( __('About ModernThemes', 'gridsby' ));
        echo '</h2>';  
		
		echo '<p>';
		printf( __('Want to learn more about ModernThemes? Let us help you at modernthemes.net.', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<a href="http://modernthemes.net/" target="_blank"><button>'; 
		printf( __('About Us', 'gridsby' )); 
		echo '</button></a></div></div>'; 
		
		echo '<div class="grid grid-pad senswp"><div class="col-1-1"><h1 style="padding-bottom: 30px; text-align: center;">';
		printf( __('Want more features? Go Pro.', 'gridsby' )); 
		echo '</h1></div>';
		
        echo '<div class="col-1-4"><i class="fa fa-shopping-cart"></i><h4>';
		printf( __('Sell Your Photos', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __('Make your website a powerful eCommerce machine. Gridsby Pro includes Easy Digital Downloads to turn photos into profit.', 'gridsby' ));
		echo '</p></div>';
		
        echo '<div class="col-1-4"><i class="fa fa-cogs"></i><h4>';
        printf( __('More Theme Options', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __('Control more options of your website including scroll animations and hover effects for your photos, as well as a home page slider template.', 'gridsby' ));
		echo '</p></div>'; 
		
        echo '<div class="col-1-4"><i class="fa fa-th"></i><h4>';
		printf( __('Home Gallery Options', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'Control the number of photos in your home page gallery. You can put up to 200 photos right on your front page for greater visbility.', 'gridsby' ));
		echo '</p></div> ';
            
        echo '<div class="col-1-4"><i class="fa fa-image"></i><h4>';
		printf( __( 'Footer Widget Areas', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'Want more content for your footer? Gridsby Pro has three footer widget areas to populate with any content you want.', 'gridsby' ));
		echo '</p></div></div>';
            
        echo '<div class="grid grid-pad senswp"><div class="col-1-4"><i class="fa fa-th-list"></i><h4>';
		printf( __( 'More Sidebars', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'Sometimes you need different sidebars for different pages. We got you covered, offering up to 5 different sidebars.', 'gridsby' ));
		echo '</p></div>';
		
       	echo '<div class="col-1-4"><i class="fa fa-font"></i><h4>More Google Fonts</h4><p>';
		printf( __( 'Access an additional 65 Google fonts with Gridsby Pro right in the back-end of the WordPress customizer.', 'gridsby' ));
		echo '</p></div>';
		
       	echo '<div class="col-1-4"><i class="fa fa-file-image-o"></i><h4>';
		printf( __( 'PSD Files', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'Premium versions include PSD files. Preview your own content or showcase a customized version for your clients.', 'gridsby' ));
		echo '</p></div>';
            
        echo '<div class="col-1-4"><i class="fa fa-support"></i><h4>';
		printf( __( 'Free Support', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'Call on us to help you out. Premium themes come with free support that goes directly to our support staff.', 'gridsby' ));
		echo '</p></div></div>';
		
		echo '<div class="grid grid-pad" style="border-bottom: 1px solid #ccc; padding-bottom: 50px; margin-bottom: 30px;"><div class="col-1-1"><a href="http://modernthemes.net/wordpress-themes/gridsby-pro/" target="_blank"><button class="pro">';
		printf( __( 'View Pro Version', 'gridsby' )); 
		echo '</button></a></div></div>';
		
		
		echo '<div class="grid grid-pad senswp"><div class="col-1-1"><h1 style="padding-bottom: 30px; text-align: center;">';
		printf( __('Premium Membership. Premium Experience.', 'gridsby' )); 
		echo '</h1></div>';
		
        echo '<div class="col-1-4"><i class="fa fa-cogs"></i><h4>'; 
		printf( __('Plugin Compatibility', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __('Use our new free plugins with this theme to add functionality for things like projects, clients, team members and more. Compatible with all premium themes!', 'gridsby' ));
		echo '</p></div>';
		
		echo '<div class="col-1-4"><i class="fa fa-desktop"></i><h4>'; 
        printf( __('Agency Designed Themes', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __('Look as good as can be with our new premium themes. Each one is agency designed with modern styles and professional layouts.', 'gridsby' ));
		echo '</p></div>'; 
		
        echo '<div class="col-1-4"><i class="fa fa-users"></i><h4>';
        printf( __('Membership Options', 'gridsby' ));
		echo '</h4>';
		
        echo '<p>';
		printf( __('We have options to fit every budget. Choose between a single theme, or access to all current and future themes for a year, or forever!', 'gridsby' ));
		echo '</p></div>'; 
		
		echo '<div class="col-1-4"><i class="fa fa-calendar"></i><h4>';
		printf( __( 'Access to New Themes', 'gridsby' )); 
		echo '</h4>';
		
        echo '<p>';
		printf( __( 'New themes added monthly! When you purchase a premium membership you get access to all premium themes, with new themes added monthly.', 'gridsby' ));   
		echo '</p></div>';
		
		
		echo '<div class="grid grid-pad" style="border-bottom: 1px solid #ccc; padding-bottom: 50px; margin-bottom: 30px;"><div class="col-1-1"><a href="https://modernthemes.net/premium-wordpress-themes/" target="_blank"><button class="pro">'; 
		printf( __( 'Get Premium Membership', 'gridsby' ));
		echo '</button></a></div></div>';
		
		
		echo '<div class="grid grid-pad"><div class="col-1-1"><h2 style="text-align: center;">'; 
		printf( __( 'Changelog' , 'gridsby' ) );
        echo "</h2>";
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.1.5 - 4.3 update bug fixes.', 'gridsby' )); 
		echo '</p>';
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.1.4 - minor bug fixes.', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.1.3 - added 500px social media option.', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.1.2 - updated Font Awesome icons.', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.1.1 - added Japanese and Brazilian language translation.', 'gridsby' )); 
		echo '</p>'; 
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.0.39 - updated Suggested Plugins files.', 'gridsby' ));
		echo '</p>'; 
		
		echo '<p style="text-align: center;">'; 
		printf( __('1.0.38 - minor menu bug fixes for category posts.', 'gridsby' ));
		echo '</p></div></div>'; 
		 	 
    }
?>