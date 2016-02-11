<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/ericphamhoang
 * @since      1.0.0
 *
 * @package    Awesomeblock
 * @subpackage Awesomeblock/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Awesomeblock
 * @subpackage Awesomeblock/public
 * @author     Eric Pham Hoang <ericphamhoang@gmail.com>
 */
class Awesomeblock_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Awesomeblock_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Awesomeblock_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/awesomeblock-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Awesomeblock_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Awesomeblock_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/awesomeblock-public.js', array('jquery'), $this->version, false);

    }

    public function init_custom_post_type_block()
    {
        add_action('init', function () {

            register_post_type('blocks', array(
                'labels' => array(
                    'name' => 'Blocks',
                    'singular_name' => 'Block',
                    'menu_name' => 'Blocks',
                    'name_admin_bar' => 'Blocks'
                ),
                'public' => true,
                'show_ui' => true,
                'taxonomies' => array('block-category'),
                'show_in_nav_menus' => true,
                'menu_position' => 100,
                'menu_icon' => 'dashicons-editor-bold',
                'supports' => array(
                    'title', 'editor', 'thumbnail', 'revisions', 'taxonomy'
                )
            ));

            $labels = array(
                'name'              => _x( 'Block Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'Block Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Block Category' ),
                'all_items'         => __( 'All Block Categories' ),
                'parent_item'       => __( 'Parent Block Category' ),
                'parent_item_colon' => __( 'Parent Block Category:' ),
                'edit_item'         => __( 'Edit Block Category' ),
                'update_item'       => __( 'Update Block Category' ),
                'add_new_item'      => __( 'Add New Block Category' ),
                'new_item_name'     => __( 'New Block Category Name' ),
                'menu_name'         => __( 'Block Categories' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'genre' ),
            );

            register_taxonomy( 'block-category', array('blocks'), $args);
        });
    }

    public function add_block_shortcode()
    {
        add_shortcode('awesome-block', function ($atts, $content) {
            ob_start();

            update_option('awesome-block-'.$atts['id'], $_SERVER['REQUEST_URI']);

            $post = get_post($atts['id']);

            echo apply_filters('the_content', $post->post_content);

            if (current_user_can("manage_options")) {
                ?>
                <a class="awesome-block-edit" target="_blank" href="/wp-admin/post.php?post=<?php echo $post->ID ?>&action=edit">Edit Block</a>
                <?php
            }

            return ob_get_clean();
        });
        add_filter( 'widget_text', 'do_shortcode' );
    }

    public function allow_span_tags()
    {
        function myextensionTinyMCE($init) {
            // Command separated string of extended elements
            $ext = 'span[id|name|class|style]';

            // Add to extended_valid_elements if it alreay exists
            if ( isset( $init['extended_valid_elements'] ) ) {
                $init['extended_valid_elements'] .= ',' . $ext;
            } else {
                $init['extended_valid_elements'] = $ext;
            }

            // Super important: return $init!
            return $init;
        }

        add_filter('tiny_mce_before_init', 'myextensionTinyMCE' );
    }

}
