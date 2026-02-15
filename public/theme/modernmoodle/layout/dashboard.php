<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

// Use Boost's columns2 layout for dashboard
$templatecontext = [
    'sitename' => format_string($SITE->shortname),
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes()
];

echo $OUTPUT->render_from_template('theme_boost/columns2', $templatecontext);
