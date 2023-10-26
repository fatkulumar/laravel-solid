<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\GenUid;
use App\Models\ModelHasPermission;
use App\Models\ModelHasRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class ModelUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GenUid, HasRoles;

    protected $table = 'users';

    public function permissions()
    {
        return $this->hasMany(ModelHasPermission::class, 'model_id');
    }

    public function roles()
    {
        return $this->hasMany(ModelHasRole::class, 'model_id');
    }
}
