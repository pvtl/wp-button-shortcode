<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * Plugin Name:     Button Shortcode by Pivotal
 * Plugin URI:      https://github.com/pvtl/wp-button-shortcode.git
 * Description:     Adds a Button Shortcode & popup (with options for the button) to the WYSIWYG
 * Author:          Pivotal Agency
 * Author URI:      http://pivotal.agency
 * Text Domain:     button-shortcode
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         ButtonShortcode
 */

namespace App\Plugins\Pvtl;

class ButtonShortcode
{
    public function __construct()
    {
        // Call the actions/hooks
        add_action('after_setup_theme', array($this, 'afterSetupTheme'));
        add_action('init', array($this, 'registerButtonShortcode'));
    }

    /**
     * Add a button to Tinymce, only after theme is setup
     *
     * @return void
     */
    public function afterSetupTheme()
    {
        add_action('init', function () {
            // Only execute script when user has access rights
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
                return;
            }

            // Only execute script when rich editing is enabled
            if (get_user_option('rich_editing') !== 'true') {
                return;
            }

            // Add the JS to the admin screen
            add_filter('mce_external_plugins', function ($plugin_array) {
                $file = plugin_dir_url(__FILE__) . '/resources/assets/js/shortcode-button.js';
                $plugin_array['button-shortcode'] = $file;
                return $plugin_array;
            });

            // Register the button to the editor
            add_filter('mce_buttons', function ($buttons) {
                array_push($buttons, 'button-shortcode');
                return $buttons;
            });
        });
    }

    /**
     * Handle the shortcode
     *
     * @return void
     */
    public function registerButtonShortcode()
    {
        add_shortcode('button', function ($input) {
            if (!is_admin()) {
                $attr = array(
                    'text' => 'Learn More',
                    'href' => '#',
                    'size' => '',
                    'style' => '',
                    'target' => '',
                );

                if (!empty($input['text'])) {
                    $attr['text'] = $input['text'];
                }

                if (!empty($input['href'])) {
                    $attr['href'] = $input['href'];
                }

                if (!empty($input['size'])) {
                    $attr['size'] = $input['size'];
                }

                if (!empty($input['style'])) {
                    $attr['style'] = $input['style'];
                }

                if (!empty($input['target'])) {
                    $attr['target'] = $input['target'];
                }

                $html = '<a href="' . $attr['href'] . '" ';
                $html .= 'class="button ' . $attr['size'] . ' '  . $attr['style'] . '" ';
                $html .= (!empty($input['target'])) ? 'target="'.$input['target'].'"' : '';
                $html .= '>'. $attr['text'] . '</a>';

                return $html;
            }
        });
    }
}

if (!defined('ABSPATH')) {
    exit;  // Exit if accessed directly
}

$pvtlButtonShortcode = new ButtonShortcode();
