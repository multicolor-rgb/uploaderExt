<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge('uploaderExt') || i18n_merge('uploaderExt', 'en_US');

# register plugin
register_plugin(
	$thisfile, //Plugin id
	'UploaderExt', 	//Plugin name
	'3.0', 		//Plugin version
	'Multicolor',  //Plugin author
	'https://discord.gg/vkySHPxpg2', //author website
	i18n_r('uploaderExt/LANG_Description'), //Plugin description
	'plugins', //page type - on which admin tab to display
	'uploaderExtSettings'  //main function (administration)
);

add_action('footer', 'uploaderExt');

$jsonSettings = json_decode(@file_get_contents(GSPLUGINPATH . 'uploaderExt/settings.json'), true);

function uploaderExt()
{
	global $jsonSettings;

	include GSPLUGINPATH . 'uploaderExt/uploaderExtFunction.inc.php';
};

add_action('plugins-sidebar', 'createSideMenu', array($thisfile, i18n_r('uploaderExt/LANG_Settings')));

function uploaderExtSettings()
{
	global $jsonSettings;
	include GSPLUGINPATH . 'uploaderExt/settings.inc.php';
};;
