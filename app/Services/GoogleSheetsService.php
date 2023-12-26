<?php

namespace App\Services;

use App\Exceptions\GoogleSheetsException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GoogleSheetsService
{


    public function __construct(protected Client $client)
    {

    }

    /**
     * @throws GoogleSheetsException
     */
    public function fetchData(string $url): ResponseInterface
    {
        try {

            return $this->client->get($url);
        } catch (\Exception $e) {
            throw new GoogleSheetsException($e->getMessage(), $e->getCode(), $e);
        }

    }

}
