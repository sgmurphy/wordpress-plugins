<?php
// code for custom post type  Project
		function corpex_project() {
	
			$project_slug = get_theme_mod('project_slug','project'); 
			register_post_type( 'corpex_project',
				array(
					'labels' => array(
						'name' => __('Project', 'clever-fox'),
						'singular_name' => __('Project', 'clever-fox'),
						'add_new' => __('Add New', 'clever-fox'),
						'add_new_item' => __('Add New Project','clever-fox'),
						'edit_item' => __('Edit Project','clever-fox'),
						'new_item' => __('New Facebook link ','clever-fox'),
						'all_items' => __('All Project','clever-fox'),
						'view_item' => __('View Link','clever-fox'),
						'search_items' => __('Search Links','clever-fox'),
						'not_found' =>  __('No Links found','clever-fox'),
						'not_found_in_trash' => __('No Links found in Trash','clever-fox'), 						
					),
						'supports' => array('title','excerpt','thumbnail','comments'),
						'show_in_nav_menus' => false,
						'public' => true,
						'menu_position' => 20,
						'rewrite' => array('slug' => $project_slug),
						'menu_icon' => 'dashicons-schedule',
					
				)
			);
		}
		add_action( 'init', 'corpex_project' );


		// Project Meta Box

		function corpex_project_init()
		{
							
			add_meta_box('project_all_meta', 'Project Description', 'corpex_meta_project','corpex_project', 'normal', 'high');
			
			add_action('save_post','corpex_meta_project_save');
		}


		add_action('admin_init','corpex_project_init');		
						

						
		function corpex_meta_project()
		{
			global $post;
			
			$project_button_link 			= sanitize_text_field( get_post_meta( get_the_ID(),'project_button_link', true ));
			$project_button_link_target 	= sanitize_text_field( get_post_meta( get_the_ID(),'project_button_link_target', true ));
		?>	
			
			<h3><i><?php esc_html_e('Project Single View Detail','clever-fox'); ?></i></h3>

			
			<div class="inside">	
				<p><label><?php _e('Project URL','clever-fox');?></label></p>
				<p><input style="width:100%; height:40px; padding: 10px;"  name="project_button_link" placeholder="<?php _e('Project URL','clever-fox');?>" type="text" value="<?php if (!empty($project_button_link)) echo esc_attr($project_button_link);?>">&nbsp;</input></p>
				<p> <input name="project_button_link_target" type="checkbox" <?php if(!empty($project_button_link_target)) echo "checked"; ?> > </input>
				<label><?php _e('Open link in a new tab','clever-fox'); ?> </label> </p>
			</div>				
			
		<?php 	
		}


		function corpex_meta_project_save($post_id) 
		{
			if(isset( $_POST['post_ID']))
			{ 	
				$post_ID = $_POST['post_ID'];				
				$post_type=get_post_type($post_ID);
				if($post_type=='corpex_project')
				{	
					update_post_meta($post_ID, 'project_button_link', sanitize_text_field($_POST['project_button_link']));
					update_post_meta($post_ID, 'project_button_link_target', sanitize_text_field($_POST['project_button_link_target']));
				}
			}
		}
		
		// Project Category Texonomy
		
		function corpex_project_taxonomy() {
		
		$texo_project_slug = get_theme_mod('texo_project_slug','project_category'); 
		register_taxonomy('project_categories', 'corpex_project',
			array(
				'hierarchical' => true,
				'label' => 'Project Categories',
				'show_in_nav_menus' => true,
				'query_var' => true,
				'rewrite' => array('slug' => $texo_project_slug )
			)
		);
	
	
		//Default category id		
		$defualt_tex_id = get_option('custom_texo_project_id');
		//quick update category
		if((isset($_POST['action'])) && (isset($_POST['taxonomy']))){		
			wp_update_term($_POST['tax_ID'], 'project_categories', array(
			  'name' => $_POST['name'],
			  'slug' => $_POST['slug']
			));	
			update_option('custom_texo_project_id', $defualt_tex_id);
		}
		else 
		{ 	//insert default category 
			if(!$defualt_tex_id){
				wp_insert_term('All','project_categories', array('description'=> 'Default Category','slug' => 'All'));
				$Current_text_id = term_exists('All', 'project_categories');
				update_option('custom_texo_project_id', $Current_text_id['term_id']);
			}
		}
		//update category
		if(isset($_POST['submit']) && isset($_POST['action']) )
		{	wp_update_term(isset($_POST['tag_ID']), 'project_categories', array(
			  'name' => isset($_POST['name']),
			  'slug' => isset($_POST['slug']),
			  'description' => isset($_POST['description'])
			));
		}
		// Delete default category
		if(isset($_POST['action']) && isset($_POST['tag_ID']) )
		{	if(($_POST['tag_ID'] == $defualt_tex_id) && $_POST['action']	 =="delete-tag")
			{	
				delete_option('custom_texo_project_id'); 
			} 
		}
	}
	add_action( 'init', 'corpex_project_taxonomy' );
?>