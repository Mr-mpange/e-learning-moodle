<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_modernmoodle_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    
    // Pre CSS - We need to include this before the main SCSS
    $prescss = theme_modernmoodle_get_pre_scss($theme);
    
    // Load default preset from Boost
    if ($filename == 'default.scss' || empty($filename)) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else {
        // Check if preset file exists in theme
        $presetfile = $fs->get_file($context->id, 'theme_modernmoodle', 'preset', 0, '/', $filename);
        if ($presetfile) {
            $scss .= $presetfile->get_content();
        } else {
            // Fallback to default
            $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
        }
    }

    // Prepend pre-scss
    $scss = $prescss . "\n" . $scss;

    // Import custom SCSS files
    $scssfiles = [
        '/theme/modernmoodle/scss/_variables.scss',
        '/theme/modernmoodle/scss/_overrides.scss',
        '/theme/modernmoodle/scss/_login.scss',
        '/theme/modernmoodle/scss/_signup.scss',
        '/theme/modernmoodle/scss/_dashboard.scss',
        '/theme/modernmoodle/scss/_components.scss',
    ];

    foreach ($scssfiles as $file) {
        $filepath = $CFG->dirroot . $file;
        if (file_exists($filepath)) {
            $scss .= "\n" . file_get_contents($filepath);
        }
    }

    // Extra SCSS from settings
    $scss .= theme_modernmoodle_get_extra_scss($theme);

    return $scss;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_modernmoodle_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        'brandcolor' => '#3B82F6',
        'brandcolorhover' => '#2563EB',
        'secondarycolor' => '#8B5CF6',
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $default) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : $default;
        $scss .= '$' . $configkey . ': ' . $value . ";\n";
    }

    // Prepend pre-scss setting.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Get extra SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_modernmoodle_get_extra_scss($theme) {
    $content = '';
    
    if (!empty($theme->settings->scss)) {
        $content .= $theme->settings->scss;
    }
    
    return $content;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_modernmoodle_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/modernmoodle/style/moodle.css');
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_modernmoodle_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo')) {
        $theme = theme_config::load('modernmoodle');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}
