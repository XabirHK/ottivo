<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Employee;
use App\Handlers\DateTimeHandler;

class VacationCalculatorService
{
    public const DEFAULT_YEARLY_VACATION_DAYS = 26;
    public const MIN_AGE_FOR_BONUS_VACATION = 30;
    public const MIN_YEAR_FOR_EXTRA_VACATION_DAY = 5;

    /**
     * @var Employee
     */
    private Employee $employee;

    /**
     * @var DateTimeHandler
     */
    private DateTimeHandler $dateTimeHandler;

    /**
     * VacationCalculatorService constructor.
     */
    public function __construct(DateTimeHandler $dateTimeHandler)
    {
        $this->dateTimeHandler = $dateTimeHandler;
    }

    /**
     * @param Employee $employee
     * @param string $year
     * @return int
     * @throws \Exception
     */
    public function yearlyVacationDaysByEmployee(Employee $employee, string $year): int
    {
        $contractStartDate = $employee->getContractStartDate();

        //check if the interest year is grater than the contract year of the employee then he/she will not have vacation days on that year
        if ($contractStartDate->format('Y') > $year) {
            return 0;
        } else {
            $specialContract = $this->getVacationDaysForSpecialContract($employee);

            if ($specialContract !== 0) {
                $baseVacationDays = $specialContract;
            } else {
                $baseVacationDays = self::DEFAULT_YEARLY_VACATION_DAYS;
            }

            $extraVacationDays = $this->getExtraVacationDaysForOver30($employee, $year);
            $remainingMonths = $this->getRemainingContractMonths($employee, $year);

            return (int)(round($baseVacationDays * ($remainingMonths / 12)) + $extraVacationDays);
        }
    }

    /**
     * @param Employee $employee
     * @return int
     */
    private function getVacationDaysForSpecialContract(Employee $employee): int
    {
        return $employee->getSpecialVacationDays() ?: 0;
    }

    /**
     * @param Employee $employee
     * @param string $year
     * @return int
     * @throws \Exception
     */
    private function getExtraVacationDaysForOver30(Employee $employee, string $year): int
    {
        $bonusDays = 0;
        $age = $employee->getEmployeeAge($year);

        if ($age !== null && $age >= self::MIN_AGE_FOR_BONUS_VACATION) {

            $contractStartDate = $employee->getContractStartDate();

            if ($contractStartDate) {
                $interestedDate = new \DateTime($year . '-12-31');

                $differenceByYear = $this->dateTimeHandler->getYearDifference($contractStartDate, $interestedDate);

                // prevent error for negative difference
                if ($differenceByYear >= self::MIN_YEAR_FOR_EXTRA_VACATION_DAY) {
                    $bonusDays = (int)floor($differenceByYear / self::MIN_YEAR_FOR_EXTRA_VACATION_DAY);
                }
            }

        }
        return $bonusDays;
    }

    /**
     * @param Employee $employee
     * @param string $year
     * @return int
     * @throws \Exception
     */
    private function getRemainingContractMonths(Employee $employee, string $year): int
    {
        $dateOfInterest = new \DateTime('31-12-' . $year);
        $dateOfInterest->modify('+1 day'); // to calculate 12 remaining month if some one join at the start of the interested Year
        $contractDate = $employee->getContractStartDate();

        if ( $contractDate !== null && $year === $contractDate->format('Y')) {
            $months = $dateOfInterest->diff($contractDate);
            $diffInMonths = (($months->y) * 12) + ($months->m);
            return $diffInMonths == 0 ? 1 : $diffInMonths; // prevent getting 0 if some on join in december of the interest year
        } else return 12;
    }

}
