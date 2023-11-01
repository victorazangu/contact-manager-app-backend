<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contacts_groups', 'group_id', 'contact_id');
    }

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
