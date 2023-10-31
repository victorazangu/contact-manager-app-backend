<?php

namespace App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContactGroup extends Pivot
{

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
