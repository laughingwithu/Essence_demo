<?php
require_once './Essence/lib/bootstrap.php';
$Essence = new fg\Essence\Essence( );

//Check to make sure a URL has been Set by the form

if (isset($_POST['url'])) {  
	$Media = $Essence->embed($_POST['url']);
	sleep(1);

// Check if an error occurs and stop the process if there is an exception
	If ( !$Media ) {
		$Exception = $Essence->lastError( );
		?>
		<div id="standard">
			<?php	echo '<p>I think we may have a problem, please try again.</p>', $Exception->getMessage( ); ?>
		</div>
	<?php 
		// If no error return the properties parsed by Essence
		} Else {?>
			<div id="standard">
				<h1>Return Standard properties</h1>
				<p>Type: <?php echo $Media->type; ?></p>
				<p>Title: <?php echo $Media->title;?></p>
				<p>Author: <?php echo $Media->authorName; ?></p>
				<p>Html: <?php echo $Media->html; ?></p>
				<p>Description: <?php echo $Media->description; ?></p>
				<p>Version: <?php echo $Media->version; ?></p>
				<p>ProviderName: <?php echo $Media->providerName; ?></p>
				<p>ProviderUrl: <?php echo $Media->providerUrl; ?></p>
				<p>Url: <?php echo $Media->url;?></p>
				<p>ThumbnailUrl: <?php echo $Media->thumbnailUrl; ?></p>
				<p>ThumbnailWith: <?php echo $Media->thumbnailWith; ?></p>
				<p>ThumbnailHeight: <?php echo $Media->thumbnailHeight; ?></p>
				<p>Width: <?php echo $Media->width; ?></p>
				<p>Height: <?php echo $Media->height; ?></p>
				<p>CacheAge: <?php echo $Media->cacheAge; ?></p>
			</div>
			<div id="array">
				<h1>Return everything in the Array for debug purposes</h1>
				<p><?php print_r ($Media); ?></p>
				</div>
	<?php } }?>