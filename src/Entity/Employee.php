<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Exception;


class Employee
{
    public const DEFAULT_YEARLY_VACATION_DAYS = 26;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $dateOfBirth;

    /**
     * @var
     */
    private $contractStartDate;
    /**
     * @var
     */
    private $specialVacationDays;


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTime $dateOfBirth
     * @return $this
     */
    public function setDateOfBirth(DateTime $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getContractStartDate(): ?DateTime
    {
        return $this->contractStartDate;
    }

    /**
     * @param DateTime $contractStartDate
     * @return $this
     */
    public function setContractStartDate(DateTime $contractStartDate): self
    {
        $this->contractStartDate = $contractStartDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSpecialVacationDays(): ?int
    {
        return $this->specialVacationDays;
    }

    /**
     * @param $specialVacationDays
     * @return $this
     */
    public function setSpecialVacationDays($specialVacationDays): self
    {
        $this->specialVacationDays = $specialVacationDays;
        return $this;
    }

    /**
     * @param string $year
     * @return int
     * @throws Exception
     */
    public function getEmployeeAge(string $year): int
    {
        $birthDate = new DateTime($this->getDateOfBirth()->format('d-m-Y H:i:s'));
        $tillDate = new DateTime($year . '-12-31');
        $difference = $tillDate->diff($birthDate);

        return $difference->y;
    }

}
