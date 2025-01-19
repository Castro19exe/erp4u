<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderC extends Model
{
    use HasFactory;

    protected $table = "PurchaseOrderC";
    protected $guarded = [];

    public function supplierCodeLink (){
        return $this->belongsTO(Supplier :: class,'supplierCode', 'code');
    }
}
