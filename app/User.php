<?php

namespace App;

use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Auth;


class User extends Authenticatable implements Auditable
{
    use HasApiTokens,Notifiable,AuditableTrait;

    protected $table = 'users';
    protected $guarded = ['id'];
    protected $dates   = ['created_at, updated_at'];
	protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name', 'email', 'password',
    ];
	public function getAuthPassword()
	{
		return $this->password;
	}

    protected $hidden = [
        'password',
    ];

    public function generateToken(){

        $token = Str::random(60);

        return hash('sha256', $token);
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

}
