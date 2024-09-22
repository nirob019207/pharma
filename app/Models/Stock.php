<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['pharmacy_id', 'medicine_id', 'quantity', 'unit_price', 'type'];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmachy::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

  
  
}
