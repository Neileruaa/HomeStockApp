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

	public function getNameOfProduct($barcode) {
		$crawler = new Crawler($this->makeHTTPRequest('GET', "https://product-open-data.com/gtin/".$barcode));
		$crawler = $crawler->filter('body');
		$crawler = $crawler->filter('td')->each(function (Crawler $node, $i){
			if ($i == 1){
				preg_match_all('#<b>Commercial name</b> :(.*?) <br>#', $node->html(), $matches);
				return $matches[1][0];
			}
		});
		return array_filter($crawler)[1];
	}

	public function getImageOfProduct($barcode) {
		$crawler = new Crawler($this->makeHTTPRequest('GET', "https://product-open-data.com/gtin/".$barcode));
		$crawler = $crawler->filter('body');
		$crawler = $crawler->filter('img');

		return $crawler->getNode(0)->getAttribute('src');
	}
}