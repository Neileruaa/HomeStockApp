<?php


namespace App\Service;


use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class BarcodeManager {

    //TODO: Charger une classe quand la classe est crée !

    public function makeHTTPRequest(string $type, string $url) {
		$httpClient = HttpClient::create();
		$response = $httpClient->request($type, $url);
		$status = $response->getStatusCode();
		if ($status === 404) {
		    dd('ERROR 404 pas de page trouvé JE DOIS THROW QUELQUE CHOSE');
        }
		$content = $response->getContent();
		return $content;
	}

	public function getNameOfProduct($barcode): string
    {
        if ($product = $this->getProductFromBarcode($barcode)){
            return $product['product_name'];
        } else {
            $this->crawlNameOfProduct($barcode);
        }
    }

    //Crawl html Bad way
	public function crawlNameOfProduct ($barcode)
    {
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

    //Crawl html Bad way
    public function getImageOfProduct($barcode) {
		$crawler = new Crawler($this->makeHTTPRequest('GET', "https://product-open-data.com/gtin/".$barcode));
		$crawler = $crawler->filter('body');
		$crawler = $crawler->filter('img');

		return $crawler->getNode(0)->getAttribute('src');
	}

    //openFoodFact
    public function getProductFromBarcode($barcode): ?array
    {
        $json = $this->makeHTTPRequest('GET', 'http://fr.openfoodfacts.org/api/v0/produit/' . $barcode . '.json');
        $jsonToArray = json_decode($json, true);
        if ($jsonToArray['status'] === 1) {
            return  $jsonToArray['product'];
        }
        return null;
    }
}