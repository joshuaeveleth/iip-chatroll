<?php
/**
 * Plugin Name: Chatroll Shortcode for IIP Properties
 * Description: A simple shortcode to display a chatroll on IIP properties.
 * Version: 1.0.0
 * Author: Scott Gustas
 * License: GPLv2 or later
 */

add_action('wp_enqueue_scripts', 'iip_chatroll_scripts');
function iip_chatroll_scripts() {
    wp_enqueue_script('iip_chatroll_script', plugins_url('js/iip-chatroll.js', __FILE__), array('jquery') );
}

add_action('wp_enqueue_scripts', 'iip_chatroll_styles');
function iip_chatroll_styles() {

    wp_enqueue_style( 'iip_chatroll_style', plugins_url('css/iip-chatroll.css', __FILE__) );
    
    if ( is_admin() )
        wp_enqueue_style( 'iip_chatroll_style_admin', plugins_url('css/iip-chatroll-admin.css', __FILE__) );

}

add_shortcode('iip_chatroll', 'iip_chatroll_shortcode');
function iip_chatroll_shortcode($atts, $content=null) {
    extract(shortcode_atts(
            array(
                  'title' => 'Chat',
                  'width' => '450',
                  'height' => '350',
                  'id' => '',
                  'name' => '',
                  'domain' => 'chatroll-cloud-1.com',
                  'align' => 'right',
                  'offsetx' => '20',
                  'offsety' => '0'
                  ), $atts
            ));

    $shortcode = '<style type="text/css">.iip_chatroll{'.$align.': '.$offsetx.'px; bottom: '.$offsety.'px;}.chatroll_topbar{width:'.$width.'px;}</style>';
    $shortcode .= '<div class="iip_chatroll"><div class="chatroll_topbar">'.$title.'<div class="iip_toggle"><div class="iip_one"></div><div class="iip_two"></div></div></div>';
    $shortcode .= '<iframe class="" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowtransparency="true" src="https://'.$domain.'/embed/chat/'.$name.'?id='.$id.'&platform=html"></iframe>';
    $shortcode .= '</div>';
    return $shortcode;
}

/*
    TinyMCE
*/

add_action('media_buttons_context', 'iip_chatroll_tinymce_button');

// Add content for inserting a chatroll
add_action('admin_footer', 'iip_chatroll_tinymce');

// TinyMCE Button for the shortcode
function iip_chatroll_tinymce_button($context) {
    $container_id = 'add_chatroll_form';
    $title = __('Insert Chatroll', 'iip-chatroll');

    $context .= "<a class='thickbox button' title='{$title}' id='add_chatroll'
    href='#TB_inline?width=600&height=800&inlineId={$container_id}'> Add Chatroll</a>";

    return $context;
}

function iip_chatroll_tinymce() {
    ?>
    <script type="text/javascript">
    function insertChatroll(){
        var title = jQuery('#chatroll_title').val();
        var height = jQuery('#chatroll_height').val();
        var width = jQuery('#chatroll_width').val();
        var id = jQuery('#chatroll_id').val();
        var name = jQuery('#chatroll_name').val();
        var domain = jQuery('#chatroll_domain').val();
        var align = jQuery('#chatroll_align').val();
        var offsetx = jQuery('#chatroll_offsetx').val();
        var offsety = jQuery('#chatroll_offsety').val();

        window.send_to_editor("[iip_chatroll title=\"" + title + "\" width=\"" + width + "\" height=\"" + height + "\" id=\"" + id + "\" name=\"" + name + "\" domain=\"" + domain + "\" align=\"" + align + "\" offsetX=\"" + offsetx + "\" offsetY=\"" + offsety + "\" ]");
    }
    </script>

    <div id="add_chatroll_form" style="display:none;" class="thickbox" >
        <div class="wrap">
            <div>
                <div style="padding:15px 15px 0 15px;">
                    <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e('Insert Chatroll', 'iip-chatroll'); ?></h3>
                    <span>
                        <?php _e('Configure your Chatroll and add it to your post', 'iip-chatroll'); ?>
                    </span>
                </div>
                <div style="padding:15px 15px 0 15px;">
                    <table>
                        <tbody>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_title"><?php _e('Window Title', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_title" size="16" maxlength="16" value="Chat" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_width"><?php _e('Width', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_width" size="5" value="450" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_height"><?php _e('Height', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_height" size="5" value="350" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_id"><?php _e('ID', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_id" size="20" value="" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_name"><?php _e('Name', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_name" size="20" value="" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_domain"><?php _e('Domain', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_domain" size="40" value="chatroll-cloud-1.com" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_align"><?php _e('Alignment', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;">
                                    <select id="chatroll_align">
                                        <option value="right">Right</option>
                                        <option value="left">Left</option>
                                    </select><br/>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsetx"><?php _e('Offset X', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_offsetx" size="4" value="20" /></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsety"><?php _e('Offset Y', 'iip-chatroll'); ?></label></td>
                                <td style="padding: 0 0 10px;"><input type="text" id="chatroll_offsety" size="4" value="0" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="<?php _e('Insert Chatroll', 'iip-chatroll'); ?>" onclick="insertChatroll();"/>
                    <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'iip-chatroll'); ?></a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
