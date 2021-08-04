# Ottonova coding challenge

## Without Docker
### Requirements
    Php 7.4
    composer
### Installation
1. extract the zip file in your desired folder

2. Go to the root of the folder 

    cd Yourfoldername/ottivo/
    composer install'

### Execute Program
1. After completing the installation run
   
        'php bin/console YearlyVacation {year of interest}'. 

    for example,
   
       php bin/console YearlyVacation 2020

2. you will see the output as follows 
   
 
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
1. extract the zip file in your desired folder 

2. go to the root of the folder 


    cd Yourfoldername/ottivo/
    docker-compose up -d --build

### Execute Program
  1. After completing the installation run
    
    docker exec ottivo-vacation-calculator bash -lc 'php bin/console YearlyVacation 2020'


### if encounter error
1. Try running 


    docker exec -it ottivo-vacation-calculator bash
    composer install
    php bin/console YearlyVacation 2020

### Unit Test

Run

    docker exec ottivo-vacation-calculator bash -lc 'php ./vendor/bin/phpunit'

## Assumptions

- <b>Contracts starting in the course of the year get 1/12 of the yearly vacation days for each full  month </b>
  
    After calculation output the floor value not the ceiling value.
  

- <b>Contracts can start on the 1st or the 15th of a month </b>
  
  The contact which start from the 15th calculating vacation from the next month, assuming the employee doesn't get extra vacation for that 15 days.


- <b>Employees >= 30 years get one additional vacation day every 5 years </b>

  Calculating the 5-year period from the contract start date not the birthdate till the end of the interested yeas not the beginning of the interested year.

  Age is calculated till the end of the interested year.