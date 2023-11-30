<?php

namespace App\Services\Classes\Profile;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;

interface ProfileServiceInterface
{
    /**
     * @param ProfileRequest $request
     * @throws CustomException
     */
    public function updateOrCreate(ProfileRequest $request);

    /**
     * @return array
     */
    public function read(): array;

    /**
     * @param ChangePasswordRequest $request
     * @throws CustomException
     */
    public function changePassword(ChangePasswordRequest $request);
}
