<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'content-management-add-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$Jntp_errors = array();
$Jntp_success = '';
$Jntp_error_found = FALSE;

// Preset the form fields
$form = array(
	'Jntp_text' => '',
	'Jntp_link' => '',
	'Jntp_order' => '',
	'Jntp_status' => '',
	'Jntp_date' => '',
	'Jntp_group' => '',
	'Jntp_dateend' => '',
	'Jntp_id' => ''
);

// Form submitted, check the data
if (isset($_POST['Jntp_form_submit']) && $_POST['Jntp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('Jntp_form_add');
	
	$form['Jntp_text'] = isset($_POST['Jntp_text']) ? wp_filter_post_kses($_POST['Jntp_text']) : '';
	if ($form['Jntp_text'] == '')
	{
		$Jntp_errors[] = __('Please enter your ticker news.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}
	
	$form['Jntp_link'] = isset($_POST['Jntp_link']) ? sanitize_text_field($_POST['Jntp_link']) : '';
	$form['Jntp_link'] = esc_url_raw( $form['Jntp_link'] );
	if ($form['Jntp_link'] == '')
	{
		$Jntp_errors[] = __('Please enter your link.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}

	$form['Jntp_order'] = isset($_POST['Jntp_order']) ? sanitize_text_field($_POST['Jntp_order']) : '';
	if ($form['Jntp_order'] == '')
	{
		$Jntp_errors[] = __('Please enter your display order.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}
	if(!is_numeric($form['Jntp_order'])) { $form['Jntp_order'] = 0; }
	
	$form['Jntp_status'] = isset($_POST['Jntp_status']) ? sanitize_text_field($_POST['Jntp_status']) : '';
	if ($form['Jntp_status'] == '')
	{
		$Jntp_errors[] = __('Please select your display status.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}
	if($form['Jntp_status'] != "YES" && $form['Jntp_status'] != "NO")
	{
		$form['Jntp_status'] = "YES";
	} 
		
	$form['Jntp_group'] = isset($_POST['Jntp_group']) ? sanitize_text_field($_POST['Jntp_group']) : '';
	if ($form['Jntp_group'] == '')
	{
		$Jntp_errors[] = __('Please select available group for your news.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}
	
	$form['Jntp_dateend'] = isset($_POST['Jntp_dateend']) ? sanitize_text_field($_POST['Jntp_dateend']) : '';
	if ($form['Jntp_dateend'] == '')
	{
		$Jntp_errors[] = __('Please enter the expiration date in this format YYYY-MM-DD.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}
	if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $form['Jntp_dateend'])) 
	{
		$Jntp_errors[] = __('Please enter the expiration date in this format YYYY-MM-DD.', 'jquery-news-ticker');
		$Jntp_error_found = TRUE;
	}

	//	No errors found, we can add this Group to the table
	if ($Jntp_error_found == FALSE)
	{
		$Jntp_date = date('Y-m-d H:i:s');
		$sql = $wpdb->prepare(
			"INSERT INTO `".Jntp_Table."`
			(`Jntp_text`, `Jntp_link`, `Jntp_order`, `Jntp_status`, `Jntp_date`, `Jntp_group`, `Jntp_dateend`)
			VALUES(%s, %s, %s, %s, %s, %s, %s)",
			array($form['Jntp_text'], $form['Jntp_link'], $form['Jntp_order'], $form['Jntp_status'], $Jntp_date, $form['Jntp_group'], $form['Jntp_dateend'])
		);
		$wpdb->query($sql);

		$Jntp_success = __('New details was successfully added.', 'jquery-news-ticker');
		
		// Reset the form fields
		$form = array(
			'Jntp_text' => '',
			'Jntp_link' => '',
			'Jntp_order' => '',
			'Jntp_status' => '',
			'Jntp_date' => '',
			'Jntp_group' => '',
			'Jntp_dateend' => '',
			'Jntp_id' => ''
		);
	}
}

if ($Jntp_error_found == TRUE && isset($Jntp_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $Jntp_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($Jntp_error_found == FALSE && strlen($Jntp_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $Jntp_success; ?> <a href="<?php echo Jntp_adminurl; ?>"><?php _e('Click here', 'jquery-news-ticker'); ?></a> <?php _e('to view the details', 'jquery-news-ticker'); ?></strong></p>
	  </div>
	  <?php
	}
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Jquery news ticker', 'jquery-news-ticker'); ?></h2>
	<form name="Jntp_form" method="post" action="#" onsubmit="return _Jntp_submit()"  >
      <h3><?php _e('Add details', 'jquery-news-ticker'); ?></h3>
      
		<label for="tag-a"><?php _e('News', 'jquery-news-ticker'); ?></label>
		<textarea name="Jntp_text" id="Jntp_text" cols="90" rows="2"></textarea>
		<p><?php _e('Please enter your ticker news.', 'jquery-news-ticker'); ?></p>
		
		<label for="tag-a"><?php _e('Link', 'jquery-news-ticker'); ?></label>
		<input name="Jntp_link" type="text" id="Jntp_link" value="#" size="90" maxlength="1024" />
		<p><?php _e('Please enter your link.', 'jquery-news-ticker'); ?></p>
		
		<label for="tag-a"><?php _e('Order', 'jquery-news-ticker'); ?></label>
		<input name="Jntp_order" type="text" id="Jntp_order" value="1" size="20" maxlength="3" />
		<p><?php _e('Please enter your display order.', 'jquery-news-ticker'); ?></p>
	  
		<label for="tag-a"><?php _e('Display', 'jquery-news-ticker'); ?></label>
		<select name="Jntp_status" id="Jntp_status">
			<option value='YES' selected="selected">Yes</option>
			<option value='NO'>No</option>
		</select>
		<p><?php _e('Please select your display status.', 'jquery-news-ticker'); ?></p>
		
		<label for="tag-a"><?php _e('Group', 'jquery-news-ticker'); ?></label>
	    <select name="Jntp_group" id="Jntp_group">
			<option value=''>Select</option>
			<option value='GROUP1' selected="selected">GROUP1</option>
			<option value='GROUP2'>GROUP2</option>
			<option value='GROUP3'>GROUP3</option>
			<option value='GROUP4'>GROUP4</option>
			<option value='GROUP5'>GROUP5</option>
			<option value='GROUP6'>GROUP6</option>
			<option value='GROUP7'>GROUP7</option>
			<option value='GROUP8'>GROUP8</option>
			<option value='GROUP9'>GROUP9</option>
			<option value='GROUP10'>GROUP10</option>
		</select>
		<p><?php _e('Please select available group for your news.', 'jquery-news-ticker'); ?></p>
		
		<label for="tag-title"><?php _e('Expiration date', 'jquery-news-ticker'); ?></label>
		<input name="Jntp_dateend" type="text" id="Jntp_dateend" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.', 'jquery-news-ticker'); ?></p>
	  
      <input name="Jntp_id" id="Jntp_id" type="hidden" value="">
      <input type="hidden" name="Jntp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'jquery-news-ticker'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_Jntp_redirect()" value="<?php _e('Cancel', 'jquery-news-ticker'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_Jntp_help()" value="<?php _e('Help', 'jquery-news-ticker'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('Jntp_form_add'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'content-management-add-nonce' ); ?>"/>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'jquery-news-ticker'); ?>
	<a target="_blank" href="<?php echo Jntp_FAV; ?>"><?php _e('click here', 'jquery-news-ticker'); ?></a>
</p>
</div>