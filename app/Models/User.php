<?php

namespace App\Models;


use Illuminate\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public static  function getpermissionGroups(){
       $get_permissionGroups= DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
       return $get_permissionGroups;
    }

    public static function getpermissionByGroupName($group_name){
        $permissions = DB::table('permissions')
            ->select('name','id')
            ->where('group_name',$group_name)
            ->get();
        return $permissions;

    }// End Method
    public static function roleHasPermissions($role, $permissions){

        $hasPermission = true;
        foreach($permissions as $permission){
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
            return $hasPermission;
        }

    }// End Method
    public function ccounty(){
        return $this->belongsTo(county::class,'county','id');
    }
    public function cgender(){
        return $this->belongsTo(gender::class,'gender_id','id');
    }
    public function ccountry(){
        return $this->belongsTo(country::class,'country_id','id');
    }
    public function cnation(){
        return $this->belongsTo(country::class,'nationality','id');
    }

}
