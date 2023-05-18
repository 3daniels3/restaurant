<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendedor extends Model
{
    use HasFactory;
    use SoftDeletes;

    //protected $primaryKey = 'id';
    
    protected $fillable = ['cedula', 'nombre', 'telefono', 'correo'];

    public function facturas()
{

    return $this->hasMany(Factura::class);
    
}
 
}
