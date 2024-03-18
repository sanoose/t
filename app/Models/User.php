<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes ;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

        #scopes
        // public function scopeFilter($query, $search)
        // {
        //     return $query->where('name', 'like', '%' . $search . '%')
        //         ->orWhere('email', 'like', '%' . $search . '%')  ;
        // }

        public function scopeFilter($query, array $filters) {
            if( request('search_email')  != ""  &&   request('search_name') == ""  ) {
                $query->where('email', 'like', '%' . request('search_email') . '%') ;
            }
            elseif( request('search_email')  == ""  &&   request('search_name') != ""  ) {
                $query->where('name', 'like', '%' . request('search_name') . '%') ;
            }
            elseif( request('search_email')  != ""  &&   request('search_name') != ""  ) {
                $query->where('name', 'like', '%' . request('search_name') . '%')
                ->where('email', 'like', '%' . request('search_email') . '%') ;
            }
        }

    
        // public function scopeFilterBydate($query, $searchPram)
        // {
        //     return $query->where('task_type_id', $searchPram['task_type_id'] ?? null)
        //         ->Where('consultant_id', $searchPram['consultant_id']  ?? null)
        //         ->whereDate('created_at','=', $searchPram['created_at'] ?? null)
        //         ->Where('due_to', $searchPram['due_to']  ?? null);
        // }


    // relation
    public function role () {
        return $this->hasOne(role::class , "user_id") ;
    }


    public function department()
    {
        return $this->belongsTo(Department::class , "department_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class , "added_by");
    }


}

