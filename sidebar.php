<?php
global $avia_config;

##############################################################################
# Display the sidebar
##############################################################################

$default_sidebar = true;
$sidebar_pos = avia_layout_class('main', false);

$sidebar_smartphone = avia_get_option('smartphones_sidebar') == 'smartphones_sidebar' ? 'smartphones_sidebar_active' : "";
$sidebar = "";

if(strpos($sidebar_pos, 'sidebar_left')  !== false) $sidebar = 'left';
if(strpos($sidebar_pos, 'sidebar_right') !== false) $sidebar = 'right';

//filter the sidebar position (eg woocommerce single product pages always want the same sidebar pos)
$sidebar = apply_filters('avf_sidebar_position', $sidebar);

//if the layout hasnt the sidebar keyword defined we dont need to display one
if(empty($sidebar)) return;
if(!empty($avia_config['overload_sidebar'])) $avia_config['currently_viewing'] = $avia_config['overload_sidebar'];


echo "<aside class='sidebar sidebar_".$sidebar." ".$sidebar_smartphone." ".avia_layout_class( 'sidebar', false )." units' ".avia_markup_helper(array('context' => 'sidebar', 'echo' => false)).">";
    echo "<div class='inner_sidebar extralight-border'>";

	$materialPageID = get_page_by_title( 'materialy')->ID;
	//$currentPageParentID= get_post_ancestors( $the_id )[0];
	//if (empty($currentPageParentID)) $currentPageParentID = -1;

	global $singleMaterialPage;

	if ($singleMaterialPage){


		$webLocale = get_option('web_locale', 'sk');
    $materialEshopUrl = get_the_excerpt();

    if ($materialEshopUrl != null) {
		    if ($webLocale == 'sk') {
          echo 'Materiál máme v ponuke<br/> v našom E-shope:';
          echo '<a href="' . $materialEshopUrl . '" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium " style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otvoriť materiál v e-shope</span></a></br></br>';
        } else if ($webLocale == 'cs') {
          echo 'Materiál máme v nabídce<br/> v našem E-shope:';
          echo '<a href="' . $materialEshopUrl . '" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium " style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otevřít materiál v e-shopu</span></a></br></br>';
        }

      /*
			echo '<h3 class="widgettitle">Nový eshop:</h3>';
			echo '<ul style="list-style: initial; margin-left: 15px;">';
				echo '<li>Jednoduchý a rýchly nákup</li>';
				echo '<li>Osobné vyzdvihnutie alebo doručenie kuriérom</li>';
				echo '<li>Široká ponuka materiálov</li>';
			echo '</ul>';
			echo '<a href="https://eshop.potichu.sk/" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium "><span class="avia_iconbox_title">Otvoriť eshop</span></a></br></br>';
      */

    } else {
      if ($webLocale == 'sk') {
        echo 'Navštívte náš e-shop:';
        echo '<ul style="list-style: initial; margin-left: 15px;">';
          echo '<li>Jednoduchý a rýchly nákup</li>';
          echo '<li>Osobné vyzdvihnutie alebo doručenie kuriérom</li>';
          echo '<li>Široká ponuka materiálov</li>';
        echo '</ul>';
        echo '<a href="https://eshop.potichu.sk" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium" style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otvoriť e-shop</span></a></br></br>';
      } else if ($webLocale == 'cs') {
        echo 'Navštivte náš e-shop:';
        echo '<ul style="list-style: initial; margin-left: 15px;">';
          echo '<li>Jednoduchej a rychlej nákup</li>';
          echo '<li>Osobní vyzvednutí nebo doručení kurýrem</li>';
          echo '<li>Široká nabídka materiálů</li>';
        echo '</ul>';
        echo '<a href="https://eshop.potichu.cz" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium" style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otevřít e-shop</span></a></br></br>';
      }
    }


		$args = array(
			'post_parent' => $materialPageID,
			'posts_per_page' => -1,
			'child_of' => $materialPageID,
			'post_status' => 'published' );

		$materialsArray = get_children( $args, ARRAY_A );

		if ($webLocale == 'sk') {
        echo '<h3 class="widgettitle">Ďalšie materiály:</h3>';
    } else if ($webLocale == 'cs')  {
      echo '<h3 class="widgettitle">DALŠÍ MATERIÁLY:</h3>';
    }
		echo '<ul class="news-wrap image_size_widget">';

		//var_dump($materialsArray);


		//wp_list_pages()

		$materialsArray = get_pages(array(
			'child_of' => $materialPageID,
			'parent' => $materialPageID,
			'sort_order' => 'DESC',
		));


		//var_dump($materialsArray);

		foreach ($materialsArray as $material){

			$materialTitle = $material->post_title;
			$materialID = $material->ID;
			$materialPermalink = get_permalink($materialID);

			?>
			<li class="news-content post-format-standard">

          <a class="news-thumb" title="<? echo $materialTitle; ?>" href="<? echo $materialPermalink; ?>">
						<? echo get_the_post_thumbnail($materialID, array(36,36)); ?>
					</a>

          <a title="<? echo $materialTitle; ?>" href="<? echo $materialPermalink; ?>">
            <strong class="news-headline"><? echo $materialTitle; ?></strong>
          </a>

          <?php
            $eshopUrl = $material->post_excerpt;
            if ($eshopUrl != null) {
                if ($webLocale == 'sk') {
                  echo '<a href="' . $eshopUrl . '" target="_blank" title="OTVORIŤ V ESHOPE">OTVORIŤ V E-SHOPE</a>';
                }
                else if ($webLocale == 'cs') {
                  echo '<a href="' . $eshopUrl . '" target="_blank" title="OTEVŘÍT V E-SHOPU">OTEVŘÍT V E-SHOPU</a>';
                }
            }
           ?>

			</li>

			<?php
			}
		echo '</ul>';

    if ($materialEshopUrl != null) {
      if ($webLocale == 'sk') {
        echo 'Materiál máme v ponuke<br/> v našom E-shope:';
        echo '<a href="' . $materialEshopUrl . '" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium " style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otvoriť materiál v e-shope</span></a></br></br>';
      }
      else if ($webLocale == 'cs') {
        echo 'Materiál máme v nabídce<br/> v našem E-shope:';
        echo '<a href="' . $materialEshopUrl . '" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-medium " style="margin-top: 8px;" target="_blank"><span class="avia_iconbox_title">Otevřít materiál v e-shopu</span></a></br></br>';
      }
    }
	}
	else {

        //Display a subnavigation for pages that is automatically generated, so the users do not need to work with widgets
        $av_sidebar_menu = avia_sidebar_menu(false);
        if($av_sidebar_menu)
        {
            echo $av_sidebar_menu;
            $default_sidebar = false;
        }


        $the_id = @get_the_ID();
        $custom_sidebar = "";
        if(!empty($the_id) && is_singular())
        {
            $custom_sidebar = get_post_meta($the_id, 'sidebar', true);
        }

        if($custom_sidebar)
        {
            dynamic_sidebar($custom_sidebar);
            $default_sidebar = false;
        }
        else
        {
            if(empty($avia_config['currently_viewing'])) $avia_config['currently_viewing'] = 'page';

            // general shop sidebars
            if ($avia_config['currently_viewing'] == 'shop' && dynamic_sidebar('Shop Overview Page') ) : $default_sidebar = false; endif;

            // single shop sidebars
            if ($avia_config['currently_viewing'] == 'shop_single') $default_sidebar = false;
            if ($avia_config['currently_viewing'] == 'shop_single' && dynamic_sidebar('Single Product Pages') ) : $default_sidebar = false; endif;

            // general blog sidebars
            if ($avia_config['currently_viewing'] == 'blog' && dynamic_sidebar('Sidebar Blog') ) : $default_sidebar = false; endif;

            // general pages sidebars
            if ($avia_config['currently_viewing'] == 'page' && dynamic_sidebar('Sidebar Pages') ) : $default_sidebar = false; endif;

            // forum pages sidebars
            if ($avia_config['currently_viewing'] == 'forum' && dynamic_sidebar('Forum') ) : $default_sidebar = false; endif;

        }

        //global sidebar
        if (dynamic_sidebar('Displayed Everywhere')) : $default_sidebar = false; endif;



        //default dummy sidebar
        if (apply_filters('avf_show_default_sidebars', $default_sidebar))
        {
			 if(apply_filters('avf_show_default_sidebar_pages', true)) {avia_dummy_widget(2);}
             if(apply_filters('avf_show_default_sidebar_categories', true)) {avia_dummy_widget(3);}
             if(apply_filters('avf_show_default_sidebar_archiv', true)) {avia_dummy_widget(4);}
        }
	}

    echo "</div>";
echo "</aside>";
