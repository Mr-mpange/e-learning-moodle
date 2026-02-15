<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingmodernmoodle', get_string('configtitle', 'theme_modernmoodle'));
    $page = new admin_settingpage('theme_modernmoodle_general', get_string('generalsettings', 'theme_modernmoodle'));

    // Brand color setting
    $name = 'theme_modernmoodle/brandcolor';
    $title = get_string('brandcolor', 'theme_modernmoodle');
    $description = get_string('brandcolor_desc', 'theme_modernmoodle');
    $default = '#3B82F6';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Brand color hover setting
    $name = 'theme_modernmoodle/brandcolorhover';
    $title = get_string('brandcolorhover', 'theme_modernmoodle');
    $description = get_string('brandcolorhover_desc', 'theme_modernmoodle');
    $default = '#2563EB';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Secondary color setting
    $name = 'theme_modernmoodle/secondarycolor';
    $title = get_string('secondarycolor', 'theme_modernmoodle');
    $description = get_string('secondarycolor_desc', 'theme_modernmoodle');
    $default = '#8B5CF6';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo file setting
    $name = 'theme_modernmoodle/logo';
    $title = get_string('logo', 'theme_modernmoodle');
    $description = get_string('logo_desc', 'theme_modernmoodle');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset setting
    $name = 'theme_modernmoodle/preset';
    $title = get_string('preset', 'theme_modernmoodle');
    $description = get_string('preset_desc', 'theme_modernmoodle');
    $default = 'default.scss';
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_modernmoodle', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'modernmoodle');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting
    $name = 'theme_modernmoodle/presetfiles';
    $title = get_string('presetfiles', 'theme_modernmoodle');
    $description = get_string('presetfiles_desc', 'theme_modernmoodle');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        ['maxfiles' => 20, 'accepted_types' => ['.scss']]);
    $page->add($setting);

    $settings->add($page);

    // Advanced settings page
    $page = new admin_settingpage('theme_modernmoodle_advanced', get_string('advancedsettings', 'theme_boost'));

    // Raw SCSS to include before the content
    $setting = new admin_setting_scsscode('theme_modernmoodle/scsspre',
        get_string('rawscsspre', 'theme_modernmoodle'), get_string('rawscsspre_desc', 'theme_modernmoodle'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content
    $setting = new admin_setting_scsscode('theme_modernmoodle/scss',
        get_string('rawscss', 'theme_modernmoodle'), get_string('rawscss_desc', 'theme_modernmoodle'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
