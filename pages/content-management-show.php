<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'content-management-show-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
if (isset($_POST['frm_Jntp_display']) && $_POST['frm_Jntp_display'] == 'yes')
{
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$Jntp_success = '';
	$Jntp_success_msg = FALSE;
	
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".Jntp_Table."
		WHERE `Jntp_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'jquery-news-ticker'); ?></strong></p></div><?php
	}
	else
	{
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			check_admin_referer('Jntp_form_show');
			
			$sSql = $wpdb->prepare("DELETE FROM `".Jntp_Table."`
					WHERE `Jntp_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			$Jntp_success_msg = TRUE;
			$Jntp_success = __('Selected record was successfully deleted.', 'jquery-news-ticker');
		}
	}
	
	if ($Jntp_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $Jntp_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Jquery news ticker', 'jquery-news-ticker'); ?>
	<a class="add-new-h2" href="<?php echo Jntp_adminurl; ?>&amp;ac=add"><?php _e('Add New', 'jquery-news-ticker'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".Jntp_Table."` order by Jntp_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<form name="frm_Jntp_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('News', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Group', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Display', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Expiration', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Order', 'jquery-news-ticker'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('News', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Group', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Display', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Expiration', 'jquery-news-ticker'); ?></th>
			<th scope="col"><?php _e('Order', 'jquery-news-ticker'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo stripslashes($data['Jntp_text']); ?>
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo Jntp_adminurl; ?>&amp;ac=edit&amp;did=<?php echo $data['Jntp_id']; ?>"><?php _e('Edit', 'jquery-news-ticker'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:_Jntp_delete('<?php echo $data['Jntp_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'jquery-news-ticker'); ?></a></span> 
						</div>
						</td>
						<td><?php echo $data['Jntp_group']; ?></td>
						<td><?php echo $data['Jntp_status']; ?></td>
						<td><?php echo substr($data['Jntp_dateend'],0,10); ?></td>
						<td><?php echo $data['Jntp_order']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="5" align="center"><?php _e('No records available.', 'jquery-news-ticker'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('Jntp_form_show'); ?>
		<input type="hidden" name="frm_Jntp_display" value="yes"/>
		<input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'content-management-show-nonce' ); ?>"/>
      </form>	
	  <div class="tablenav bottom">
	  	<a href="<?php echo Jntp_adminurl; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'jquery-news-ticker'); ?>" /></a>
	  	<a target="_blank" href="<?php echo Jntp_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'jquery-news-ticker'); ?>" /></a>
	  	<a target="_blank" href="<?php echo Jntp_FAV; ?>"><input class="button button-primary" type="button" value="<?php _e('Short Code', 'jquery-news-ticker'); ?>" /></a>
	  </div>
	</div>
</div>