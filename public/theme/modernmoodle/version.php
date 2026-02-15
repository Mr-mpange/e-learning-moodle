<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2026020802;        // YYYYMMDDHH (year, month, day, hour)
$plugin->requires  = 2023100900;        // Moodle 4.3 or later
$plugin->component = 'theme_modernmoodle';
$plugin->dependencies = [
    'theme_boost' => 2023100900
];
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.0.0';
