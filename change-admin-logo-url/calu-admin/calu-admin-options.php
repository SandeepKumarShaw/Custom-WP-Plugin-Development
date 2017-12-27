<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Error!' );
}

function Change_Admin_Logo_Url_menu() {
	add_submenu_page( 'options-general.php', 'Change Admin Logo Url', 'Change Admin Logo Url', 'manage_options', 'calu-admin/calu-admin-options.php', 'calu_settings_page' );
	add_action( 'admin_init', 'calu_register_settings' );
}
add_action( 'admin_menu', 'Change_Admin_Logo_Url_menu' );



function calu_register_settings(){
	register_setting( 'change_admin_logo_url-settings-group', 'calu_logo_file', 'esc_url_raw' );
	register_setting( 'change_admin_logo_url-settings-group', 'calu_logo_url', 'esc_url_raw' );

}

function calu_settings_page() { ?>
	<div class="wrap">
		<h2>Change Admin Logo Url Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'change_admin_logo_url-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Custom Logo Link</th>
					<td>
						<label for="calu_logo_url">
							<input type="text" id="calu_logo_url" name="calu_logo_url" value="<?php echo esc_url ( get_option( 'calu_logo_url' ) ); ?>" />
							<p class="description">If specified, clicking on the logo will return you to the homepage.</p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Custom Logo</th>
					<td>
						<label for="upload_image">				
                            <img class="header_logo" src="<?php echo esc_url ( get_option( 'calu_logo_file' ) ); ?>" height="100" width="100"/>
                           <input class="calu_logo_file_url" type="text" name="calu_logo_file" size="60" value="<?php echo get_option('calu_logo_file'); ?>">
                           <a href="javascript:void(0);" class="header_logo_upload">Upload</a>
                           <p class="description">Enter a URL or upload logo image. Maximum height: 70px, width: 310px.</p>
						</label>
					</td>
				</tr>				
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
	</div>

<?php }?>

