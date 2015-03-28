<?php

/*
Plugin Name: Main10ence
Plugin URI: http://www.10twebdesign.com/
Description: Automatic maintenace plugin for Wordpress.
Version: 0.1a
Author: 10T Web Design
Author URI: http://www.10twebdesign.com/
GitHub Plugin URI: https://github.com/10twebdesign/main10ence
License: GPL2
*/

add_action ('network_admin_menu', 'main10ence_add_admin_menus');
add_action ('admin_menu', 'main10ence_add_admin_menus');

add_action('init', 'main10ence_add_update_filters');

function main10ence_add_admin_menus()  {
    add_menu_page('Main10ence', 'Main10ence', 'manage_options', 'main10ence_admin_menu_main', 'main10ence_admin_menu_main_display', 'dashicons-admin-plugins', '85.1111');
}

function main10ence_admin_menu_main_display() {
    ?>
    <div class="wrap">
        <h2>Main10ence Options</h2>
        <?php
        if(isset($_POST['main10ence_options_nonce']) && wp_verify_nonce($_POST['main10ence_options_nonce'], 'main10ence_options')) {
        main10ence_admin_menu_main_process();
    }
    ?>
    <form id="main10ence_options_form" method="post">
        <h3>Auto-Updates</h3>
        <?php wp_nonce_field('main10ence_options', 'main10ence_options_nonce'); ?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="allow_minor_updates">Allow Core Security Updates:</label>
                </th>
                <td>
                    <input type="checkbox" name="allow_minor_updates" id="allow_minor_updates" value="1"<?php if(get_site_option('main10ence_allow_minor_updates')) { ?> checked="checked" <?php } ?>>
                    <p class="description">Allow WordPress to perform security / minor version updates automatically.</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="allow_major_updates">Allow Core Major Updates:</label>
                </th>
                <td>
                    <input type="checkbox" name="allow_major_updates" id="allow_major_updates" value="1"<?php if(get_site_option('main10ence_allow_major_updates')) { ?> checked="checked" <?php } ?>>
                    <p class="description">Allow WordPress to perform major version updates automatically.</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="allow_plugin_updates">Allow Plugin Updates:</label>
                </th>
                <td>
                    <input type="checkbox" name="allow_plugin_updates" id="allow_plugin_updates" value="1"<?php if(get_site_option('main10ence_allow_plugin_updates')) { ?> checked="checked" <?php } ?>>
                    <p class="description">Allow WordPress to upgrade plugins automatically.</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="allow_theme_updates">Allow Theme Updates:</label>
                </th>
                <td>
                    <input type="checkbox" name="allow_theme_updates" id="allow_theme_updates" value="1"<?php if(get_site_option('main10ence_allow_theme_updates')) { ?> checked="checked" <?php } ?>>
                    <p class="description">Allow WordPress to upgrade themes automatically.</p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input id="submit" class="button button-primary" type="submit" value="Save Options">
        </p>
    </form>
</div>
<?php
}

function main10ence_admin_menu_main_process() {
    if($_POST['allow_minor_updates'] == 1) {
        update_site_option('main10ence_allow_minor_updates', true);
    } else {
        delete_site_option('main10ence_allow_minor_updates');
    }
    if($_POST['allow_major_updates'] == 1) {
        update_site_option('main10ence_allow_major_updates', true);
    } else {
        delete_site_option('main10ence_allow_major_updates');
    }
    if($_POST['allow_plugin_updates'] == 1) {
        update_site_option('main10ence_allow_plugin_updates', true);
    } else {
        delete_site_option('main10ence_allow_plugin_updates');
    }
    if($_POST['allow_theme_updates'] == 1) {
        update_site_option('main10ence_allow_theme_updates', true);
    } else {
        delete_site_option('main10ence_allow_theme_updates');
    }
    ?>
    <div class="updated"><p>Options saved.</p></div>
    <?php
}

function main10ence_add_update_filters() {
    if(get_option('main10ence_allow_minor_updates')) {
        add_filter('allow_minor_auto_core_updates', '__return_true');
    } else {
        add_filter('allow_minor_auto_core_updates', '__return_false');
    }
    if(get_option('main10ence_allow_major_updates')) {
        add_filter('allow_major_auto_core_updates', '__return_true');
    } else {
        add_filter('allow_major_auto_core_updates', '__return_false');
    }
    if(get_option('main10ence_allow_plugin_updates')) {
        add_filter('auto_update_plugin', '__return_true');
    } else {
        add_filter('auto_update_plugin', '__return_false');
    }
    if(get_option('main10ence_allow_theme_updates')) {
        add_filter('auto_update_theme', '__return_true');
    } else {
        add_filter('auto_update_theme', '__return_false');
    }
}