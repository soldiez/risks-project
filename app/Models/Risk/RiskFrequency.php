<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RiskFrequency extends Model
{
    use HasFactory;
    use asSource;

    protected $fillable = [
        'risk_method_id',
        'name',
        'value',
        'info'
    ];

    public function riskMethod(){
        return $this->belongsTo(RiskMethod::class);
    }


}
