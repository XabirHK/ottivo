<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Employee;
use App\Handlers\DateTimeHandler;


class EmployeeRepository
{

    const EMPLOYEES_DATA = __DIR__ . './../Data/EmployeesData.php';

    /**
     * @var array
     */
    private array $employees = [];

    /**
     * @var DateTimeHandler
     */
    private DateTimeHandler $dateTimeHandler;

    /**
     * EmployeeRepository constructor.
     */
    public function __construct(DateTimeHandler $dateTimeHandler)
    {
        $this->dateTimeHandler = $dateTimeHandler;
        $this->serialize();
    }

    /**
     *
     */
    private function serialize(): void
    {
        $employees = [];
        $employeesData = include(self::EMPLOYEES_DATA);

        if($employeesData){
            foreach ($employeesData as $employeeData) {
                $employee = new Employee();
                $employee->setName($employeeData['name']);
                $employee->setDateOfBirth($this->dateTimeHandler->stringToDateConverter($employeeData['dateOfBirth']));
                $employee->setContractStartDate($this->dateTimeHandler->stringToDateConverter($employeeData['contractStartDate']));
                $employee->setSpecialVacationDays($employeeData['specialContract']);
                $employees[] = $employee;
            }
        }

        $this->employees = $employees;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->employees;
    }
}
