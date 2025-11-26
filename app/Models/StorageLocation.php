<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    protected $table = 'storage_locations';

    var $fillable = [
        "name",
        "warehouse_id",
        "is_full",
        "capacity"
    ];

    public function product()
    {
        return $this->hasMany('app\Model\Product');
    }

    public function warehouse()
    {
        return $this->belongsTo('app\Models\Warehouse');
    }
}
