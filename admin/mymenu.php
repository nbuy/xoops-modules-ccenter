<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

if( ! defined( 'XOOPS_ORETEKI' ) && ! defined( 'XOOPS_CUBE_LEGACY' )) {
	// Skip for ORETEKI XOOPS

	if( ! isset( $module ) || ! is_object( $module ) ) $module = $xoopsModule ;
	else if( ! is_object( $xoopsModule ) ) die( '$xoopsModule is not set' )  ;

	if( file_exists("../language/".$xoopsConfig['language']."/modinfo.php") ) {
		include_once("../language/".$xoopsConfig['language']."/modinfo.php");
	} else {
		include_once("../language/english/modinfo.php");
	}

	include( './menu.php' ) ;

//	
	$menuitem_dirname = $module->getvar('dirname') ;
	if( $module->getvar('hasconfig') ) {
	    $link = file_exists('admin.php')?'admin/admin.php?fct=preferences&op=showmod&mod=':'../system/admin.php?fct=preferences&op=showmod&mod=';
	    array_push( $adminmenu , array( 'title' => _PREFERENCES , 'link' => $link . $module->getvar('mid') ) ) ;
	}

	$menuitem_count = 0 ;
	$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
	$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;

	// hilight
	foreach( array_keys( $adminmenu ) as $i ) {
		if( $mymenu_link == $adminmenu[$i]['link'] ) {
			$adminmenu[$i]['color'] = '#FFCCCC' ;
			$adminmenu_hilighted = true ;
		} else {
			$adminmenu[$i]['color'] = '#DDDDDD' ;
		}
	}
	if( empty( $adminmenu_hilighted ) ) {
		foreach( array_keys( $adminmenu ) as $i ) {
			if( stristr( $mymenu_uri , $adminmenu[$i]['link'] ) ) {
				$adminmenu[$i]['color'] = '#FFCCCC' ;
			}
		}
	}



/*	// display
	foreach( $adminmenu as $menuitem ) {
		echo "<a href='".XOOPS_URL."/modules/$menuitem_dirname/{$menuitem['link']}' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>{$menuitem['title']}</a> &nbsp; \n" ;

		if( ++ $menuitem_count >= 4 ) {
			echo "</div>\n<div width='95%' align='center'>\n" ;
			$menuitem_count = 0 ;
		}
	}
	echo "</div>\n" ;
*/
	// display
	echo "<div style='text-align:left;width:98%;'>" ;
	foreach( $adminmenu as $menuitem ) {
		echo "<div style='float:left;height:1.5em;'><nobr><a href='".XOOPS_URL."/modules/$menuitem_dirname/{$menuitem['link']}' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>{$menuitem['title']}</a> | </nobr></div>\n" ;
	}
	echo "</div>\n<hr style='clear:left;display:block;' />\n" ;

}

?>