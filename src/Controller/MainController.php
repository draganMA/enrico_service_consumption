<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Controller\BadRequest;
use App\Controller\DBManagerController;

use App\Services\URLService;

class MainController extends AbstractController implements BadRequest
{

    private static array $API_data;
    private URLService $urlService;
    private DBManagerController $dbManager;

    public function __construct(URLService $urlService, DBManagerController $dbManager){
        $this->urlService = $urlService;
        $this->dbManager = $dbManager;
    }

    /**
    *@Route("/") 
    */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    public function selectCountry(): Response 
    {
        $regions = [];
        $this->urlService->setUrlForSupportedCountries(); 
        $API_data = $this->urlService->getData();

        return $this->render('holidays/_select_country.html.twig', [
            'results' => $API_data,
        ]);
    }

    /**
     * @Route("/country", name="country_holydays", methods="get")
     */
    public function getCountryHolidays(Request $request): Response
    {
        // get data from template 
        $selectedCountryRegionYear = $request->get('selectCountryRegionYear');
        $selectedCountryObject = json_decode($selectedCountryRegionYear[0], true);
        $selectedRegion = isset($selectedCountryRegionYear['region']) ? $selectedCountryRegionYear['region'] : "";
        $selectedYear = $selectedCountryRegionYear['year'];

        try{
            // try to fetch data from database
            $API_data = $this->dbManager->getData($selectedCountryObject['countryCode'], $selectedRegion, $selectedYear);
            $origin = "local database";
        }
        catch(\Exception | createNotFoundException $e){
            // country code is undefined if no country was selected
            if(!isset($selectedCountryObject['countryCode'])){
                // render the bad request template
                $response = $this->handleBadRequest("Bad data", "\"Select a country\" or \"Type a year\" field");
                return new Response($response);
            }

            // dbManager failed, fetch data from API
            $this->urlService->setUrlForYearHolydays($selectedYear, $selectedCountryObject['countryCode'], $selectedRegion);
            $API_data = $this->urlService->getData();
            $origin = "API";

            // check for bad responses
            if(isset($API_data['error'])){
                // render bad request template
                $response = $this->handleBadRequest($API_data['error'], $selectedCountryObject['fullName']);
                return new Response($response);
            }
            // persist fetched data
            $this->dbManager->postData($selectedCountryObject['countryCode'], $selectedRegion, $selectedYear, $API_data);   
        }
        catch(\TypeError $e){
            $response = $this->handleBadRequest("Bad data", "\"Select a country\" or \"Type a year\" field");
            return new Response($response);
        }

        $processedData = $this->getHolidaysByMonth($API_data);

        return $this->render('holidays/country-holidays.html.twig', [
            'selected_year' => $selectedYear,
            'selected_country' => str_replace('_', ' ', $selectedCountryObject['fullName']),
            'selected_region' => $selectedRegion,
            'total_free_days' => $processedData['publicHolidaysAmount'] + $processedData['freeDaysAmount'],
            'public_holidays' => $processedData['publicHolidaysAmount'],
            'holidays_by_month' => $processedData['monthsAsKeys'],
            'standard_holidays_object' => $API_data,
            'origin' => $origin,
        ]);
    }

    private function getHolidaysByMonth(array $holidaysArray): array
    {
        $returnedArray = [];
        $freeDays = $publicHolidays = 0;
        $key=$holidaysArray[0]['date']['month'];

        for($i=0, $y=0; $i<count($holidaysArray); $i++)
        {
            if($holidaysArray[$i]['holidayType'] != 'extra_working_day')
            {
                ($holidaysArray[$i]['holidayType'] == 'public_holiday') ? $publicHolidays++ : $freeDays++;
            }

            if($holidaysArray[$i]['date']['month'] !== $key)
            {
                $key = $holidaysArray[$i]['date']['month'];
                $y = 0;
            }
            $returnedArray['monthsAsKeys'][$key][$y++] = $holidaysArray[$i];
        }
        $returnedArray['publicHolidaysAmount'] = $publicHolidays;
        $returnedArray['freeDaysAmount'] = $freeDays;
        return $returnedArray;
    }

    public function handleBadRequest($message, $args)
    {
        return $this->renderView('holidays/handle-country-holidays-bad-request.html.twig', [
            'error_message' => $message,
            'args' => $args,
        ]);
    }
}