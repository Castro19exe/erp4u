<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $table = "Product";
    protected $guarded = [];

    public function codeRateLink (){
        return $this->belongsTO(TaxRate :: class, 'taxRateCode', 'taxRateCode');
    }
}
