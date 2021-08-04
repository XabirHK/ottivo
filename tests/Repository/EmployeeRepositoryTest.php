<?php

namespace App\Tests\Repository;

use App\Entity\Employee;
use App\Handlers\DateTimeHandler;
use App\Repository\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class EmployeeRepositoryTest extends TestCase
{

    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;


    public function setUp(): void
    {
        $this->employeeRepository = new EmployeeRepository(New DateTimeHandler());
    }

    public function testEmployeeDataExists(){
        $employeeDataFile = $this->employeeRepository::EMPLOYEES_DATA;
        $this->assertFileExists($employeeDataFile);
    }

    public function testFindAll()
    {
        $employeeData = $this->employeeRepository->findAll();
        $this->assertIsArray($employeeData);
        $this->assertInstanceOf(Employee::class, $employeeData[0]);
    }

}
