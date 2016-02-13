<?php
// Set Admin Panel Options
$options = array(	
	array( "type" => "optionsBody" ),
	array( "type" => "open" ),
	
	array( "name" => "Favicon",
	       "desc" => "Enter the URL to your own favicon file.",
	         "id" => $shortname."_favicon",
	       "type" => "upload",
	        "std" => "" ),
			
	array( "type" => "close" ),

	array( "type" => "close" )

);

function centro_add_admin() {
	global $themename, $shortname, $options;
	if ( isset( $_GET['page'] ) ) {
		if ( $_GET['page'] == basename(__FILE__) ) {
			if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					if ( isset( $value['id'] ) )
						update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ] )); 
				}
				foreach ($options as $value) {
					if ( isset( $value['id'] ) )
						if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ] ) ); } else { delete_option( $value['id'] ); } 
				}
				header("Location: admin.php?page=theme-options.php&saved=true");
				die;
			} else if( isset( $_REQUEST['action'] ) && 'reset' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					delete_option( $value['id'] ); 
				}
				header("Location: admin.php?page=theme-options.php&reset=true");
				die;
			}
		}
	}
	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'centro_admin');
}

function centro_add_init() {  
	$file_dir = get_bloginfo( 'template_directory' );  
	wp_enqueue_style( "theme-options", $file_dir . "/lib/styles/theme-options.css", false, "1.0", "all" );  
	wp_enqueue_style( "colorpicker", $file_dir . "/lib/styles/colorpicker.css", false, "1.0", "all" );  
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( "colorpicker-js", $file_dir . "/lib/js/colorpicker.js", false, "1.0" );  
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( "theme-options-js", $file_dir . "/lib/js/theme-options.js", false, "1.0" );  
}

add_action('admin_init', 'centro_add_init');
add_action('admin_menu', 'centro_add_admin');

function centro_admin() {
	global $themename, $shortname, $options;
	$i=0;
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="optionsMessage">'.$themename.' Settings Saved.</div>';
	if ( isset( $_REQUEST['reset'] ) ) echo '<div id="optionsMessage">'.$themename.' Settings Reseted.</div>';
	?>
	<div class="optionsWrapper">
		<form method="post">
			<div class="optionsHeader"><h2>Centro Themes</h2></div>
			<div class="optionsBar"><p><?php echo $themename; ?> Settings</p><p class="submit"><input name="save" type="submit" value="Save Changes" /></p></div>
				<?php foreach ($options as $value) {
					switch ( $value['type'] ) {
						case "open": ?>
							<?php break;
						case "close": ?>
							</div>
							<?php break;
						case 'text': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo htmlspecialchars(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'color': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input class="color" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'upload': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input class="optionsUpload" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<p class="submit"><input class="optionsUploadButton" type="button" value="Upload Image" /></p>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'textarea': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'select': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
									<?php foreach ($value['options'] as $option) { ?>
										<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
									<?php } ?>
								</select>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case "checkbox": ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<div class="optionsCheckbox">
									<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
									<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
									<?php echo $value['desc']; ?>
								</div>
								<div class="clear"></div>
							</div>
							<?php break;
						case "section":
							$i++; ?>
							<div class="optionsSection" id="<?php echo str_replace( ' ', '', strtolower( $value['name'] ) ); ?>">
							<?php break;
						case "menu": ?>
							<ul class="optionsMenu">
								<?php foreach ($value['items'] as $item) { ?>
									<li><a href="#<?php echo str_replace( ' ', '', strtolower( $item ) ); ?>" title="<?php echo $item; ?>" class="<?php echo str_replace( ' ', '', strtolower( $item ) ); ?>"><?php echo $item; ?></a></li>
								<?php } ?>
							</ul>
							<?php break;
						case "optionsBody": ?>
							<div class="optionsBody">
							<?php break;
					}
				} ?>
				<input type="hidden" name="action" value="save" />
			</form>
			<div class="clear"></div>
			<form method="post" class="optionsReset">
				<p class="submit">
					<input name="reset" type="submit" value="Reset Fields" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
		</div> 
<?php
}
?>