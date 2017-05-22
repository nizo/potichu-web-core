<?php

	global $avia_config;
	get_header();
	?>
	 
	<style>
	
		.step > div:hover,
		#back-button:hover {
			cursor: pointer;
		}
		
		.step > div {
			margin-bottom: 20px;
			border: 1px solid grey;			
			padding: 20px 15px;
			text-align: center;
			display: inline-block;
			height: 240px;
			vertical-align: top;
			margin: 10px 10px;
			width: 180px;
			border-radius: 2px;			
		}
		
		h2 {			
			font-size: 18px;
			line-height: 22px;
			margin-top: 10px;
			margin-bottom: 3px;
		}
		h1 {
			text-align: center;
			margin-bottom: 30px;
		}
		
		#back-button {
		    color: #0061b5;
			font-weight: bold;
			font-size: 16px;
			margin-bottom: 15px;
		}
		
		.hidden { display: none; }
		
		.image-wrapper { height: 80px; }
		
		#back-button span {
			display: inline-block;
			margin-top: -14px;
			vertical-align: middle;
		}
		
		.hiddenContainer {
			visibility: hidden;
		}		
		
		.step { text-align: center; }
		
		
		.construction img {
			width: 320px;
			float: left;
		}
		
		
	</style>
	<div id="constructions" class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>
		<div class='container'>
			<main class='template-page content  <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'page'));?>>
							
				<form method="post" id="construction-advisor-form" name="form">
			
					<div id="back-button" class="hiddenContainer">					
						<img src="<?php echo get_template_directory_uri (); ?>/images/back-button.svg" width="24"/> 
						<span>Späť</span>
					</div>

					<div class="step" id="problem-section">					
						<h1>S čím potrebujete pomôcť?</h1>

						<div data-link="konstrukcie-akustika" data-last-step="true">
							<div class="image-wrapper">
								<img src="<?php echo get_template_directory_uri (); ?>/images/constructions/acoustic-problems.svg" width="70"/>
							</div>

							<h2>Mám problém s&nbsp;priestorovou akustikou</h2>
							<div class="description">znižovanie ozveny, hluk na pracovisku</div>
						</div>

						<div data-id="loud-me">
							<div class="image-wrapper">
								<img src="<?php echo get_template_directory_uri (); ?>/images/constructions/loud-me.svg" width="75"/>
							</div>
							<h2>Som hlučný sused</h2>
							<div class="description">Ipsum dolor sit amet</div>
						</div>

						<div data-id="loud-neighboor">
							<div class="image-wrapper">
								<img src="<?php echo get_template_directory_uri (); ?>/images/constructions/loud-neighboor.svg" width="70"/>
							</div>
							<h2>Mám hlučného suseda</h2>
							<div class="description">Lorem ipsum dolor sit amet</div>
						</div>

						<div data-link="konstrukcie-hluk-vo-vyrobe" data-last-step="true">
							<div class="image-wrapper">
								<img src="<?php echo get_template_directory_uri (); ?>/images/constructions/construction-noise.svg" width="60"/>
							</div>
							<h2>Hluk vo výrobe</h2>
							<div class="description">Dolor sit amet lorem ipsum </div>
						</div>

						<div data-link="konstrukcie-profesionali" data-last-step="true">
							<div class="image-wrapper">
								<img src="<?php echo get_template_directory_uri (); ?>/images/constructions/other.svg" width="80"/>
							</div>
							<h2>Iné</h2>
							<div class="description">Lorem ipsum dolor sit amet</div>
						</div>
					</div>
					
					
					
					
					<div class="step" id="noise-type-section" style="display: none;">
						<?php 	
							echo '<h1>Aký typ hluku vytváram?</h1>';
							$terms = get_terms('noise_type', array('hide_empty' => false));
							
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
								foreach ( $terms as $term ) {									
									echo '<div data-noise-type="' . $term->slug . '">';
										
									echo '<div class="image-wrapper"><img src="' . get_template_directory_uri() . '/images/constructions/' . $term->slug . '.svg" width="60"/></div>';
									echo '<h2>' . $term->name . '</h2>';
									echo '<div class="description">' . $term->description . '</div>';
									echo '</div>';
								}								
							}							
						?>
					</div>
										
					<div class="step" id="construction-width-section" style="display: none;">
						<?php
							echo '<h1>Maximálna hrúbka konštrukcie?</h1>';
							$terms = get_terms('construction_width', array('hide_empty' => false));
							
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
								foreach ( $terms as $term ) {
									echo '<div data-width="' . $term->slug . '">';
									echo '<div class="image-wrapper"><img src="' . get_template_directory_uri() . '/images/constructions/' . $term->slug . '.svg" width="60"/></div>';
									echo '<h2>' . $term->name . '</h2>';
									echo '<div class="description">' . $term->description . '</div>';
									echo '</div>';
								}								
							}							
						?>
					</div>
					
					<div class="step" id="construction-approach-section" style="display: none;">
						<?php
							echo '<h1>Aký prístup chcem zvoliť?</h1>';
							$terms = get_terms('construction_approach', array('hide_empty' => false));
							
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
								foreach ( $terms as $term ) {
									echo '<div data-approach="' . $term->slug . '">';
									echo '<div class="image-wrapper"><img src="' . get_template_directory_uri() . '/images/constructions/' . $term->slug . '.svg" width="80"/></div>';
									echo '<h2>' . $term->name . '</h2>';
									echo '<div class="description">' . $term->description . '</div>';
									echo '</div>';
								}								
							}							
						?>
					</div>
					
					<div class="step" id="noise-originator-section" style="display: none;">
						<?php 	
							echo '<h1>Akú konštrukciu chcem odhlučniť</h1>';
							$terms = get_terms('noise_originator', array('hide_empty' => false));
							
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){								
								foreach ( $terms as $term ) {
									echo '<div data-originator="' . $term->slug . '">';									
									echo '<div class="image-wrapper"><img src="' . get_template_directory_uri() . '/images/constructions/' . $term->slug . '.svg" width="80"/></div>';
									echo '<h2>' . $term->name . '</h2>';
									echo '<div class="description">' . $term->description . '</div>';
									echo '</div>';
								}								
							}							
						?>
					</div>
					
					<div id="results" style="display: none;">
					</div>
					
					<div id="results-konstrukcie-akustika" style="display: none;">
						<?php echo fetchPage('konstrukcie-akustika'); ?>
					</div>
					
					<div id="results-konstrukcie-hluk-vo-vyrobe" style="display: none;">
						<?php echo fetchPage('konstrukcie-hluk-vo-vyrobe'); ?>
					</div>
					
					<div id="results-konstrukcie-profesionali" style="display: none;">
						<?php echo fetchPage('konstrukcie-profesionali'); ?>
					</div>
					
					<div id="results-konstrukcie-krocajovy-hluk" style="display: none;">
						<?php echo fetchPage('konstrukcie-profesionali'); ?>						
					</div>
					
					

				</form>
				
				</main>
			</div>
		</div>

<?php get_footer(); ?>



