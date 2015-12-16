<?php
//    MyDMS. Document Management System
//    Copyright (C) 2002-2005  Markus Westphal
//    Copyright (C) 2006-2008 Malcolm Cowe
//    Copyright (C) 2010 Matteo Lucarelli
//    Copyright (C) 2010-2012 Uwe Steinmann
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");

/**
 * Include class to preview documents
 */
require_once("SeedDMS/Preview.php");

if (!$user->isAdmin()) {
	UI::exitError(getMLText("admin_tools"),getMLText("access_denied"));
}

$allUsers = $dms->getAllUsers($settings->_sortUsersInList);
if (is_bool($allUsers)) {
	UI::exitError(getMLText("admin_tools"),getMLText("internal_error"));
}

$allGroups = $dms->getAllGroups();
if (is_bool($allGroups)) {
	UI::exitError(getMLText("admin_tools"),getMLText("internal_error"));
}

if(isset($_GET['groupid']) && $_GET['groupid']) {
	$selgroup = $dms->getGroup($_GET['groupid']);
} else {
	$selgroup = null;
}

$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user, 'selgroup'=>$selgroup, 'allgroups'=>$allGroups, 'allusers'=>$allUsers, 'strictformcheck'=>$settings->_strictFormCheck, 'cachedir'=>$settings->_cacheDir, 'previewWidthList'=>$settings->_previewWidthList));
if($view) {
	$view($_GET);
}

?>
