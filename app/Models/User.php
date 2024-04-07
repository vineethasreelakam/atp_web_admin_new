<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Hash;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'admin',
        'role_id',
        'type'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }  

    public function setPasswordAttribute($value)
    {
    $this->attributes['password'] = Hash::make($value);
    }  

    public function Privilleges(){
        return $this->hasmany('App\Models\UserAccess', 'user_id','id')->where('type','privillege');
    }

    public function Tournaments(){
        return $this->hasmany('App\Models\UserAccess', 'user_id','id')->where('type','tournament')->where('status',1);
    }
     
    public function Forms(){
        return $this->hasmany('App\Models\UserForm', 'user_id','id');
    }

    public function Role(){
        return $this->belongsTo('App\Models\Role', 'role_id','id');
    }

}