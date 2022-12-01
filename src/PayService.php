<?php

namespace Ybzc\Laravel\Pay;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ybzc\Laravel\Base\Impl\TCrudService;
use Ybzc\Laravel\Base\Impl\TWebService;
use Ybzc\Laravel\Base\IWebService;
use Ybzc\Laravel\Pay\Models\Pay;

class PayService implements IWebService
{
    use TCrudService, TWebService;

    private Collection $components;

    private static string $namespace = 'laravelpay';

    public function __construct(APayComponent ...$components)
    {
        $this->components = Collection::make($components);
        $this->tpl = [
            ...$this->tpl,
            "index" => static::$namespace."::pay.index",
            "create" => static::$namespace."::pay.create",
            "store" => static::$namespace."::pay.store",
            "edit" => static::$namespace."::pay.edit",
            "update" => static::$namespace."::pay.update",
            "components" => static::$namespace.'::pay.components'
        ];
        $this->route = [
            ...$this->route,
            "index" => "pay.index",
            "create" => "pay.create",
            "store" => "pay.store",
            "edit" => "pay.edit",
            "update" => "pay.update",
        ];
        $this->createRule = ["amount" => "required|max:50000", 'no' => 'required'];
        $this->updateRule = ["amount" => "required|max:50000"];
    }

    public function query(): Builder
    {
        return app(Pay::class)->newQuery();
    }

    public function register(APayComponent $service): void
    {
        if(!$this->components->contains(function (APayComponent $item) use ($service) {
            return $item->getCode() === $service->getCode();
        })) {
            $this->components->add($service);
        }
    }

    public function payments(): Collection
    {
        return $this->components;
    }

    public function pay(int $id, string $code): string
    {
        return $this->payment($code)->pay(Pay::findOrFail($id));
    }

    public function configTpl($code): string
    {
        return $this->payment($code)->getTpl();
    }

    public function updateConfig(Request $request): void
    {
        $this->payment($request->input('code'))->update($request);
    }

    public function payment($code): APayComponent {
        return $this->components->firstOrFail(function (APayComponent $item) use($code) {
            return $item->getCode() === $code;
        });
    }
}
