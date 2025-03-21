<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_member';

    protected $fillable = ['member_id', 'team_id',  'role'];
}
