<?php
// show attachment file
// $Id: file.php,v 1.5 2012/01/14 07:14:32 nobu Exp $

include "../../mainfile.php";
include "functions.php";

if ( ! function_exists( 'mime_content_type' ) ) {
	function mime_content_type( $f ) {
		return trim( exec( 'file -bi ' . escapeshellarg( $f ) ) );
	}
}

$msgid = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
$file  = basename( $_GET['file'] );

if ( $msgid ) {
	$res = $xoopsDB->query( "SELECT msgid,uid,touid,onepass FROM " . CCMES . " WHERE msgid=$msgid" );
	if ( ! $res || $xoopsDB->getRowsNum( $res ) == 0 ) {
		die( "No File" );
	}
	$data = $xoopsDB->fetchArray( $res );
	if ( ! cc_check_perm( $data ) ) {
		redirect_header( XOOPS_URL . '/user.php', 3, _NOPERM );
		exit;
	}
}

$path = XOOPS_UPLOAD_PATH . cc_attach_path( $msgid, $file );
$type = cc_mime_content_type( $path );
$stat = stat( $path );
if ( ! $stat ) {
	die( 'No File' );
}
//header("Last-Modified: ".formatTimestamp($stat['mtime'], "r"));
header( "Content-Type: $type" );
//header("Content-Length: ".$stat['size']);

if ( $stat && $_SERVER["REQUEST_METHOD"] == "GET" ) {
	header( 'Content-Disposition: inline;filename="' . $file . '"' );
	print file_get_contents( $path );
}
