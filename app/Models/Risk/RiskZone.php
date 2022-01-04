<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RiskZone extends Model
{
    use HasFactory;
    use asSource;

    protected $fillable = [
        'risk_method_id',
        'value',
        'colour',
        'manage',
        'info'
    ];

    public function riskMethod(){
        return $this->belongsTo(RiskMethod::class);
    }
}
