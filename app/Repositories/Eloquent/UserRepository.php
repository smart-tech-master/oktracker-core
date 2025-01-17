<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Auth;
use Carbon\Carbon;
use Crypt;
use Exception;
use Hash;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param integer $user_id
     * @return User
     */
    public function find($user_id): User
    {
        if ($user_id == null) $user = Auth::user();
        else{
            $user = User::findOrFail($user_id);
        }
        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email): User
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        $user = User::create($attributes);
        return $user;
    }

    /**
     * @param User $user
     * @param string $new_password
     * @return User|null
     */
    public function updatePassword($user, $new_password): ?User
    {
        $user->password = bcrypt($new_password);
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function updateToken($user, $token = null): User
    {
        $user->remember_token = $token;
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @param string $crypted_email
     * @param string $token
     * @return User
     */
    public function confirmEmail($user, $crypted_email, $token): bool
    {
        if ($user->remember_token == $token) {
            $user->email_verified_at = Carbon::now();
            $user->email = Crypt::decryptString($crypted_email);
            $user->remember_token = null;
            $user->save();
            return true;
        }else return false;
    }

    /**
     * @param User $user
     * @param string $name
     * @return User
     */
    public function updateName($user, $name): User
    {
        $user->name = $name;
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @param string $image_path
     * @return User
     */
    public function updateProfilePicture($user, $image_path): User
    {
        $user->profile_photo_path = $image_path;
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return array
     */
    public function updatedInfoResponse($user): array
    {
        $token = $user->createToken(env('APP_KEY'))->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
