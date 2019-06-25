<?php


namespace App\Service;


use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class BarcodeManager {
	public function makeHTTPRequest(string $type, string $url) {
		$httpClient = HttpClient::create();
		$response = $httpClient->request($type, $url);
		$content = $response->getContent();
		return $content;
	}


	public function getNameOfProduct(string $type, string $url) {
		$crawler = new Crawler($this->makeHTTPRequest($type, $url));
		$crawler = $crawler->filter('body');
		$crawler = $crawler->filter('td')->each(function (Crawler $node, $i){
			if ($i == 1){
//				dd($this->find_between($node->html(), strip_tags("<b>Commercial name</b> :"), strip_tags(" <br>")));
				preg_match_all('#<b>Commercial name</b> :(.*?) <br>#', $node->html(), $matches);
				return $matches[1][0];
			}
		});
		return array_filter($crawler)[1];
	}
}