<?php

declare(strict_types=1);

namespace App\Handlers;

use DateTime;


class DateTimeHandler
{
    /**
     * @param string $date
     * @return DateTime
     */
    public function stringToDateConverter(string $date): \DateTime
    {
        return date_create_from_format('d-m-Y', $date);
    }

    /**
     * @param DateTime $from
     * @param DateTime $till
     * @return int
     */
    public function getYearDifference(DateTime $from, DateTime $till): int
    {
        $difference = $from->diff($till);
        return $difference->y;
    }
}