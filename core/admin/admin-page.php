<?php
if (!defined('ABSPATH'))
{
    die('-1');
}
/**
 * @package WP Version Tag Remover
 * @version 2.1
 * @since 1.0
 */
if (!current_user_can('manage_options'))
{
    wp_die(__('You do not have sufficient permissions to access this page.'));
}
?>
<div class="wrap">
    <h1>WP Version Tag Remove Settings</h1>
<?php
$apj_pcm_opt_name_css          = APJ_WVTR_OPT_NAME_CSS;
$apj_pcm_opt_name_js           = APJ_WVTR_OPT_NAME_JS;
$apj_pcm_opt_name_generator    = APJ_WVTR_OPT_NAME_GENERATOR;
$apj_pcm_opt_name_wpversion    = APJ_WVTR_OPT_NAME_WP_VERSION;
$apj_pcm_opt_name_woocversion  = APJ_WVTR_OPT_NAME_WOOC_VERSION;
if( isset($_POST["submit"]) && $_POST['action'] == 'apj_form_response') {
    if ( isset( $_POST['apj_add_user_meta_nonce'] ) && wp_verify_nonce( $_POST['apj_add_user_meta_nonce'], 'apj_add_user_meta_form_nonce'))
    {
    if (isset($_POST[$apj_pcm_opt_name_css])) {
    $css_status        = sanitize_text_field($_POST[$apj_pcm_opt_name_css]);
    }else{
        $css_status = 0;
    }
    if (isset($_POST[$apj_pcm_opt_name_js])) {
    $js_status         = sanitize_text_field($_POST[$apj_pcm_opt_name_js]);
    }
    else {
        $js_status = 0;
    }
    if (isset($_POST[$apj_pcm_opt_name_generator])) {
    $generator_status  = sanitize_text_field($_POST[$apj_pcm_opt_name_generator]);
    }else {
        $generator_status = 0;
    }
    if (isset($_POST[$apj_pcm_opt_name_wpversion])) {
    $wp_version_status  = sanitize_text_field($_POST[$apj_pcm_opt_name_wpversion]);
    }else {
        $wp_version_status = 0;
    }
    if (isset($_POST[$apj_pcm_opt_name_woocversion])) {
    $wooc_version_status  = sanitize_text_field($_POST[$apj_pcm_opt_name_woocversion]);
    }else {
        $wooc_version_status = 0;
    }
    update_option($apj_pcm_opt_name_css, $css_status);
    update_option($apj_pcm_opt_name_js, $js_status);
    update_option($apj_pcm_opt_name_generator, $generator_status);
    update_option($apj_pcm_opt_name_wpversion, $wp_version_status);
    update_option($apj_pcm_opt_name_woocversion, $wooc_version_status);
    echo '<div id="message" class="updated fade"><p>Settings saved.</p></div>';
}
else
{
    wp_die( __( 'Invalid. Please try again', APJ_WVTR_MENU_SLUG ), __( 'Error', APJ_WVTR_MENU_SLUG ), array(
        'response' 	=> 403,
        'back_link' => 'options-general.php?page=' . APJ_WVTR_MENU_SLUG,

    ) );
}
}
// Generate a custom nonce value.
$apj_add_meta_nonce = wp_create_nonce( 'apj_add_user_meta_form_nonce' );
?>
    <div>
        <fieldset>
            <form method="post" action="">
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 235px"><label for="<?php echo APJ_WVTR_OPT_NAME_CSS; ?>">Remove Version Tag Form CSS files</label></th>
                            <td><input type="checkbox" value="1" name="<?php echo APJ_WVTR_OPT_NAME_CSS; ?>" id="<?php echo APJ_WVTR_OPT_NAME_CSS; ?>" <?php esc_attr(checked(get_option(APJ_WVTR_OPT_NAME_CSS) , 1)); ?> />
                            <input type="hidden" name="action" value="apj_form_response">
		                    <input type="hidden" name="apj_add_user_meta_nonce" value="<?php echo $apj_add_meta_nonce ?>" /></td>
                        </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="<?php echo APJ_WVTR_OPT_NAME_JS; ?>">Remove Version Tag Form JS Files</label></th>
                            <td><input type="checkbox" value="1" name="<?php echo APJ_WVTR_OPT_NAME_JS; ?>" id="<?php echo APJ_WVTR_OPT_NAME_JS; ?>" <?php esc_attr(checked(get_option(APJ_WVTR_OPT_NAME_JS) , 1)); ?> /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="<?php echo APJ_WVTR_OPT_NAME_GENERATOR; ?>">Remove Generator Tag</label></th>
                            <td><input type="checkbox" value="1" name="<?php echo APJ_WVTR_OPT_NAME_GENERATOR; ?>" id="<?php echo APJ_WVTR_OPT_NAME_GENERATOR; ?>" <?php esc_attr(checked(get_option(APJ_WVTR_OPT_NAME_GENERATOR) , 1));  ?> /></td>
                        </tr>
                        <?php $apj_pcm_opt_name_css_value = get_option(APJ_WVTR_OPT_NAME_CSS);$apj_pcm_opt_name_js_value = get_option(APJ_WVTR_OPT_NAME_JS); if ($apj_pcm_opt_name_css_value == '0' || $apj_pcm_opt_name_js_value == '0') { ?>
                        <tr>
                            <th scope="row"><label for="<?php echo APJ_WVTR_OPT_NAME_WP_VERSION; ?>">Remove WordPress version number from all enqueued CSS and JS files</label></th>
                            <td><input type="checkbox" value="1" name="<?php echo APJ_WVTR_OPT_NAME_WP_VERSION; ?>" id="<?php echo APJ_WVTR_OPT_NAME_WP_VERSION; ?>" <?php esc_attr(checked(get_option(APJ_WVTR_OPT_NAME_WP_VERSION) , 1));  ?> /></td>
                        </tr>
                        <?php } ?>
                        <?php if ( class_exists( 'WooCommerce' ) && $apj_pcm_opt_name_css_value == '0' || $apj_pcm_opt_name_js_value == '0') { ?>
                        <tr>
                            <th scope="row"><label for="<?php echo APJ_WVTR_OPT_NAME_WOOC_VERSION; ?>">Remove WooCommerce version number from all enqueued CSS and JS files</label></th>
                            <td><input type="checkbox" value="1" name="<?php echo APJ_WVTR_OPT_NAME_WOOC_VERSION; ?>" id="<?php echo APJ_WVTR_OPT_NAME_WOOC_VERSION; ?>" <?php esc_attr(checked(get_option(APJ_WVTR_OPT_NAME_WOOC_VERSION) , 1));  ?> /></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <p class="submit"><?php submit_button(); ?></p>
            </form>
        </fieldset>
    </div>
</div>
