<?php

class Menus_History_Nav_Walker extends Walker_Nav_Menu{
		
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$output .= $indent . '<li>';
		
		$item_output = '<div class="link-info">';
		
		$item_output .= '<label>Navigation label:</label> ' . ($item->title ? $item->title : '-'). '<br/>';
		$item_output .= '<label>Title attribute:</label> ' . ($item->attr_title ? $item->attr_title : '-' ). '<br/>';
		$item_output .= '<label>CSS classes:</label> ' .( trim( implode( $item->classes, ', ') ) ? implode( $item->classes, ', ') : '-' ). '<br/>';
		$item_output .= '<label>Description:</label> ' . ($item->description ? $item->description : '-' ). '<br/>';
		$item_output .= '<label>URL:</label> ' . ($item->url ? $item->url : '-') . '<br/>';
		$item_output .= '<label>Open link in a new tab?:</label> ' . ( empty($item->target) ? 'No' : 'Yes' ) . '<br/>';
		$item_output .= '<label>Link relationship:</label> ' . (!empty( $item->xfn ) ? $item->xfn : '-');
		$item_output .= "</div>";
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
}