<?php 
	$path = (isset($_GET['path'])) ? $_GET['path'] : "";
	 
	global $SITEURL;
;?>

<script>
if(document.querySelector(".uploadform")){document.querySelector(".uploadform").outerHTML = `
<div style="background:#182227; padding:10px; border-radius:5px; color:#fff;">
	<h3 style="color:#fff; text-shadow:0 0 0;"><?php echo i18n_r('FILE_UPLOAD');?></h3>

	<form action="upload.php?path=<?php echo $path ;?>" method="POST" enctype="multipart/form-data">
	<div style="background:rgba(0,0,0,0.4); padding:10px; box-sizing:border-box; border:solid 1px #ddd; border-radius:5px;">
		<input type="file" name="filer[]" multiple style="width:100%; text-overflow:ellipsis;"> 
	</div>

<?php if(@$jsonSettings[0]['resolutionOn']!== 'true'):?>

    <div class="compress" style="background: rgba(0,0,0,0.4); width:100%; padding:10px; border:solid 1px #fff; margin:10px 0; color:#fff; box-sizing:border-box; border-radius:5px;">
   
		<label for="compress" style="color:#fff; margin-bottom:10px; margin-top:5px; sfont-size:11px;"><?php echo i18n_r('uploaderExt/LANG_Resize_Image');?></label>
		<input type="checkbox" name="compress">
		
		<input type="text" placeholder="<?php echo i18n_r('uploaderExt/LANG_Width_In_Pixels');?>" style="width:100%; display:block; margin:10px 0; padding:5px; box-sizing:border-box;" name="compressvalue">
    </div>

<?php else :?>

    <div class="compress" style="background: rgba(0,0,0,0.4); width:100%; padding:10px; border:solid 1px #fff; margin:10px 0; color:#fff; box-sizing:border-box; border-radius:5px; display:none;">
   
		<label for="compress" style="color:#fff; margin-bottom:10px; margin-top:5px; sfont-size:11px;"><?php echo i18n_r('uploaderExt/LANG_Resize_Image');?> </label>
		<input type="checkbox" name="compress" checked>
		
		<input type="text" placeholder="<?php echo i18n_r('uploaderExt/LANG_Width_In_Pixels');?>" style="width:100%; display:block; margin:10px 0; padding:5px; box-sizing:border-box;" value="<?php echo @$jsonSettings[0]['resolutionWidth'];?>" name="compressvalue">
    </div>

<?php endif;?>
     
     <input type="submit" style="width:100%; height:40px; border:none;color:#fff;border-radius:5px; border:none; background:#CF3805; margin-top:10px;" value="<?php i18n('UPLOAD'); ?>" name="fileUploader"></form></div>`;}
</script>
 
<script>
	document.querySelector('input[name="compress"]').addEventListener('click',function(){
		if(this.checked == true){
			document.querySelector('.webp').style.display="none";
		}else{
			document.querySelector('.webp').style.display="block";
		}
	});

	document.querySelector('input[name="webp"').addEventListener('click',function(){
		if(this.checked == true){
			document.querySelector('.compress').style.display="none";
		}else{
			document.querySelector('.compress').style.display="block";
		}
	});
</script>

<?php
 
$ds   = DIRECTORY_SEPARATOR;
$path = (isset($_GET['path'])) ? $_GET['path'] : "";

$storeFolder = '../data/uploads/'.$path;   

