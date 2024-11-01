<?php
namespace apjWVTR;
if (!defined('ABSPATH'))
{
    die('-1');
}
/**
 * @package WP Version Tag Remover
 * @version 2.1
 * @since 1.0
 */
class WPVersionTagRemover
{
    /**
     * Plugin activation
     * @return void
     */
    public static function activate()
    {
        self::checkRequirements();
    }
    /**
     * Plugin uninstall
     * @return void
     */
    public static function uninstall()
    {
        self::apjUninstallPlugin();
    }
    /**
     * Check plugin requirements
     * @return void
     */
    private static function checkRequirements()
    {
        update_option(APJ_WVTR_OPT_NAME_CSS, '1');
        update_option(APJ_WVTR_OPT_NAME_JS, '1');
        update_option(APJ_WVTR_OPT_NAME_GENERATOR, '1');
    }
    /**
     * Uninstall plugin
     * @return void
     */
    private static function apjUninstallPlugin()
    {
        delete_option(APJ_WVTR_OPT_NAME_CSS);
        delete_option(APJ_WVTR_OPT_NAME_JS);
        delete_option(APJ_WVTR_OPT_NAME_GENERATOR);
        delete_option(APJ_WVTR_OPT_NAME_WP_VERSION);
        delete_option(APJ_WVTR_OPT_NAME_WOOC_VERSION);
    }
    /**
     * Initialize WordPress hooks
     * @return void
     */
    public static function initHooks()
    {
        //Admin notices
        add_action('admin_notices', array(
            'apjWVTR\WPVersionTagRemover',
            'adminNotices'
        ));
        //Admin menu
        add_action('admin_menu', array(
            'apjWVTR\WPVersionTagRemover',
            'adminMenu'
        ));
        add_action('init', array(
            'apjWVTR\WPVersionTagRemover',
            'APJWPVersionTagRemover'
        ));
        add_filter("plugin_action_links", array(
            'apjWVTR\WPVersionTagRemover',
            'PluginActionLinks'
        ) , 1, 2);
        add_filter("plugin_row_meta", array(
            'apjWVTR\WPVersionTagRemover',
            'PluginRowMeta'
        ) , 1, 2);
        //Admin page
        $page = filter_input(INPUT_GET, 'page');
        if (!empty($page) && $page == APJ_WVTR_MENU_SLUG)
        {
            add_filter('admin_footer_text', array(
                'apjWVTR\WPVersionTagRemover',
                'adminFooter'
            ));
        }
    }
    /**
     * Admin notices
     * @return void
     */
    public static function adminNotices()
    {
    }
    /**
     * APJWPVersionTagRemover
     * @return string
     */
    public static function APJWPVersionTagRemover()
    {
        if (!is_admin())
        {
            $remove_tag_from_css         = get_option(APJ_WVTR_OPT_NAME_CSS);
            $remove_tag_from_script      = get_option(APJ_WVTR_OPT_NAME_JS);
            $remove_tag_from_generator   = get_option(APJ_WVTR_OPT_NAME_GENERATOR);
            $remove_tag_from_wpversion   = get_option(APJ_WVTR_OPT_NAME_WP_VERSION);
            $remove_tag_from_woocversion = get_option(APJ_WVTR_OPT_NAME_WOOC_VERSION);
            // remove ver from css files
            if ($remove_tag_from_css) add_filter('style_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_css_js'
            ));
            // remove ver from js files
            if ($remove_tag_from_script) add_filter('script_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_css_js'
            ));
            // remove generator tag
            if ($remove_tag_from_generator) add_filter('the_generator', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_generator'
            ));
            // remove wordpress tag from css only
            if ($remove_tag_from_wpversion && $remove_tag_from_css == '0') add_filter('style_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_wp_ver_css'
            ));
            // remove wordpress tag from js only
            if ($remove_tag_from_wpversion && $remove_tag_from_script == '0') add_filter('script_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_wp_ver_js'
            ));
            // remove wordpress tag from css only
            if (class_exists( 'WooCommerce' ) && $remove_tag_from_woocversion && $remove_tag_from_css == '0') add_filter('style_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_wooc_ver_css'
            ));
            // remove wordpress tag from js only
            if (class_exists( 'WooCommerce' ) && $remove_tag_from_woocversion && $remove_tag_from_script == '0') add_filter('script_loader_src', array(
                'apjWVTR\WPVersionTagRemover',
                'wvtr_version_remover_wooc_ver_js'
            ));
        }
    }
    /**
     * remove wp version param from any enqueued scripts
     */
    public static function wvtr_version_remover_css_js($src)
    {
        if (strpos($src, 'ver=')) $src = remove_query_arg('ver', $src);
        return $src;
    }
    /**
     * remove wp generator tag from head section
     */
    public static function wvtr_version_remover_generator()
    {
        return '';
    }
    /**
     * remove WordPress version number from all enqueued CSS
     */
    public static function wvtr_version_remover_wp_ver_css( $src ) {
        if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    /**
     * remove WordPress version number from all enqueued JS
     */
    public static function wvtr_version_remover_wp_ver_js( $src ) {
        if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    /**
     * remove WordPress version number from all enqueued CSS
     */
    public static function wvtr_version_remover_wooc_ver_css( $src ) {
        if ( strpos( $src, 'ver=' . WC_VERSION ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    /**
     * remove WordPress version number from all enqueued JS
     */
    public static function wvtr_version_remover_wooc_ver_js( $src ) {
        if ( strpos( $src, 'ver=' . WC_VERSION ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    /**
     * Admin menu
     * @return void
     */
    public static function adminMenu()
    {
        add_options_page('WP Version Tag Remover Settings', 'WP Version Tag Remover', 'manage_options', plugin_dir_path(__FILE__) . 'admin/admin-page.php');
    }
    /**
     * Admin footer
     * @return void
     */
    public static function adminFooter()
    {
    ?>
        <p><a href="https://wordpress.org/support/plugin/wp-version-tag-remover/reviews/#new-post" class="apj-review-link" target="_blank"><?php echo sprintf(__('If you like <strong> %s </strong> please leave us a &#9733;&#9733;&#9733;&#9733;&#9733; rating.', 'apjWVTR') , APJ_WVTR_PLUGIN_NAME); ?></a>  <?php _e('Thank you.', 'apjWVTR'); ?></p>
    <?php
    }
    /**
     * Plugin row meta/action links
     * @return void
     */
    public static function PluginRowMeta($links_array, $plugin_file_name)
    {
        if (strpos($plugin_file_name, APJ_WVTR_PLUGIN_INT)) $links_array = array_merge($links_array, array(
            '<a target="_blank" href="https://paypal.me/arulprasadj?locale.x=en_GB"><span style="font-size: 20px; height: 20px; width: 20px;" class="dashicons dashicons-heart"></span>Donate</a>'
        ));
        return $links_array;
    }
    public static function PluginActionLinks($links_array, $plugin_file_name)
    {
        if (strpos($plugin_file_name, APJ_WVTR_PLUGIN_INT)) $links_array = array_merge(array(
            '<a href="' . admin_url('admin.php?page=' . APJ_WVTR_MENU_SLUG . '') . '">Settings</a>'
        ) , $links_array);
        return $links_array;
    }
}
