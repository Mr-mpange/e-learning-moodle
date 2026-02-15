<?php
// This file is part of Moodle - http://moodle.org/

defined('MOODLE_INTERNAL') || die();

/**
 * Extend the signup form with course selection
 * This function is called by core_login_extend_signup_form()
 */
function local_courseselect_extend_signup_form($mform) {
    global $DB;
    
    // Get all available courses (excluding site course)
    $courses = $DB->get_records_select('course', 'id > 1 AND visible = 1', null, 'fullname', 'id, fullname');
    
    if (empty($courses)) {
        return; // No courses available
    }
    
    $courseoptions = [0 => get_string('selectcourse', 'local_courseselect')];
    foreach ($courses as $course) {
        $courseoptions[$course->id] = format_string($course->fullname);
    }
    
    // Add course selection dropdown
    $mform->addElement('select', 'courseselect', 
        get_string('selectyourcourse', 'local_courseselect'), 
        $courseoptions);
    
    $mform->addHelpButton('courseselect', 'selectyourcourse', 'local_courseselect');
    $mform->setType('courseselect', PARAM_INT);
    $mform->addRule('courseselect', get_string('required'), 'required', null, 'client');
}

/**
 * Validate the course selection
 */
function local_courseselect_validate_extend_signup_form($data) {
    $errors = [];
    
    if (empty($data['courseselect']) || $data['courseselect'] == 0) {
        $errors['courseselect'] = get_string('required');
    }
    
    return $errors;
}
