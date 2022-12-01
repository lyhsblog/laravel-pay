<?php

namespace Ybzc\Laravel\Pay;

use Illuminate\Database\Eloquent\Model;

class PayStateMachineService extends PayService
{
    public function __construct(APayComponent ...$components)
    {
        parent::__construct(...$components);
        $this->createRule = [
            ...$this->createRule,
            'status' => 'required'
        ];
        $this->updateRule = [
            ...$this->updateRule,
            'status' => 'required'
        ];
        $this->tpl = [
            ...$this->tpl,
            'index' => 'pay.state.index',
            'create' => 'pay.state.create',
            'edit' => 'pay.state.edit'
        ];
    }

    /**
     * @throws \Exception
     */
    public function update(array $map): Model
    {
        $inDb = $this->query()
            ->findOrFail($map['id']);
        if($inDb->status()->canBe($map['status'])) {
            $inDb->status()->transitionTo(
                $map['status'],
                [
                    'new' => $map,
                    'old' => $inDb->getOriginal(),
                ],
            );
            $inDb->save();
        }else {
            throw new \Exception('状态转换异常:'.$inDb['status'].'->'.$map['status']);
        }
        return parent::update($map);
    }
}
