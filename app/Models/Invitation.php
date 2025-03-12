<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = ['token', 'invited_by', 'expires_at',  'invitable_id', 'invitable_type'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invitation) {
            $invitation->token = Str::random(32);
            $invitation->expires_at = now()->addDays(7);
        });
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function invitable()
    {
        return $this->morphTo();
    }
}
