<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'profile_photo_path',
        'role',
        'provider_id',
        'provider_name',
        'provider_token',
        'provider_refresh_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',
        'provider_refresh_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getRoleOptions()
    {
        // Check the type of database being used
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // Retrieve column description from the users table
            $column = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");
            // Extract data type from query result
            $type = $column[0]->Type;
            // Extract enum values using regex
            preg_match('/enum\((.*)\)/', $type, $matches);
            // Return enum values as an array
            return str_getcsv($matches[1], ',', "'");
        } elseif ($driver === 'sqlite') {
            // If using SQLite, ENUM is not supported, an alternative solution must be created.
            return ['superadmin', 'user']; // Adjust according to expected values
        }

        return []; // Return empty if the driver is not recognized
    }
}
