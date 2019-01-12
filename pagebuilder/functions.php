<?php
/* Admin Script */
/**
 * Admin pagebuilder Scripts
 * @since 1.0.0Scripts
 */
add_action( 'admin_enqueue_scripts', 'amppbbase_admin_scripts' );
function amppbbase_admin_scripts( $hook_suffix ){
    global $post_type;
    global $moduleTemplate;
    global $layoutTemplate, $redux_builder_amp;
    /* In Page Edit Screen */
    if( ($post_type=='post' 
    	 || $post_type=='page' 
    	 || (
	    	 	isset($redux_builder_amp['ampforwp-custom-type'])
	    	 	&& is_array($redux_builder_amp['ampforwp-custom-type'])
	    	 	&& in_array($post_type, $redux_builder_amp['ampforwp-custom-type'])
    	 	)
    	)
    	&& in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){
    //if($post_type=='post' || $post_type=='page'){
 	    /* Enqueue CSS & JS For Page Builder */
        wp_enqueue_style( 'amppb-admin', AMP_PAGE_BUILDER_URL. 'inc/admin-amp-page-builder.css', array(), AMPFORWP_VERSION );
        wp_enqueue_style('ampforwp-dynamic-css', admin_url('admin-ajax.php?action=ampforwp_dynaminc_css'), array(), AMPFORWP_VERSION, 'all' );
        wp_enqueue_media();
        //To add page
        if ( ! class_exists( '_WP_Editors', false ) ) {
		    require( ABSPATH . WPINC . '/class-wp-editor.php' );
		}
		add_action( 'admin_print_footer_scripts', array( '_WP_Editors', 'print_default_editor_scripts' ) );
        $amp_current_post_id = $postId = get_the_ID();
            
			
			 wp_enqueue_script( 'vuejs', AMP_PAGE_BUILDER_URL. 'inc/assets/vue/vue.min.js', array(),AMPFORWP_VERSION, true);
			wp_enqueue_script( 'vuejs-resource', AMP_PAGE_BUILDER_URL. 'inc/assets/vuejs-resource/vue-resource.min.js', array(), AMPFORWP_VERSION, true);//For Http Clients
			wp_enqueue_script( 'vueSortable', AMP_PAGE_BUILDER_URL. 'inc/assets/vue.draggable/Sortable.min.js', array(), AMPFORWP_VERSION, true);
			wp_enqueue_script( 'vuedraggable', AMP_PAGE_BUILDER_URL. 'inc/assets/vue.draggable/vuedraggable.min.js' ,array(),AMPFORWP_VERSION, true);
			wp_enqueue_script( 'vuedropdrag', AMP_PAGE_BUILDER_URL. 'inc/assets/vue-drag-drop/vue-drag-drop.browser.js', array(), AMPFORWP_VERSION, true);
			
			 wp_register_script( 'amppb-admin', AMP_PAGE_BUILDER_URL. 'inc/admin-amp-page-builder.js', array(
						'jquery',
						'wp-color-picker',
						'vuejs',
						'vuejs-resource',
						'vueSortable',
						'vuedraggable',
						'vuedropdrag' 
					),AMPFORWP_VERSION, true );  
					
			$ampforwp_metas = array();
			$ampforwp_metas = json_decode(get_post_meta($postId,'ampforwp-post-metas',true),true);
			$ampforwp_pagebuilder_enable = $ampforwp_metas['ampforwp_page_builder_enable'];			
			$previousData = get_post_meta($postId,'amp-page-builder');
			//$ampforwp_pagebuilder_enable = get_post_meta($postId,'ampforwp_page_builder_enable', true);
			$previousData = isset($previousData[0])? $previousData[0]: null;
			
			$previousData = (str_replace("'", "", $previousData));
			
			$totalRows = 1;
			$totalmodules = 1;
			if(!empty($previousData)){
				$jsonData = json_decode($previousData,true);
				if(count($jsonData['rows'])>0){
					$totalRows = $jsonData['totalrows'];
					$totalmodules = $jsonData['totalmodules'];
					$previousData = ($jsonData);
				}else{
					$jsonData['rows'] = array();
					$jsonData['totalrows']=1;
					$jsonData['totalmodules'] = 1;
					$previousData = ($jsonData);
				}
			}else{
					$jsonData['rows'] = array();
					$jsonData['totalrows']=1;
					$jsonData['totalmodules'] = 1;
					$previousData = ($jsonData);
				}
			wp_localize_script( 'amppb-admin', 'amppb_data',$previousData);


			$allPostLayout = $ampforwp_metas = array();
			$args = array(
						'posts_per_page'   => -1,
						'orderby'          => 'date',
						'order'            => 'DESC',
						'post_type'        => 'amppb_layout',
						'post_status'      => 'publish'
						);
			$posts_array = get_posts( $args );
			if(count($posts_array)>0){
				foreach ($posts_array as $key => $layoutData) {
				$allPostLayout[] = array('post_title'=>$layoutData->post_title,
										'post_id'=>$layoutData->ID,
										'post_content'=>$layoutData->post_content,
											);
				}
			}
			$ampforwp_metas = json_decode(get_post_meta($postId,'ampforwp-post-metas',true),true);
			$components_options = array(
									"ajaxUrl"=>admin_url( 'admin-ajax.php' ),
									"savedLayouts"=>$allPostLayout,
									"startPagebuilder"=>($ampforwp_metas['use_ampforwp_page_builder']=='yes'? 1:0),
									"checkedPageBuilder"=>$ampforwp_metas['ampforwp_page_builder_enable'],
									);
			wp_localize_script( 'amppb-admin', 'amppb_panel_options',$components_options);
			wp_enqueue_script('amppb-admin');
			add_action( 'admin_footer', 'js_templates',9999);
	   
	    
    }
}

function js_templates() {
	global $containerCommonSettings;
	global $moduleTemplate;
    global $layoutTemplate;
    global $savedlayoutTemplate;
	include plugin_dir_path( __FILE__ ) . '/inc/js-templates.php';
}
 
require_once AMP_PAGE_BUILDER.'inc/amppb_save_data.php';
require_once AMP_PAGE_BUILDER.'inc/viewShowFrontData.php';
require_once AMP_PAGE_BUILDER.'inc/adminAjaxContents.php';