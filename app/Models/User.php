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

    public function affiliates(): BelongsToMany
    {
        return $this->belongsToMany(Affiliate::class, 'tenant_user', 'user_id', 'tenant_id');
    }

    public function churches(): HasManyThrough
    {
        return $this->hasManyThrough(
            Church::class, // The target model (churches)
            ChurchMember::class, // The intermediate model (church_member)
            'member_id', // Foreign key on the church_member table
            'id', // Foreign key on the churches table
            'member_id', // Local key on the users table
            'church_id' // Local key on the church_member table
        );
    }

    public function communities(): HasManyThrough
    {
        return $this->hasManyThrough(
            Community::class, // The target model (communities)
            CommunityMember::class, // The intermediate model (community_member)
            'member_id', // Foreign key on the community_member table
            'id', // Foreign key on the communities table
            'member_id', // Local key on the users table
            'community_id' // Local key on the church_member table
        );
    }

    public function families(): HasManyThrough
    {
        return $this->hasManyThrough(
            Family::class, // The target model (families)
            FamilyMember::class, // The intermediate model (family_member)
            'member_id', // Foreign key on the family_member table
            'id', // Foreign key on the families table
            'member_id', // Local key on the users table
            'family_id' // Local key on the family_member table
        );
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
}
