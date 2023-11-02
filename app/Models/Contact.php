<?php

namespace App\Models;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        "image",
        'user_id',
    ];

    public function user()
    {
        return   $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'contacts_groups', 'contact_id', 'group_id');
    }
}
