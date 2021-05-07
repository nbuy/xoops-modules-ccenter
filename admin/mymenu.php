<?php

// Skip for ORETEKI XOOPS
if ( defined( 'XOOPS_ORETEKI' ) ) {
	return;
}

global $xoopsModule;
if ( ! is_object( $xoopsModule ) ) {
	die( '$xoopsModule is not set' );
}

// language files (modinfo.php)
$language  = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'];
$mydirpath = dirname( __FILE__, 2 );
$mydirname = basename( $mydirpath );
if ( file_exists( "$mydirpath/language/$language/modinfo.php" ) ) {
	// user customized language file
	include_once "$mydirpath/language/$language/modinfo.php";
} else {
	// fallback english
	include_once "$mydirpath/language/english/modinfo.php";
}

include __DIR__ . '/menu.php';

$use_altsys = file_exists( XOOPS_TRUST_PATH . '/libs/altsys/mytplsadmin.php' );
if ( $use_altsys ) {
	$adminmenu = array_merge( $adminmenu, $adminmenu4altsys );
} else {

	// preferences
	$config_handler =& xoops_gethandler( 'config' );
	if ( count( $config_handler->getConfigs( new Criteria( 'conf_modid', $xoopsModule->mid() ) ) ) > 0 ) {
		if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			// system->preferences
			array_push( $adminmenu, array(
				'title' => _PREFERENCES,
				'link'  => XOOPS_URL . '/modules/legacy/admin/index.php?action=PreferenceEdit&confmod_id=' . $xoopsModule->mid()
			) );
		} else {
			array_push( $adminmenu, array(
				'title' => _PREFERENCES,
				'link'  => XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $xoopsModule->mid()
			) );
		}
	}
}

$mymenu_uri  = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri;
$mymenu_link = substr( strstr( $mymenu_uri, '/admin/' ), 1 );


// highlight
foreach ( array_keys( $adminmenu ) as $i ) {
	if ( $mymenu_link == $adminmenu[ $i ]['link'] ) {
		$adminmenu[ $i ]['selected']     = true;
		$adminmenu_hilighted             = true;
		$GLOBALS['altsysAdminPageTitle'] = $adminmenu[ $i ]['title'];
	} else {
		$adminmenu[ $i ]['selected'] = false;
	}
}
if ( empty( $adminmenu_hilighted ) ) {
	$maxlen = 0;
	foreach ( array_keys( $adminmenu ) as $i ) {
		$link = $adminmenu[ $i ]['link'];
		if ( $maxlen < strlen( $link ) && stristr( $mymenu_uri, $link ) ) {
			if ( $maxlen ) {
				$last = false;
			}
			$maxlen                          = strlen( $link );
			$adminmenu[ $i ]['selected']     = true;
			$last                            = &$adminmenu[ $i ]['selected'];
			$GLOBALS['altsysAdminPageTitle'] = $adminmenu[ $i ]['title'];
		}
	}
}

// link conversion from relative to absolute
foreach ( array_keys( $adminmenu ) as $i ) {
	if ( stristr( $adminmenu[ $i ]['link'], XOOPS_URL ) === false ) {
		$adminmenu[ $i ]['link'] = XOOPS_URL . "/modules/$mydirname/" . $adminmenu[ $i ]['link'];
	}
}

if ( $use_altsys ) {
	// display
	require_once XOOPS_ROOT_PATH . '/class/template.php';
	$tpl = new XoopsTpl();
	$tpl->assign( array(
		'adminmenu' => $adminmenu,
	) );
	$tpl->display( 'db:altsys_inc_mymenu.html' );
} else {
	// display (you can customize htmls)
	echo "<div style='text-align:left;width:98%;'>";
	foreach ( $adminmenu as $menuitem ) {
		echo "<div style='float:left;height:1.5em;'><nobr><a href='" . htmlspecialchars( $menuitem['link'], ENT_QUOTES ) . "' style='background-color:" . ( $menuitem['selected'] ? "#FFCCCC" : "#DDDDDD" ) . ";font:normal normal bold 9pt/12pt;'>" . htmlspecialchars( $menuitem['title'], ENT_QUOTES ) . "</a> | </nobr></div>\n";
	}
	echo "</div>\n<hr style='clear:left;display:block;' />\n";
}
