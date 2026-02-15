<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes();

// Use Boost's secure template
echo $OUTPUT->render_from_template('theme_boost/secure', [
    'sitename' => format_string($SITE->shortname),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes
]);
