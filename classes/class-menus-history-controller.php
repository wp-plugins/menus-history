<?php

class Menus_History {
    
    private $show_past_revision = true;

    function __construct() {

    	//Save menu revision 
    	add_action('wp_update_nav_menu', array( &$this, 'save_menu_revision') );
    	
    	//Add plugin page
        add_action('admin_menu', array(&$this,'add_admin_menu'));
        
        //Get revisions
        add_action('wp_ajax_get_revisions', array(&$this,'get_revisions') );
        
        //Get revision
        add_action('wp_ajax_get_revision', array(&$this,'get_revision') );
        
        //Enqueue admin scripts
        add_action('admin_enqueue_scripts',array(&$this,'enqueue_admin_scripts') );
    } 
    
    function enqueue_admin_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('menus-history', MENUS_HISTORY_URL . '/js/menus-history.js');
        wp_enqueue_style('menus-history', MENUS_HISTORY_URL . '/css/menus-history.css');
    }
    
    function add_admin_menu() {
    	if ( is_admin() ){ // admin actions
            add_submenu_page(
				'tools.php',
                'Menus History', 
                'Menus History', 
                'manage_options', 
                'menus-history', 
                array( $this, 'create_admin_page' )
            );
        }
    }
    
    function get_revisions() {
        
        $args =  array(
            'post_type' => 'menu_revision',
            'post_parent' => $_POST['term_id']
        );
        
        $revisions = new WP_Query($args);
        
        if ( $revisions->have_posts() ) {
            
            $empty = false;
            
            ob_start();
            include MENUS_HISTORY_DIR.'views/revisions.php';
            $html = ob_get_clean();
            
        }
        else {
            
            $empty = true;
            
            $html = "<p>Revisions for this menu are not yet available. Future changes to the menu will be listed here. Please choose a different menu.</p>";
            
        }
        
        echo json_encode(
            array(
                'empty'=>$empty,
                'html'=>$html
            ) 
        );
    
        die();
    }
    
    function get_revision() {
        $args =  array(
                'post_type' => 'menu_revision',
                'p' => $_POST['revision_id']
            );
            
        $revision = new WP_Query($args);
        
        echo "<h2>". get_the_author_meta('display_name', $revision->posts[0]->post_author) . '; ' . $revision->posts[0]->post_date."</h2>";
        
        $custom_fields = get_post_custom($_POST['revision_id']);
        $metas =  maybe_unserialize( $custom_fields['menus_history_metas'][0] );
        echo $this->format_menu( $metas['menu_items'] );
        
        die();
    }
    
    function create_admin_page() {
        
        $my_menus = get_terms( 'nav_menu', array('hide_empty'=>false) );

        include MENUS_HISTORY_DIR."views/admin-page.php";
        
    }
    
    function save_menu_revision($nav_menu_selected_id) {
        
        if ( $this->show_past_revision ) {
            $this->show_past_revision = false;
            return;
        }

        //Save new revision
         $args = array(
			'post_title'=>'menu_revision'.uniqid(),
			'post_content'=> '',
			'post_name'=>'menu_revision'.uniqid(),
			'post_status'=>'publish',
			'post_type'=>'menu_revision',
			'post_parent'=>$nav_menu_selected_id
			);
		 $revision_id = wp_insert_post( $args );
		 
		 $new_revision_metas['menu_items'] = wp_get_nav_menu_items($nav_menu_selected_id);
		 update_post_meta( $revision_id, 'menus_history_metas', $new_revision_metas );
           
    }
	
	function format_menu($menu_items) {
	    
	    
		$items = walk_nav_menu_tree( $menu_items,0,(object) apply_filters( 'wp_nav_menu_args', array('walker'=>new Menus_History_Nav_Walker() ) ) );
		return sprintf( '<ul>%1$s</ul>',  $items );
	}
	
}