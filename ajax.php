<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
*
* @package    block
* @copyright  2018 Mihail Pozarski <mihail.pozarski@uai.cl>
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
define('AJAX_SCRIPT', true);
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
global $DB, $USER;

require_login();
if (isguestuser()){
    die();
}

$courseid = required_param("courseid", PARAM_INT);
// Verify course
if(! $course = $DB->get_record("course", array("id" => $courseid))){
	echo "course dont exist";
	die();
}
if(!$check = $DB->get_record('block_termsandconditions',array('courseid'=>$course->id,'userid'=>$USER->id))){
    // Inserts record con DB of copyright terms acceptance
    $insert = new stdClass();
    $insert->userid = $USER->id;
    $insert->courseid = $course->id;
    $insert->timecreated = time();
    if($insertid = $DB->insert_record("block_termsandconditions", $insert,true)){
    	echo $insertid;
    }else{
    	echo false;
    }
}else{
    echo false;
}