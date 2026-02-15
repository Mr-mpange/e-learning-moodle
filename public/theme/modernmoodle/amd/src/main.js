// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

define(['jquery'], function($) {
    return {
        init: function() {
            // Sidebar toggle
            $('.sidebar-toggle').on('click', function() {
                $('.dashboard-sidebar').toggleClass('open');
            });

            // Close sidebar on mobile when clicking outside
            $(document).on('click', function(e) {
                if ($(window).width() <= 1024) {
                    if (!$(e.target).closest('.dashboard-sidebar, .sidebar-toggle').length) {
                        $('.dashboard-sidebar').removeClass('open');
                    }
                }
            });

            // Dropdown toggles
            $('[data-toggle="dropdown"]').on('click', function(e) {
                e.stopPropagation();
                const $menu = $(this).siblings('.dropdown-menu');
                $('.dropdown-menu').not($menu).removeClass('show');
                $menu.toggleClass('show');
            });

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.topbar-item').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Password toggle for login/signup
            $('.password-toggle').on('click', function() {
                const $input = $(this).siblings('input[type="password"], input[type="text"]');
                const type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
            });

            // Form focus animations
            $('.form-control').on('focus', function() {
                $(this).closest('.form-group').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.form-group').removeClass('focused');
            });

            // Smooth scroll animations for cards
            $('.course-card, .activity-item, .assignment-card').each(function(index) {
                $(this).css({
                    'animation': `fadeInUp 0.6s ease-out ${index * 0.1}s both`
                });
            });

            // Add loading state to forms
            $('form').on('submit', function() {
                const $submitBtn = $(this).find('button[type="submit"], input[type="submit"]');
                $submitBtn.prop('disabled', true).addClass('loading');
            });
        }
    };
});
