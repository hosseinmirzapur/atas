<?php


namespace App\Services\Codes;


use App\Exceptions\CustomException;

class EmailCode extends Code
{
    /**
     * @return int|string
     * @throws CustomException
     */
    public static function generateCode(): int|string
    {
        return (new EmailCode)->setType('email')->generate();
    }
}