if(isset($_POST['fileUploader'])){

	if (!empty($_FILES)) {

		$ds   = DIRECTORY_SEPARATOR;
		$path = (isset($_GET['path'])) ? $_GET['path'] : "";
		$storeFolder = '../data/uploads/'.$path.'/';   
		$count = 0;

		foreach($_FILES['filer']['tmp_name'] as $key => $tmp_name){

			$tempFile = $_FILES['filer']['tmp_name'][$count];
			$basename = basename($_FILES['filer']['name'][$count]);
			$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
			$filetype = finfo_file($fileinfo, $tempFile);

			$allowedTypes = [
				'audio/aac' => 'aac',
				'application/x-abiword' => 'aac',
				'application/x-freearc' => 'arc',
				'image/avif' => 'avif',
				'video/x-msvideo' => 'avi',
				'application/vnd.amazon.ebook' => 'azw',
				'image/bmp' => 'bmp',
				'text/css' => 'css',
				'text/csv' => 'csv',
				'application/msword' => 'doc',
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
				'application/vnd.ms-fontobject' => 'eot',
				'application/gzip' => 'gz',
				'image/gif' => 'gif',
				'image/vnd.microsoft.icon' => 'ico',
				'image/jpeg' => 'jpg',
				'image/jpeg' => 'jpeg',
				'audio/mpeg' => 'mp3',
				'video/mp4' => 'mp4',
				'video/mpeg' => 'mpeg',
				'application/vnd.oasis.opendocument.presentation' => 'odp',
				'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
				'application/vnd.oasis.opendocument.text' => 'odt',
				'audio/ogg' => 'ogg',
				'video/ogg' => 'ogv',
				'application/ogg' => 'ogx',
				'audio/opus' => 'opus',
				'font/otf' => 'otf',
				'image/png' => 'png',
				'application/pdf' => 'pdf',
				'application/vnd.ms-powerpoint' => 'ppt',
				'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
				'application/vnd.rar' => 'rar',
				'application/rtf' => 'rtf',
				'image/svg+xml' => 'svg',
				'application/x-tar' => 'tar',
				'image/tiff' => 'tif',
				'image/tiff' => 'tiff',
				'font/ttf' => 'ttf',
				'text/plain' => 'txt',
				'audio/wav' => 'wav',
				'audio/webm' => 'weba',
				'audio/webm' => 'webm',
				'image/webp' => 'webp',
				'font/woff' => 'woff',
				'font/woff2' => 'woff2',
				'application/zip' => 'zip',
				'video/3gpp' => '3gp',
				'application/x-7z-compressed' => '7z',
				'video/quicktime' => 'mov',
			];

			$extension = $allowedTypes[$filetype];

			#check file support

			if(!in_array($filetype, array_keys($allowedTypes))) {
				echo'<div class="success-glass" style="display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100vh; background-color:rgba(0,0,0,0.9); z-index:2;"><div style="text-align:center"><img src="'.$SITEURL.'/plugins/uploaderExt/img/error.svg" style="width:16px; vertical-align:middle;"> <h3 style="color:#fff; text-align:center; text-shadow:unset;">'. i18n_r('uploaderExt/LANG_Unsupported_File') .'</h3></div></div>';

				echo("<meta http-equiv='refresh' content='3'>");

				die();
			}

			## $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
			$targetPath = $storeFolder;
			$targetFile =  $targetPath.$_FILES['filer']['name'][$count];  

			##check space 
			$targetNameWithoutSpace = pathinfo($_FILES['filer']['name'][$count])['filename'];
			$targetNameWithoutSpace  = strtolower($targetNameWithoutSpace);
			$targetNameWithoutSpace  = str_replace(' ', '-', $targetNameWithoutSpace);
			$targetNameWithoutSpace  = preg_replace('/[^0-9a-z\-]+/', '', $targetNameWithoutSpace);
			$targetNameWithoutSpace  = preg_replace('/[\-]+/', '-', $targetNameWithoutSpace);
			$targetNameWithoutSpace = trim($targetNameWithoutSpace,'-');

			$name = pathinfo($targetNameWithoutSpace,PATHINFO_FILENAME);
			$targetFile = $targetPath.$name.'.'.$extension;

			#check file exist 
			if(file_exists($targetFile)){ 
			   $name = pathinfo($targetNameWithoutSpace,PATHINFO_FILENAME);
				$targetFile = $targetPath.$name.'-'.rand(1,4000).'.'.$extension;
			}

			#upload files
			move_uploaded_file($tempFile,$targetFile); 

			#if compress used
			if(isset($_POST['compress'])){
				$compressUser = $_POST['compressvalue'];
				$original = $targetFile;
				$original_dimensions = getimagesize($original);
				$width = $original_dimensions[0];
				$height = $original_dimensions[1];
				$aspect = $width/$compressUser;
				$new_width = $compressUser;
				$new_height = $height/$aspect;
				$small = imagecreatetruecolor($new_width, $new_height);

				if(exif_imagetype($targetFile) == IMAGETYPE_JPEG){
					$source = imagecreatefromjpeg($original);
					imagecopyresampled($small, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($small, $targetFile);
				};

				if(exif_imagetype($targetFile) == IMAGETYPE_PNG){
					imagealphablending($small, false);
					imagesavealpha($small, true);
					$transparent = imagecolorallocatealpha($small, 255, 255, 255, 127);
					imagefilledrectangle($small, 0, 0, $new_width, $new_height, $transparent);
					$src_w = imagesx($small);
					$src_h = imagesy($small);

					$source = imagecreatefrompng($original);
					imagecopyresampled($small, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagepng($small, $targetFile);
				};
				 
				if(exif_imagetype($targetFile) == IMAGETYPE_GIF){
					$source = imagecreatefromgif($original);
					imagecopyresampled($small, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagegif($small, $targetFile);
				};
			};
				
			$count=$count + 1; 
							
		};

	};

	echo '<div class="updated" style="display: block !important; grid-column:1/3"><p><img src="'.$SITEURL.'/plugins/uploaderExt/img/success.svg" style="width:16px; vertical-align:middle;"> '.i18n_r('FILE_SUCCESS_MSG').'</p></div>';

	echo '<script>document.querySelector(".bodycontent").prepend(document.querySelector(".updated"))</script>';

	echo("<meta http-equiv='refresh' content='3'>");

}
 
?>