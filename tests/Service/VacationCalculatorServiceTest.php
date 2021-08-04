<?php

namespace App\Tests\Service;

use App\Entity\Employee;
use App\Handlers\DateTimeHandler;
use App\Service\VacationCalculatorService;
use PHPUnit\Framework\TestCase;

class VacationCalculatorServiceTest extends TestCase
{
    /**
     * @var Employee
     */
    private $employee;

    protected function setUp(): void
    {
        $this->employee = new Employee();
    }

    public function testDefaultYearlyVacationDays()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1998-05-05');
        $startDate = new \DateTime('2018-01-01');
        $specialVacationDays = null;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());

        $this->assertEquals(Employee::DEFAULT_YEARLY_VACATION_DAYS, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2020));
    }

    public function testDefaultYearlyVacationDaysStartingVeryFirstOfTheInterestedYear()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1998-05-05');
        $startDate = new \DateTime('2018-01-01');
        $specialVacationDays = null;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());

        $this->assertEquals(Employee::DEFAULT_YEARLY_VACATION_DAYS, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2018));
    }

    public function testRemainingVacationDaysStartingVeryLastOfTheInterestedYear()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1998-05-05');
        $startDate = new \DateTime('2018-12-01');
        $specialVacationDays = null;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());

        $this->assertEquals(2, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2018));
    }

    public function testExtraVacationDaysForOver30YearsOld()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1980-05-01');
        $startDate = new \DateTime('2010-05-01');
        $specialVacationDays = null;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());

        $this->assertEquals(28, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2020));
    }

    public function testVacationDaysForSpecialContract()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1990-05-01');
        $startDate = new \DateTime('2016-05-01');
        $specialVacationDays = 30;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());

        $this->assertEquals(30, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2020));
    }

    public function testVacationDaysForSpecialContractOver30()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1980-05-01');
        $startDate = new \DateTime('2010-05-01');
        $specialVacationDays = 30;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());
        // 30 for special and +  for over30 and 10 yeas in work
        $this->assertEquals(32, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2020));
    }

    public function testVacationDaysForContractYearGreaterThanInterestedYear()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1980-05-01');
        $startDate = new \DateTime('2020-05-01');
        $specialVacationDays = 30;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);
        $vacationDaysService = new VacationCalculatorService (new DateTimeHandler());
        $this->assertEquals(0, $vacationDaysService->yearlyVacationDaysByEmployee($this->employee, 2019));
    }



    public function tearDown(): void
    {
        // to make emplyee empty after each testcase
        $this->employee = null;
        parent::tearDown();
    }
}
