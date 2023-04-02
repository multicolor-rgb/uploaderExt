<h3>UploaderExt Settings</h3>

<form method="post" action="#">
	<label style="background: #000;display: flex;justify-content: space-between; color:#fff;padding: 10px;box-sizing: border-box;">
		Turn On Auto Resize?
		<input type="checkbox" name="resolution" value="true" <?php echo (@$jsonSettings[0]['resolutionOn']== 'true' ? 'checked':'');?> >
	</label>

	<label style="background: #fafafa;border:solid 1px #ddd;display: flex;justify-content: space-between; color:#111;padding: 10px;box-sizing: border-box;margin-top:10px;">
		Resize Image by Width in Pixels on Upload (example 1280)
	</label>

	<input type="text" pattern="[0-9]+" placeholder="width resolution" style="width:100%;padding:10px;box-sizing: border-box;margin:10px 0;" name="resolutionwidth" <?php echo (@$jsonSettings[0]['resolutionWidth']!== '' ? "value='".@$jsonSettings[0]['resolutionWidth'] ."'":'') ?> >

	<input value="Save" type="submit" style="padding: 10px 15px;background: #000;border-radius:0;border:none;color: #fff;" name="saveSettingsEXT">
</form>

<div id="paypal" style="margin-top:10px;background: #fafafa;border:solid 1px #ddd;padding: 10px;box-sizing: border-box;text-align: center;">
	<p style="margin-bottom:10px;">If you want see new plugins, buy me a ☕ :)  </p>
	<a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"  /></a>
</div>

<?php 
if(isset($_POST['saveSettingsEXT'])){

	$resolutionOn = $_POST['resolution'] ?? '';
	$resolutionWidth = $_POST['resolutionwidth'] ?? '';
	$webP = $_POST['webp'] ?? '';

	$settings = [];
	array_push($settings, array('resolutionOn'=> $resolutionOn, 'resolutionWidth'=> $resolutionWidth) );

	$js = json_encode($settings,true);

	file_put_contents(GSPLUGINPATH.'uploaderExt/settings.json', $js);

	echo("<meta http-equiv='refresh' content='0'>");

}
;?>