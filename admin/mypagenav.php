<?php
# $Id: mypagenav.php,v 1.2 2007/08/03 05:40:44 nobu Exp $
# page control for priuid select

include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

define('_CC_MAX_USERS', 100);	// users/page

class MyPageNav extends XoopsPageNav {

    function MyPageNav($total, $items, $current, $name="start", $target='uid') {
	$this->XoopsPageNav($total, $items, $current, $name);
	$this->target = $target;
    }

    function renderNav($offset = 4)
    {
        $ret = '';
	$name = $this->target;
	$fmt = '<a href="javascript:setSelectUID(\''.$name.'\',%d);">%s</a> ';
        if ( $this->total <= $this->perpage ) {
            return $ret;
        }
        $total_pages = ceil($this->total / $this->perpage);
        if ( $total_pages > 1 ) {
            $prev = $this->current - $this->perpage;
            if ( $prev >= 0 ) {
                $ret .= sprintf($fmt, $prev, '<u>&laquo;</u>');
            }
            $counter = 1;
            $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
            while ( $counter <= $total_pages ) {
                if ( $counter == $current_page ) {
                    $ret .= '<b>('.$counter.')</b> ';
                } elseif ( ($counter > $current_page-$offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages ) {
                    if ( $counter == $total_pages && $current_page < $total_pages - $offset ) {
                        $ret .= '... ';
                    }
                    $ret .= sprintf($fmt, ($counter - 1) * $this->perpage, $counter);
                    if ( $counter == 1 && $current_page > 1 + $offset ) {
                        $ret .= '... ';
                    }
                }
                $counter++;
            }
            $next = $this->current + $this->perpage;
            if ( $this->total > $next ) {
                $ret .= sprintf($fmt, $next, '<u>&raquo;</u>');
            }
        }
        return $ret;
    }
}

function cc_group_users($group=0, $max=_CC_MAX_USERS, $start=0, $count=false) {
    global $xoopsDB;

    $cond = empty($group)?"":" AND groupid=$group";
    if (!empty($_REQUEST['s'])) $cond .= ' AND uname LIKE '.$xoopsDB->quoteString($_REQUEST['s'].'%');
    $sql0 = "FROM ".$xoopsDB->prefix("groups_users_link")." l, ".$xoopsDB->prefix("users")." u WHERE l.uid=u.uid".$cond;
    if ($count) {
	$res = $xoopsDB->query("SELECT DISTINCT u.uid $sql0");
	$total = $xoopsDB->getRowsNum($res);
	return $total;
    }
    $res = $xoopsDB->query("SELECT u.uid, uname $sql0 GROUP BY u.uid ORDER BY uname", $max, $start);
    $options = array();
    while (list($uid, $uname) = $xoopsDB->fetchRow($res)) {
	$options[$uid] = htmlspecialchars($uname);
    }
    return $options;
}
?>