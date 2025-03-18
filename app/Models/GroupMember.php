<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = 'group_member';

    protected $fillable = ['group_id', 'member_id', 'role'];
}
