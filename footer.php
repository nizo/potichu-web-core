		<?php
		global $avia_config;
		$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

		//reset wordpress query in case we modified it
		wp_reset_query();


		//get footer display settings
		$the_id 				= avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
		$footer 				= get_post_meta($the_id, 'footer', true);
		$footer_widget_setting 	= !empty($footer) ? $footer : avia_get_option('display_widgets_socket');


		//check if we should display a footer
		if(!$blank && $footer_widget_setting != 'nofooterarea' )
		{
			if( $footer_widget_setting != 'nofooterwidgets' )
			{
				//get columns
				$columns = avia_get_option('footer_columns');
		?>
				<div class='container_wrap footer_color' id='footer'>

					<div class='container'>

						<?php
						do_action('avia_before_footer_columns');

						//create the footer columns by iterating

						
				        switch($columns)
				        {
				        	case 1: $class = ''; break;
				        	case 2: $class = 'av_one_half'; break;
				        	case 3: $class = 'av_one_third'; break;
				        	case 4: $class = 'av_one_fourth'; break;
				        	case 5: $class = 'av_one_fifth'; break;
				        	case 6: $class = 'av_one_sixth'; break;
				        }
				        
				        $firstCol = "first el_before_{$class}";

						//display the footer widget that was defined at appearenace->widgets in the wordpress backend
						//if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
						for ($i = 1; $i <= $columns; $i++)
						{
							$class2 = ""; // initialized to avoid php notices
							if($i != 1) $class2 = " el_after_{$class}  el_before_{$class}";
							echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
							if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - column'.$i) ) : else : avia_dummy_widget($i); endif;
							echo "</div>";
							$firstCol = "";
						}

						do_action('avia_after_footer_columns');

						?>


					</div>


				<!-- ####### END FOOTER CONTAINER ####### -->
				</div>

	<?php   } //endif nofooterwidgets ?>



			

			<?php

			//copyright
			$copyright = do_shortcode( avia_get_option('copyright', "&copy; ".__('Copyright','avia_framework')."  - <a href='".home_url('/')."'>".get_bloginfo('name')."</a>") );

			// you can filter and remove the backlink with an add_filter function
			// from your themes (or child themes) functions.php file if you dont want to edit this file
			// you can also just keep that link. I really do appreciate it ;)			


			//you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
			if($copyright && strpos($copyright, '[nolink]') !== false)
			{
				$kriesi_at_backlink = "";
				$copyright = str_replace("[nolink]","",$copyright);
			}

			if( $footer_widget_setting != 'nosocket' )
			{

			?>

				<footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
                    <div class='container'>

                        <span class='copyright'><?php echo $copyright; ?></span>

                        <?php
                        	if(avia_get_option('footer_social', 'disabled') != "disabled")
                            {
                            	$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
								echo avia_social_media_icons($social_args, false);
                            }
                        
                            echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
                                $avia_theme_location = 'avia3';
                                $avia_menu_class = $avia_theme_location . '-menu';

                                $args = array(
                                    'theme_location'=>$avia_theme_location,
                                    'menu_id' =>$avia_menu_class,
                                    'container_class' =>$avia_menu_class,
                                    'fallback_cb' => '',
                                    'depth'=>1
                                );

                                wp_nav_menu($args);
                            echo "</nav>";
        
                        ?>

                    </div>

	            <!-- ####### END SOCKET CONTAINER ####### -->
				</footer>


			<?php
			} //end nosocket check


		
		
		} //end blank & nofooterarea check
		?>
		<!-- end main -->
		</div>
		
		<?php
		//display link to previeous and next portfolio entry
		echo avia_post_nav();

		echo "<!-- end wrap_all --></div>";


		if(isset($avia_config['fullscreen_image']))
		{ ?>
			<!--[if lte IE 8]>
			<style type="text/css">
			.bg_container {
			-ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
			}
			</style>
			<![endif]-->
		<?php
			echo "<div class='bg_container' style='background-image:url(".$avia_config['fullscreen_image'].");'></div>";
		}
	?>


<?php




	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */


	wp_footer();


