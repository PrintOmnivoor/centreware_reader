<?php

function clean($str) {
  $str = str_replace("&nbsp;", '', $str);
  $str = preg_replace('/\s+/', ' ',$str);
  $str = trim($str);
  return $str;
}

function get_centreware() {
	//$url = "https://centreware.lan/counters/usage.php";
	$url = "https://192.168.1.100/counters/usage.php";	

	// Initialize session and set URL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);

	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Get the response and close the channel.
	$response = clean(curl_exec($ch));
	curl_close($ch);
	//echo $response;

	// Create a new DomDocument object
	$dom = new DomDocument;
	//Load the HTML
	$dom->loadHTML($response);
	//Create a new XPath object
	$xpath = new DomXPath($dom);

	//Query all <td> nodes containing specified class name
	$nodes = $xpath->query("//td");
	$centreware = [];

	//Traverse the DOMNodeList object to output each DomNode's nodeValue
	foreach ($nodes as $i => $node) {
		//echo "Node($i): ", $node->nodeValue, "\n";
		$currentValue = $node->nodeValue;

		if(isset($node->nextSibling)) {
			$nextValue = $node->nextSibling->nodeValue;

			//echo $currentValue."<br>";

			if($currentValue == "Black Copied Impressions") {

				$centreware["black_copies"] = $nextValue;

			} else if ($currentValue == "Color Copied Impressions") {

				$centreware["color_copies"] = $nextValue;

			} else if ($currentValue == "Black Printed Impressions") {

				$centreware["black_prints"] = $nextValue;

			} else if ($currentValue == "Color Printed Impressions") {

				$centreware["color_prints"] = $nextValue;

			}
		}
	}

	return count($centreware) ? $centreware : false;

}
