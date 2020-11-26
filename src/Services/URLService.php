<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class URLService extends DataService {

    private $holydaysUrl = "https://kayaposoft.com/enrico/json/v2.0";
    private $client;

    public function __construct(HttpClientInterface $client){
        $this->client = $client;
    }

    public function setUrlForYearHolydays(int $year, string $country, string $region) {

        $API = $this->holydaysUrl . "?action=getHolidaysForYear&year=" .  $year  .  "&country="  .  $country  .  "&region="  .  $region  .  "&holidayType=all";
        
        parent::__construct($API, $this->client);
    }

    public function setUrlForSupportedCountries() {
        $API = $this->holydaysUrl . "?action=getSupportedCountries";
        
        parent::__construct($API, $this->client);
    }
}