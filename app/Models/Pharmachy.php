<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmachy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'user_id']; // Include 'user_id'

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Define the relationship with User
    }
}
