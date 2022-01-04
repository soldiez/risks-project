<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RiskMethod extends Model
{
    use HasFactory;
    use asSource;

    protected $fillable = [
        'name',
        'category',
        'info',
        'status'
    ];

    public function riskFrequencies(){
        return $this->hasMany(RiskFrequency::class);
    }
    public function riskProbabilities(){
        return $this->hasMany(RiskProbability::class);
    }
    public function riskSeverities(){
        return $this->hasMany(RiskSeverity::class);
    }
    public function riskZones(){
        return $this->hasMany(RiskZone::class);
    }

}
