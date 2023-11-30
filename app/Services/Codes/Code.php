<?php


namespace App\Services\Codes;


use App\Exceptions\CustomException;

abstract class Code
{
    protected string $type;

    /**
     * @param string $className
     * @return $this
     */
    public function setType(string $className): static
    {
        $this->type = $className;
        return $this;
    }

    /**
     * @return int|string
     * @throws CustomException
     */
    protected function generate(): int|string
    {
        return match ($this->type) {
            "email" => mt_rand(10000, 99999),
            "referral" => "",
            default => throw new CustomException('Incompatible', 500),
        };
    }
}
