<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\EmployeeRepository;
use App\Service\VacationCalculatorService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class YearlyVacationCommand extends Command
{


    protected static $defaultName = 'YearlyVacation';
    protected static $defaultDescription = 'command line script that takes the year of interest as an
                                            input argument and outputs the employees names with the respective number of vacation days.';

    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    /**
     * @var VacationCalculatorService
     */
    private VacationCalculatorService $vacationCalculatorService;

    /**
     * YearlyVacationCommand constructor.
     */
    public function __construct(EmployeeRepository $employeeRepository, VacationCalculatorService $vacationCalculatorService)
    {
        parent::__construct();
        $this->employeeRepository = $employeeRepository;
        $this->vacationCalculatorService = $vacationCalculatorService;
    }


    protected function configure(): void
    {
        $this
            ->addArgument('year', InputArgument::REQUIRED, 'Takes the year of interest')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $year = $input->getArgument('year');

        $employees = $this->employeeRepository->findAll();

        if ($year) {

            foreach ($employees as $key => $employee) {
                $vacationDays = $this->vacationCalculatorService->yearlyVacationDaysByEmployee($employee, $year);
                $io->note(sprintf('Name: %s Vacation Days: %d' , $employee->getName(), $vacationDays));
            }
        }

        $io->success('Command executed successfully');

        return Command::SUCCESS;
    }
}
