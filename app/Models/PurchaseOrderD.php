<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderD extends Model
{
    use HasFactory;

    protected $table = "PurchaseOrderD";
    protected $guarded = [];

    public function productCodeLink (){
        return $this->belongsTO(Product :: class, 'productCode', 'code');
    }
    public function productFamilyLink (){
        return $this->belongsTO(Family :: class, 'productFamily', 'family');
    }
    public function taxRateLink (){
        return $this->belongsTO(TaxRate :: class, 'taxRateCode', 'taxRateCode');
    }
}
