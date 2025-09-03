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
     * @var list<string>
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
     * @var list<string>
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
        // Cek jenis database yang digunakan
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // Ambil deskripsi kolom dari tabel users
            $column = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");
            // Ekstrak tipe data dari hasil query
            $type = $column[0]->Type;
            // Ambil nilai enum menggunakan regex
            preg_match('/enum\((.*)\)/', $type, $matches);
            // Kembalikan nilai enum sebagai array
            return str_getcsv($matches[1], ',', "'");
        } elseif ($driver === 'sqlite') {
            // Jika menggunakan SQLite, ENUM tidak didukung, harus dibuat solusi alternatif
            return ['superadmin', 'user']; // Sesuaikan dengan nilai yang diharapkan
        }

        return []; // Return kosong jika driver tidak dikenali
    }
}
