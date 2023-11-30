<?php


namespace App\Services\Codes;


use App\Exceptions\CustomException;

class ReferralCode extends Code
{
    /**
     * @return int|string
     * @throws CustomException
     */
    public static function generateCode(): int|string
    {
        return (new ReferralCode)->setType('referral')->generate();
    }

}
