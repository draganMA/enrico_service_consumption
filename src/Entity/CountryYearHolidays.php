<?php

namespace App\Entity;

use App\Repository\CountryYearHolidaysRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryYearHolidaysRepository::class)
 */
class CountryYearHolidays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="array")
     */
    private $holidays = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getHolidays(): ?array
    {
        return $this->holidays;
    }

    public function setHolidays(array $holidays): self
    {
        $this->holidays = $holidays;

        return $this;
    }
}
