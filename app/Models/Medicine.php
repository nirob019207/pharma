<?php

// app/Models/Medicine.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'generic_id', 'company_id', 'description'];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
    public function generic()
    {
        return $this->belongsTo(Generic::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
