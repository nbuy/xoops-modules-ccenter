<?php
# $Id: myformselect.php,v 1.1 2007/08/02 16:27:37 nobu Exp $
# extends support many options with Ajax

include_once 'mypagenav.php';

class MyFormSelect extends XoopsFormSelect
{

    function MyFormSelect($caption,$name,$value=null,$size=1,$multiple=false){
	$this->XoopsFormSelect($caption, $name, $value, $size, $multiple);
	$this->pagenav = '';
	$this->slab = _SEARCH;
    }

    function addOptionUsers($gid=0) {
	list($cuid) = $this->getValue();
	$max = _CC_MAX_USERS;
	$users = cc_group_users($gid, $max, $start);
	$opts = $this->getOptions();

	// force insert current if none
	if ($cuid && !isset($users[$cuid]) && !isset($opts[$cuid])) {
	    $users[$cuid]=XoopsUser::getUnameFromId($cuid);
	}
	$this->addOptionArray($users);
	$this->setPageNav($gid);
    }

    function setPageNav($gid) {
	$start = isset($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$max = _CC_MAX_USERS;
	$total = cc_group_users($gid, $max, $start, true);
	$nav = new MyPageNav($total, $max, $start, 'start', $this->getName());
	$this->pagenav = $nav->renderNav();
    }

    function setSearchLabel($str){
	$this->slab = $str;
    }

    function render(){
	$name = $this->getName();
	$s = htmlspecialchars(isset($_REQUEST[$name.'_s'])?$_REQUEST[$name.'_s']:"");
	$slab  = htmlspecialchars($this->slab);
	return "<table cellpadding='0'>\n<tr valign='top'>".
	    "<td align='center'>".parent::render().
	    "<div id='{$name}_page'>".$this->pagenav."</div></td>".
	    "<td width='100%'> &nbsp; <input size='8' name='{$name}_s' id='{$name}_s' value='$s' onChange='setSelectUID(\"$name\",0);'/><input type='submit' value='$slab' onClick='setSelectUID(\"$name\", 0); return false;'/></td></tr>\n</table>";
    }
    function renderSupportJS( $withtags = true ) {
	$name = $this->getName();
        $js = "";
        if ( $withtags ) {
            $js .= "\n<!-- Start UID Selection JavaScript //-->\n<script type='text/javascript'>\n<!--//\n";
        }
	$js .= '// XMLHttpRequest general handler
function createXmlHttp(){
    if (window.XMLHttpRequest) {             // Mozilla, Firefox, Safari, IE7
        return new XMLHttpRequest();
    } else if (window.ActiveXObject) {       // IE5, IE6
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");    // MSXML3
        } catch(e) {
            return new ActiveXObject("Microsoft.XMLHTTP"); // until MSXML2
        }
    } else {
        return null;
    }
}
';
	$js .= '
function setSelectUID(name, start) {
    var xmlhttp = createXmlHttp();
    var search = xoopsGetElementById(name+"_s");
    var gid = xoopsGetElementById("cgroup");
    if (xmlhttp == null) return;	// XMLHttpRequest not support
    url = "getusers.php?gid=" + gid.value + "&start="+start;
    if (search) url += "&s="+search.value;
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
    var obj = xoopsGetElementById(name);
    var defs = obj.value;
    if (xmlhttp.status == 200) {
        re = new RegExp("<option value=\"0\".*");
	mk = obj.innerHTML.match(re)+"";
        if (mk=="") {
	    sub = "";
	} else {
	    pos = obj.innerHTML.search(re)+mk.length;
	    sub = obj.innerHTML.substring(0, pos);
	}
	F = xmlhttp.responseText.split("<!---->\n");
	obj.innerHTML = sub+F[0];
	obj.value = defs;
	page = xoopsGetElementById(name+"_page");
	page.innerHTML = F[1].replace(/\'uid\'/g, "\'"+name+"\'");
    }
}
';
        if ( $withtags ) {
            $js .= "//--></script>\n<!-- End UID Selection JavaScript //-->\n";
        }
	return $js;
    }
}
?>