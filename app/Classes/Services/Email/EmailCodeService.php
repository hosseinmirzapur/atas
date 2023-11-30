<?php


namespace App\Classes\Services\Email;


use App\Classes\Services\CodeService;
use App\Exceptions\CustomException;

class EmailCodeService extends CodeService
{
    /**
     * EmailService constructor.
     * @throws CustomException
     */
    public function __construct()
    {
        $this->assignType('EMAIL');
    }

    /**
     * @throws CustomException
     */
    public function send($email, $method)
    {
        if (!in_array($method, self::ALLOWED_TYPES)) {
            throw new CustomException('A problem in ' . CodeService::class . 'has occurred.', 500);
        }
        // todo: implement sending email
    }
}
