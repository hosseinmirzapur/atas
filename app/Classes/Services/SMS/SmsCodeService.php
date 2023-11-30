<?php


namespace App\Classes\Services\SMS;


use App\Classes\Services\CodeService;
use App\Exceptions\CustomException;

class SmsCodeService extends CodeService
{
    /**
     * SmsService constructor.
     * @throws CustomException
     */
    public function __construct()
    {
        $this->assignType('SMS');
    }

    /**
     * @throws CustomException
     */
    public function send($phone_number, $method)
    {
        if (!in_array($method, self::ALLOWED_TYPES)) {
            throw new CustomException('A problem in ' . CodeService::class . 'has occurred.', 500);
        }
        // todo: implement sending sms
    }
}
