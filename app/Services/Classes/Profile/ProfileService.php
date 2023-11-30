<?php


namespace App\Services\Classes\Profile;


use App\Exceptions\CustomException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Repository\Structure\ProfileRepository;
use App\Repository\Structure\UserRepository;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class ProfileService implements ProfileServiceInterface
{
    protected ProfileRepository $profileRepository;
    protected UserRepository $userRepository;

    public function __construct(ProfileRepository $repository, UserRepository $userRepository)
    {
        $this->profileRepository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param ProfileRequest $request
     * @throws CustomException
     */
    public function updateOrCreate(ProfileRequest $request)
    {
        $user = currentUser();
        $data = filterRequest($request->validated());
        $photo = handleFile('/profiles', $request->photo);
        $data['photo'] = $photo;
        if (exists($user->profile)) {
            $user->profile->update($data);
        } else {
            $this->profileRepository->createOne($data + ['user_id' => $user->id]);
        }
    }

    /**
     * @return array
     */
    #[ArrayShape(['profile' => "\App\Http\Resources\ProfileResource"])] public function read(): array
    {
        $user = currentUser();
        return [
            'profile' => exists($user->profile) ? ProfileResource::make($user->profile) : [
                'email' => $user->email,
                'user_id' => $user->id
            ]
        ];
    }

    /**
     * @param ChangePasswordRequest $request
     * @throws CustomException
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;
        $user = currentUser();
        if (!Hash::check($old_password, $user->password)) {
            throw new CustomException(trans('messages.WRONG_CREDENTIALS'));
        }
        if ($new_password != $confirm_password) {
            throw new CustomException(trans('messages.PASSWORDS_NOT_MATCH'));
        }
        $this->userRepository->updateById($user->id, [
            'password' => Hash::make($new_password)
        ]);
    }
}
