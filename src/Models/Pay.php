<?php

namespace Ybzc\Laravel\Pay\Models;

use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ybzc\Laravel\Pay\PayStateMachine;

class Pay extends Model
{
    use HasFactory;
    Use HasStateMachines;

    public $stateMachines = [
        'status' => PayStateMachine::class
    ];

    protected $fillable = ['amount', 'no'];

    protected static function newFactory()
    {
        return PayFactory::new();
    }
}
