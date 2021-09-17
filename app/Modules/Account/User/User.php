<?php

namespace App\Modules\Account\User\Models;

use Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword,
        HasApiTokens;

    const APP_TOKEN_NAME = 'LMS';
    
    protected $connection = 'mysql';

    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Generate random string for password
     *
     * @param Integer $length
     *
     * @return string
     */
    public static function generateRandomPassword($length = 10)
    {
        $charactersLength = strlen(self::CHARACTERS);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= self::CHARACTERS[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Removes access tokens.
     *
     * @param      string  $appName  The application name
     *
     * @return     void
     */
    public function revokeExistingTokensFor(string $appName)
    {
        $this->tokens()->where(
            [
                'name' => $appName,
                'revoked' => false
            ]
        )->update(['revoked' => true]);
    }
}
