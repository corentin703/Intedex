<?php


namespace App\Services\Views;

use App\Http\Repositories\UserRepositoryInterface;

class UserAutocompletionServiceService implements UserAutocompletionServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get_usernames() {
        return array_map(function ($elem) {
            return [
                'label' => $elem->name,
                'value' => $elem->name,
            ];
        }, $this->userRepository->getAllUsernames()->toArray());
    }
}
