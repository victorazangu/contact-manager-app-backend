<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'user_id',
    ];

    public function user()
    {
        return   $this->belongsTo(User::class);
    }
    public function contactGroup()
    {
        return $this->belongsToMany(ContactGroup::class);
    }
}
