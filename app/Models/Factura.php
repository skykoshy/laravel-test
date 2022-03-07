<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_factura',
        'fecha',
        'nombre_emisor',
        'nit_emisor',
        'nombre_receptor',
        'nit_receptor',
        'valor_sin_iva',
        'iva',
        'valor_total'
    ];


    protected static function boot()
    {
        parent::boot();

        Factura::creating(function($model) {
            $model->fecha = time();
            $model->numero_factura = time();
        });

    }

    public function getFechaAttribute($value)
    {
        return date('Y/m/d',$value);
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    
}
