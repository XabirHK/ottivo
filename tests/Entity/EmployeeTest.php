<?php

namespace App\Tests\Entity;

use App\Entity\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * @var Employee
     */
    private $employee;

    protected function setUp(): void
    {
        $this->employee = new Employee();
    }

    public function testGetEmployeeAge()
    {
        $name = 'Jone, Doe';
        $dateOfBirth = new \DateTime('1998-05-05');
        $startDate = new \DateTime('2018-01-01');
        $specialVacationDays = null;
        $this->employee->setName($name);
        $this->employee->setDateOfBirth($dateOfBirth);
        $this->employee->setContractStartDate($startDate);
        $this->employee->setSpecialVacationDays($specialVacationDays);

        $this->assertEquals(22, $this->employee->getEmployeeAge(2020));

    }
}
