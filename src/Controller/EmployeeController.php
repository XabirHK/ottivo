<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EmployeeRepository;


class EmployeeController extends AbstractController
{
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    /**
     * EmployeeController constructor.
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    /**
     * @Route("/employee", name="employee")
     */
    public function index(): Response
    {
        $employee = $this->employeeRepository->findAll();
        var_dump($employee);
        return $this->json($employee);
    }
}
