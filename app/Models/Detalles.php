<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detalles extends Model
{    
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['factura_id', 'producto_id', 'cantidad', 'subtotal'];


    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id' );
    }
   

}
