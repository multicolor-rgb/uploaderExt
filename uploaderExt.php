<?php

	# get correct id for plugin
	$thisfile=basename(__FILE__, ".php");
 
	# register plugin
	register_plugin(
		$thisfile, //Plugin id
		'UploaderExt', 	//Plugin name
		'2.0', 		//Plugin version
		'Multicolor',  //Plugin author
		'https://discord.gg/vkySHPxpg2', //author website
		'Uploader with image resize', //Plugin description
		'plugins', //page type - on which admin tab to display
		'uploaderExtSettings'  //main function (administration)
	);

	add_action('footer','uploaderExt');

	$jsonSettings = json_decode(@file_get_contents(GSPLUGINPATH.'uploaderExt/settings.json'),true);

	function uploaderExt(){
		global $jsonSettings;
	 
		include GSPLUGINPATH.'uploaderExt/uploaderExtFunction.inc.php';
	};

	add_action('plugins-sidebar','createSideMenu',array($thisfile,'UploaderExt Settings'));

	function uploaderExtSettings(){
		global $jsonSettings;
		include GSPLUGINPATH.'uploaderExt/settings.inc.php';
	};

;?>