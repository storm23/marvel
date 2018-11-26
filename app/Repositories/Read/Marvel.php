<?php
namespace Stormz23\Marvel\Repositories\Read;

use GuzzleHttp\Client;

class Marvel
{
    private $apiPublicKey, $apiPrivateKey;

	public function __construct($apiPublicKey, $apiPrivateKey)
	{
        $this->apiPublicKey = $apiPublicKey;
        $this->apiPrivateKey = $apiPrivateKey;
	}

    private function get($url, array $query = [])
    {
        $ts = time();
		$hash = md5($ts.$this->apiPrivateKey.$this->apiPublicKey);

		$query = array_merge($query, [
			'apikey' 	=> $this->apiPublicKey,
			'ts' 		=> $ts,
			'hash' 		=> $hash
		]);

		$client = new Client([

            'base_uri' => config('services.marvel.uri'),
            'timeout' => config('services.marvel.timeout')
        ]);

        $response = $client->request('GET', $url, ['query' => $query]);
        $body = $response->getBody();
        $json = json_decode($body, true);

        return $json['data']['results'];
    }

	public function getAllCharacters($offset = 0, $limit = 100)
	{
		$url = '/v1/public/characters';
		$params = [
			'limit' => $limit,
			'offset' => $offset
		];

		return $this->get($url, $params);
	}

	public function getAllSeries($offset = 0, $limit = 100)
	{
		$url = '/v1/public/series';
		$params = [
			'limit' => $limit,
			'offset' => $offset
		];

		return $this->get($url, $params);
	}

	public function getSerieCharacters($marvelId, $offset = 0, $limit = 100)
	{
		$url = sprintf('/v1/public/series/%s/characters', $marvelId);
		$params = [
			'limit' => $limit,
			'offset' => $offset
		];

		return $this->get($url, $params);
	}
}
