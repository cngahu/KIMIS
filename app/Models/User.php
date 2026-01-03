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
use App\Models\College;
use Illuminate\Support\Carbon;
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
        'password_expires_at' => 'datetime',
        'password_changed_at' => 'datetime',
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
    public function getFullNameAttribute()
    {
        return trim("{$this->surname} {$this->first_name} {$this->last_name}");
    }

    public function campus()
    {
        // “campus” is actually a college row
        return $this->belongsTo(College::class, 'campus_id');
    }

    public function passwordIsExpired(): bool
    {
        if (!$this->password_expires_at) return false;
        return Carbon::now()->greaterThan($this->password_expires_at);
    }


    // helper: courses the HOD can access (via departments)
    public function managedCourses()
    {
        return Course::query()
            ->whereIn('department_id', $this->departments()->pluck('departmentts.id'))
            ->where('college_id', $this->campus_id);
    }

    public function departments0()
    {
        return $this->belongsToMany(\App\Models\Departmentt::class, 'department_user', 'user_id', 'department_id');
    }
    public function departments()
    {
        return $this->hasMany(AcademicDepartment::class, 'hod_user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'course_user', 'user_id', 'course_id');
    }

    // 🔗 User (HOD) → Departments
    public function academicDepartments()
    {
        return $this->hasMany(AcademicDepartment::class, 'hod_user_id');
    }

}
