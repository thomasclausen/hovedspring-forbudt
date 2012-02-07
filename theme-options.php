<?php // THEME OPTIONS

function theme_options_array() {
	$theme_options_array = array (
		array(
			'type' => 'section_start'
		),
		array(
			'type' => 'textarea',
			'label' => __( 'Google Analytics', 'hovedspring_forbudt' ),
			'id' => 'google_analytics',
			'description' => __( 'Inds&aelig;t din Google Analytics kode (eller kode fra andre services) her.<br />Koden vil automatisk blive indsat lige f&oslash;r <code>&lt;/body&gt;</code>.', 'hovedspring_forbudt' ),
			'value' => __( '', 'hovedspring_forbudt' ),
			'rows' => '10'
		),
		array(
			'type' => 'section_end'
		)
	);
	return $theme_options_array;
}

function theme_options_field_name( $value ) {
	return 'hovedspring_forbudt_theme_options[' . $value . ']';
}

function theme_options_page() {
	$theme_options = theme_options_array();
	
	if ( !isset( $_REQUEST['settings-updated'] ) ) :
		$_REQUEST['settings-updated'] = false;
	endif; ?>
	<style type="text/css">
	.hr-divider { height: 1px; color: #e3e3e3; margin: 24px 0; background: #e3e3e3; overflow: hidden; clear: both; }
	.required { margin: 0 0 0 5px; }
	.required strong, .required b { color: #93332e; }
	</style>
	<div class="wrap">
		<?php screen_icon(); echo '<h2>' . __( 'Theme Options' ) . '</h2>'; ?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?><div class="updated fade"><p><strong><?php _e( 'Indstillingerne er gemt', 'hovedspring_forbudt' ); ?></strong></p></div><?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'theme_options' ); ?>
			<?php $settings = get_option( 'hovedspring_forbudt_theme_options' ); ?>
			<?php echo "\n"; ?>
			
			<?php foreach ( $theme_options as $option ) {
				switch ( $option['type'] ) {
					case 'text':
						if ( $option['title'] != '' ) :
							echo '<h3>' . $option['title'] . '</h3>';
						endif;
						if ( $option['text'] != '' ) :
							echo '<p>' . $option['text'] . '</p>';
						endif;
						break;
					case 'section_start':
						echo '<table class="form-table"><tbody>';
						break;
					case 'section_end':
						echo '</tbody></table>';
						break;
					case 'section_divider':
						echo '<tr valign="top"><td colspan="2"><hr /></td></tr>';
						break;
					case 'input':
						if ( $option['description'] != '' ) :
							$description = ' <span class="description">' . $option['description'] . '</span>';
						endif;
						
						echo '<tr valign="top">';
						echo '<th scope="row"><label for="' . theme_options_field_name( $option['id'] ) . '">' . $option['label'] . '</label></th>';
						echo '<td><input type="text" name="' . theme_options_field_name( $option['id'] ) . '" id="' . theme_options_field_name( $option['id'] ) . '" value="' . esc_attr( $settings[$option['id']] ) . '" class="regular-text" />' . $description . '</td>';
						echo '</tr>';
						break;
					case 'checkbox':
						if ( $option['description'] != '' ) :
							$description = '<p><span class="description">' . $option['description'] . '</span></p>';
						endif;
						
						echo '<tr valign="top">';
						echo '<th scope="row">' . $option['label'] . $description . '</th>';
						echo '<td>';
						$checkboxes = $option['options'];
						foreach ( $checkboxes as $checkbox ) {
							echo '<input type="checkbox" name="' . theme_options_field_name( $option['id'] . '_' . $checkbox['value'] ) . '" id="' . theme_options_field_name( $option['id'] . '_' . $checkbox['value'] ) . '" value="' . $checkbox['value'] . '" ' . ( $settings[$option['id'] . '_' . $checkbox['value']] == $checkbox['value'] ? 'checked="checked"' : '' ) . ' /><label for="' . theme_options_field_name( $option['id'] . '_' . $checkbox['value'] ) . '">' . $checkbox['label'] . '</label><br />';
						}
						echo '</td>';
						echo '</tr>';
						break;
					case 'radio':
						if ( $option['description'] != '' ) :
							$description = '<p><span class="description">' . $option['description'] . '</span></p>';
						endif;
						
						echo '<tr valign="top">';
						echo '<th scope="row">' . $option['label'] . $description . '</th>';
						echo '<td>';
						$radiobuttons = $option['options'];
						foreach ( $radiobuttons as $radiobutton ) {
							echo '<input type="radio" name="' . theme_options_field_name( $option['id'] ) . '" id="' . theme_options_field_name( $option['id'] ) . '" value="' . $radiobutton['value'] . '" ' . ( $settings[$option['id']] == $checkbox['value'] ? 'checked="checked"' : '' ) . ' /><label for="' . theme_options_field_name( $option['id'] ) . '">' . $radiobutton['label'] . '</label><br />';
						}
						echo '</td>';
						echo '</tr>';
						break;
					case 'textarea':
						if ( $option['description'] != '' ) :
							$description = '<p><span class="description">' . $option['description'] . '</span></p>';
						endif;
						
						echo '<tr valign="top">';
						echo '<th scope="row"><label for="' . theme_options_field_name( $option['id'] ) . '">' . $option['label'] . '</label>' . $description . '</th>';
						echo '<td><textarea name="' . theme_options_field_name( $option['id'] ) . '" id="' . theme_options_field_name( $option['id'] ) . '" rows="' . $option['rows'] . '" class="large-text">' . esc_textarea( $settings[$option['id']] ) . '</textarea></td>';
						echo '</tr>';
						break;
					case 'select':
						if ( $option['description'] != '' ) :
							$description = ' <span class="description">' . $option['description'] . '</span>';
						endif;
						
						echo '<tr valign="top">';
						echo '<th scope="row"><label for="' . theme_options_field_name( $option['id'] ) . '">' . $option['label'] . '</label></th>';
						echo '<td><select name="' . theme_options_field_name( $option['id'] ) . '" id="' . theme_options_field_name( $option['id'] ) . '">';
						$selectoptions = $option['options'];
						foreach ( $selectoptions as $selectoption ) {
							echo ' <option value="' . $selectoption['value'] . '" ' . ( $settings[$option['id']] == $selectoption['value'] ? 'selected="selected"' : '' ) . '>' . $selectoption['label'] . '</option>';
						}
						echo '</select/>' . $description . '</td>';
						echo '</tr>';
						break;
				}
			} ?>
			<p class="submit"><input type="submit" name="submit" value="<?php _e( 'Gem &aelig;ndringer', 'hovedspring_forbudt' ) ?>" class="button-primary" /></p>
		</form>
	</div>
<?php }

function theme_options_validate( $input ) {
	$theme_options = theme_options_array();
	
	foreach ( $theme_options as $option ) {
		switch ( $option['type'] ) {
			case 'input':
				$input[$option['id']] = wp_kses( $input[$option['id']], array( 'a' => array( 'href' => array(), 'title' => array() ), 'i' => array(), 'em' => array(), 'b' => array(), 'strong' => array() ) );
				break;
			case 'checkbox':
				$input[$option['id']] = wp_kses( $input[$option['id']] );
				break;
			case 'radio':
				$input[$option['id']] = wp_kses( $input[$option['id']] );
				break;
			case 'textarea':
				$input[$option['id']] = wp_kses( $input[$option['id']], array( 'a' => array( 'href' => array(), 'title' => array() ), 'span' => array( 'id' => array(), 'class' => array() ), 'i' => array(), 'em' => array(), 'b' => array(), 'strong' => array(), 'script' => array( 'type' => array() ) ) );
				break;
			case 'select':
				$input[$option['id']] = wp_kses( $input[$option['id']] );
				break;
		}
	}
	
	return $input;
}

function theme_options_init() {
	register_setting( 'theme_options', 'hovedspring_forbudt_theme_options', 'theme_options_validate' );
}

function theme_options_add_page() {
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', basename( __FILE__ ), 'theme_options_page' );
}

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' ); ?>