<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_ext1', 'https://fonts.googleapis.com/css?family=Poppins' );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );

// END ENQUEUE PARENT ACTION

// VIDEO MIT HTTPS

	if( !function_exists('gdlr_get_video') ){
		function gdlr_get_video($video, $size = 'full'){
			if( empty($video) ) return '';
			
			$video_size = gdlr_get_video_size($size);
			$width = $video_size['width']; 
			$height = $video_size['height']; 

			// video shortcode
			if(preg_match('#^\[video\s.+\[/video\]#', $video, $match)){ 
				return do_shortcode($match[0]);
				
			// embed shortcode
			}else if(preg_match('#^\[embed.+\[/embed\]#', $video, $match)){ 
				global $wp_embed; 
				return $wp_embed->run_shortcode($match[0]);
				
			// youtube link
			}else if(strpos($video, 'youtube') !== false){
				preg_match('#[?&]v=([^&]+)(&.+)?#', $video, $id);
				$id[2] = empty($id[2])? '': $id[2];
				return '<iframe src="https://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $id[2] . '" width="' . $width . '" height="' . $height . '" ></iframe>';
			
			// youtu.be link
			}else if(strpos($video, 'youtu.be') !== false){
				preg_match('#youtu.be\/([^?&]+)#', $video, $id);
				return '<iframe src="https://www.youtube.com/embed/' . $id[1] . '?wmode=transparent" width="' . $width . '" height="' . $height . '" ></iframe>';
			
			// vimeo link
			}else if(strpos($video, 'vimeo') !== false){
				preg_match('#https?:\/\/vimeo.com\/(\d+)#', $video, $id);
				return '<iframe src="https://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
			
			// another link
			}else if(preg_match('#^https?://\S+#', $video, $match)){ 	
				$path_parts = pathinfo($match[0]);
				if( !empty($path_parts['extension']) ){
					return do_shortcode('[video width="' . $width . '" height="' . $height . '" src="' . $match[0] . '" ][/video]');
				}else{
					global $wp_embed; 
					$video_embed = '[embed width="' . $width . '" height="' . $height . '" ]' . $match[0] . '[/embed]';
					return $wp_embed->run_shortcode($video_embed);
				}				
			}
			return '';
		}
	}

	// column service item
	if( !function_exists('gdlr_get_accommodation_item') ){
		function gdlr_get_accommodation_item( $settings ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $gdlr_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $gdlr_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';

			$ret  = '<div class="gdlr-item gdlr-accommodation-item" ' . $item_id . $margin_style . '>';
			if( !empty($settings['image']) ){ 
				$thumbnail_size = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];
			
				$ret .= '<div class="accommodation-thumbnail">';
				$ret .= gdlr_get_image($settings['image'], $thumbnail_size);
				if( !empty($settings['rating']) && $settings['rating'] != 'none' ){
					$rating = intval($settings['rating']);
				
					$ret .= '<div class="accommodation-rating">';
					for( $i=0; $i<5; $i++ ){
						if( $rating >= 2 ){
							$rating = $rating - 2;
							$ret .= '<i class="fa ' . gdlr_fa_class('icon-star') . '"></i>';
						}else if( $rating >= 1 ){
							$rating = $rating - 1;
							$ret .= '<i class="fa ' . gdlr_fa_class('icon-star-half-empty') . '"></i>';
						}else{
							$ret .= '<i class="fa fa-star-o icon-star-empty"></i>';
						}
					}
					$ret .= '</div>';
				}
				$ret .= '</div>';
			}
			$ret .= '<div class="accommodation-content-outer-wrapper">';
			$ret .= '<div class="accommodation-content-wrapper">';
			$ret .= '<h3 class="accommodation-title">' . gdlr_text_filter($settings['title']) . '</h3>';
			$ret .= '<div class="accommodation-caption gdlr-info-font">' . gdlr_text_filter($settings['caption']) . '</div>';
			$ret .= '</div>'; // accommodation-content-wrapper	
			if( !empty($settings['button-text']) && !empty($settings['button-link']) ){
				$ret .= '<a class="accommodation-button-text gdlr-button" href="' . esc_attr($settings['button-link']) . '" target="_blank">' . $settings['button-text'] . '</a>';
			}
			$ret .= '</div>'; // accommodation-content-outer-wrapper			
			$ret .= '</div>'; // accommodation-item
			return $ret;
		}
	}