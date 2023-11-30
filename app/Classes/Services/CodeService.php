<?php


namespace App\Classes\Services;


use App\Exceptions\CustomException;

abstract class CodeService
{
    const ALLOWED_TYPES = ['FOLLOW', 'REPLY', 'COMMENT'];

    protected string $type;

    /**
     * @param string $type
     * @return CodeService
     * @throws CustomException
     */
    public function assignType(string $type): static
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new CustomException('A problem in ' . CodeService::class . 'has occurred.', 500);
        }
        $this->type = $type;
        return $this;
    }
}
