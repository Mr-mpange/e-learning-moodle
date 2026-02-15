<?php
// This file is part of Moodle - http://moodle.org/

namespace local_courseselect;

defined('MOODLE_INTERNAL') || die();

class observer {
    
    /**
     * Handle user created event
     */
    public static function user_created(\core\event\user_created $event) {
        global $DB;
        
        $userid = $event->objectid;
        $courseselect = optional_param('courseselect', 0, PARAM_INT);
        
        if ($courseselect > 0) {
            try {
                // Get or create manual enrolment instance
                $enrol = $DB->get_record('enrol', [
                    'courseid' => $courseselect,
                    'enrol' => 'manual'
                ]);
                
                if (!$enrol) {
                    $enrol = new \stdClass();
                    $enrol->enrol = 'manual';
                    $enrol->status = 0;
                    $enrol->courseid = $courseselect;
                    $enrol->sortorder = 0;
                    $enrol->timecreated = time();
                    $enrol->timemodified = time();
                    $enrol->id = $DB->insert_record('enrol', $enrol);
                }
                
                // Get student role
                $studentrole = $DB->get_record('role', ['shortname' => 'student']);
                
                if ($studentrole && $enrol) {
                    // Create user enrolment
                    $userenrolment = new \stdClass();
                    $userenrolment->enrolid = $enrol->id;
                    $userenrolment->userid = $userid;
                    $userenrolment->timestart = time();
                    $userenrolment->timeend = 0;
                    $userenrolment->timecreated = time();
                    $userenrolment->timemodified = time();
                    $userenrolment->modifierid = 0;
                    
                    $DB->insert_record('user_enrolments', $userenrolment);
                    
                    // Assign student role
                    $context = \context_course::instance($courseselect);
                    role_assign($studentrole->id, $userid, $context->id);
                }
            } catch (\Exception $e) {
                debugging('Error enrolling user in course: ' . $e->getMessage(), DEBUG_DEVELOPER);
            }
        }
    }
}