?>


	<?	
	global $singleMaterialPage;	
		
	if ($singleMaterialPage) { 
	
		$graphTypeID = get_post_meta( get_the_ID(), 'header_title_bar', true);								
		$graphTypeID = get_the_excerpt();
		
		if (($graphTypeID) != '')
			$graphTypeID = 2;
		else
			$graphTypeID = 1;
			
		//echo $graphTypeID;		
				
		?>
		
		<script>
		window.onload = function() {		
			setTimeout(renderData, 50);			
		}();

		function renderData() {
			jQuery.get("../../../materials-efficiency-data.csv", function(csvString) {

			var lines = csvString.split('\n');		
			var headingElements = lines[0].split(',');		
			var loadedDatasets = [];
			
			var materialName = '<?php echo get_the_title(); ?>';
			var graphTypeID = '<?php echo $graphTypeID; ?>';		
			var graphTypeValue = (graphTypeID == 1 ? "Rw" : "ΔLw");		
			var IDOffset  = (graphTypeID == 1 ? 1 : 15);
			var currentDisplayedMaterialIndex = headingElements.indexOf(materialName);		
			var activeDatasetIDs = new Array();		
			var allDatasetIDs = new Array();
			
			for (var i=1; i < lines.length; i += 2) {		
				
				if ((lines[i][0] == '`') || ((lines[i][0] != graphTypeID))) continue;				
				
				
				line=lines[i].split(',');
				values=lines[i+1].split(',');
							
				
				var title = '<?php echo get_the_title(); ?>';			
				var baseColor = line[3].replace(new RegExp('/', 'g'), ',');
				
				var backgroundFillColor = 'rgba(' + baseColor + ',0.1)';				
				var color = 'rgb(' + baseColor + ')';			
				
				var dataset = {				
					title: line[2],
					//fillColor : backgroundFillColor,
					strokeColor : color,
					pointColor : color,
					pointStrokeColor : '#fff',
					pointHighlightStroke : line[4],
					displayDataset : true,
					fillColor: "rgba(220,220,220,0.2)",
					data : values
				}						
				
				if (title==line[1])
					activeDatasetIDs.push('#' + ( i - IDOffset )/ 2);
				
				allDatasetIDs.push('#' + ( i - IDOffset ) / 2);
					
				loadedDatasets.push(dataset);				
			}		
					
			
			var lineChartData = {
				labels : headingElements,
				datasets : loadedDatasets
			}
		
			var ctx = document.getElementById("canvas").getContext("2d");
			window.myLine = new Chart(ctx).Line(lineChartData, {
				responsive: true,
				bezierCurveTension: 0.3,
				datasetFill : true,
				pointDotRadius : 5,
				pointDotStrokeWidth : 2,
				xAxisLabel : 'Frekvencia ( Hz )',
				yAxisLabel : graphTypeValue + ' ( dB )',
				animationSteps: 15				
			});
			
			legend(document.getElementById("lineLegend"), lineChartData);

			//console.log(allDatasetIDs);
			jQuery.each(allDatasetIDs, function(index, value){
				jQuery(value).trigger('click');	
			});		
			
			jQuery.each(activeDatasetIDs, function(index, value){
				jQuery(value).trigger('click');				
			});
			
			});

		
		}
		</script>
		<?		
		
	}	
	
	?>	
<a href="https://plus.google.com/109024420628459355677" rel="publisher"></a>
<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>

<!-- Kód spoločnosti Google pre remarketingovú značku -->
<!--------------------------------------------------
Remarketingové značky nemôžu byť priradené k informáciám umožňujúcim identifikáciu osôb ani umiestnené na stránkach súvisiacich s citlivými kategóriami. Ďalšie informácie a pokyny k nastaveniu značky nájdete na nasledujúcich stránkach: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1008551004;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>

<script type="text/javascript">
	(function() {
	 livechatooCmd = function() { livechatoo.embed.init({account : 'potichu', lang : '<?php echo get_option('web_locale', 'sk'); ?>', side : 'right'}) };
	 var l = document.createElement('script'); l.type = 'text/javascript'; l.async = !0;
	 l.src = 'http' + (document.location.protocol == 'https:' ? 's' : '') + '://app.livechatoo.com/js/web.min.js'; 
	 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(l, s);
	})();
	</script>
	
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1008551004/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>
