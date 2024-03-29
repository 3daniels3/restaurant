<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function vendedor()
{
   // return $this->belongsTo(App\Models\Vendedor::class);
    return $this->belongsTo(Vendedor::class, 'vendedor_id');
}

public function detalles()
{
    return $this->hasMany(Detalles::class, 'factura_id');
}
}
