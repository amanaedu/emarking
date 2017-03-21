<?php
require_once (dirname (dirname ( dirname ( dirname ( __FILE__ ) ) ) ). '/config.php');
GLOBAL $USER;

	$activityid = required_param('id', PARAM_INT);
	$record=$DB->get_record('emarking_activities',array('id'=>$activityid));
	
	$record->userid 			= $USER->id;
	$record->parent         	= $activityid;
	$record->timecreated 		= time();
	$record->status    			= 1;

if($forked =$DB->get_record('emarking_activities',array('userid'=>$USER->id,'id'=>$activityid))){
	$forkUrl = new moodle_url($CFG->wwwroot.'/mod/emarking/activities/editactivity.php', array('activityid' => $forked->id));
}
elseif($forked =$DB->get_record('emarking_activities',array('userid'=>$USER->id,'parent'=>$activityid))){
	$forkUrl = new moodle_url($CFG->wwwroot.'/mod/emarking/activities/editactivity.php', array('activityid' => $forked->id));
}
else{
	$insert = $DB->insert_record('emarking_activities', $record);
	$forkUrl = new moodle_url($CFG->wwwroot.'/mod/emarking/activities/views/editactivity.php', array('activityid' => $insert));	
} 
redirect($forkUrl, 0);