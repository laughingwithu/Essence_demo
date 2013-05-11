<?php
require_once './Essence/lib/bootstrap.php';

class EssenceDemo {
	public function _GetEssence($url) {
		$Essence = new fg\Essence\Essence( );
		if (filter_var($url, FILTER_VALIDATE_URL)) {  
			$Media = $Essence->embed($url);
			sleep(1);
			echo "<div class='first-row'>";
			// If essence throws an error stop process and provide the error.
			If ( !$Media ) {
				$Exception = $Essence->lastError( );
				echo '<div class="error"><p>I think we may have a problem, please try again.</p><p>', $Exception->getMessage( ),'</p></div>'; 
			}
			else {
			  $this->_insertWmode($Media);
			  $this->_printResults($Media);
			} 
		}
		else {
			echo '<div class="error"><p>Please ensure a correct url is inputted. This form requires the full URL to be included!</p></div>';
		}
		echo "</div>";
	}
	// Ensures that Iframes set the Wmode to opaque to resolve z-index issues with embedded videos
	private function _insertWmode($Media) {
		if (isset($Media->html) and $Media->type == "video") {
		$dom = new DOMDocument();
		$dom->loadHTML($Media->html);

		$ifr = $dom->getElementsByTagName('iframe')->item(0);
		$src = rtrim($ifr->getAttribute('src'), '&') . '&wmode=opaque';
		$ifr->setAttribute('src', $src);
		
		$Media->html = $dom->saveHtml();
		}
		else {
			// Nothing to do
		}
	} 
	private function _printResults($Media) {
		echo "<div class='first'>
			<h3>Return Standard properties</h3>
			<p>Type: $Media->type </p>
			<p>Title: $Media->title </p>
			<p>Author: $Media->authorName </p>
			<p>Html: <div class='responsive-wrap'><div class='responsive'> $Media->html </div></div></p>
			<p>Description:$Media->description  </p>
			<p>Version: $Media->version </p>
			<p>ProviderName: $Media->providerName </p>
			<p>ProviderUrl: $Media->providerUrl </p>
			<p>Url: $Media->url </p>
			<p>ThumbnailUrl: $Media->thumbnailUrl </p>
			<p>ThumbnailWith: $Media->thumbnailWith </p>
			<p>ThumbnailHeight: $Media->thumbnailHeight </p>
			<p>Width: $Media->width </p>
			<p>Height: $Media->height </p>
			<p>CacheAge: $Media->cacheAge </p>
		</div>
		<div class='second'>
			<h3>Return everything in the Array for debug purposes</h3>
			<p>",print_r ($Media),"</p>
		</div>";
	}
}

$EssenceDemo = new EssenceDemo();
$EssenceDemo->_GetEssence($_POST['url']);	
?>