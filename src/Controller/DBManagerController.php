<?php

namespace App\Controller;

use App\Entity\CountryYearHolidays;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DBManagerController extends AbstractController
{
    public function getData(string $countryCode, string $region, int $year): array
    {
        $record = $this->getDoctrine()
        ->getRepository(CountryYearHolidays::class)
        ->findOneBy([
            'countryCode' => $countryCode,
            'region' => $region,
            'year' => $year,
        ]);

        if(!$record){
            throw $this->createNotFoundException(
                'No record for '.$countryCode." ".$region." ".$year
            );
        }
        return $record->getHolidays();
    }

    public function postData(string $countryCode, string $region, int $year, array $holidays)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $record = new CountryYearHolidays();
        $record->setCountryCode($countryCode);
        $record->setRegion($region);
        $record->setYear($year);
        $record->setHolidays($holidays);

        $entityManager->persist($record);
        $entityManager->flush();

        return 'New record for '.$countryCode." ".$region." ".$year;
    }
}
