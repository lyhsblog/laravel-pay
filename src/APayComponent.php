<?php

namespace Ybzc\Laravel\Pay;

use Illuminate\Http\Request;

abstract class APayComponent
{
    use TPayComponent;

    public abstract function update(Request $request): void;
}
