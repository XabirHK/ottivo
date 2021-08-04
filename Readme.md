# Ottonova coding challenge

## Without Docker
### Requirements
    Php 7.4
    composer
### Installation
extract the zip file in your desired folder

got to the root of the folder 

    cd Yourfoldername/ottivo/
    composer install'

After completing the installation run

 'php bin/console YearlyVacation {year of interest}'. for example,
    
    php bin/console YearlyVacation 2020

you will see the output as follows 
    
    ! [NOTE] Name: Hans Müller - Vacation Days: 29 - for year 2020
    ! [NOTE] Name: Angelika Fringe - Vacation Days: 29 - for year 2020
    ! [NOTE] Name: Peter Klever - Vacation Days: 27 - for year 2020
    ! [NOTE] Name: Marina Helter - Vacation Days: 26 - for year 2020
    ! [NOTE] Name: Sepp Meier - Vacation Days: 26 - for year 2020

### Unit Test

Run

    php ./vendor/bin/phpunit 

## With Docker
### Requirements
    docker
### Installation
extract the zip file in your desired folder 

go to the root of the folder 

    cd Yourfoldername/ottivo/
    docker-compose up -d --build

After completing the installation

#### from outside the docker container
run
    
    docker exec ottivo-vacation-calculator bash -lc 'php bin/console YearlyVacation 2020'

#### from inside the docker container
run

    docker exec -it ottivo-vacation-calculator bash
    php bin/console YearlyVacation 2020

### Unit Test

Run

    docker exec ottivo-vacation-calculator bash -lc 'php ./vendor/bin/phpunit'

## Assumptions

- Contracts starting in the course of the year get 1/12 of the yearly vacation days for each full  month
  
    After calculation output the floor value not the ceiling.
  

- Contracts can start on the 1st or the 15th of a month
  
  The contact which start from the 15th calculating vacation from the next month, assuming the employee doesn't get extra vacation for that 15 days.


- Employees >= 30 years get one additional vacation day every 5 years

  Calculating the 5-year period from the contract start date not the birthdate till the end of the interested yeas not the beginning of the interested year.

  Age is calculated till the end of the interested year.