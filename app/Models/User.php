<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRolesAndAbilities,  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'member_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

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

    public function profile(): HasOne
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }



    public function teams(): HasManyThrough
    {
        return $this->hasManyThrough(
            Team::class, // The target model (teams)
            TeamMember::class, // The intermediate model (team_member)
            'member_id', // Foreign key on the team_member table
            'id', // Foreign key on the teams table
            'member_id', // Local key on the users table
            'team_id' // Local key on the church_member table
        );
    }

    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(
            Group::class, // The target model (groups)
            GroupMember::class, // The intermediate model (family_member)
            'member_id', // Foreign key on the family_member table
            'id', // Foreign key on the groups table
            'member_id', // Local key on the users table
            'group_id' // Local key on the family_member table
        );
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
}
