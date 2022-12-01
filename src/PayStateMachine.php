<?php

namespace Ybzc\Laravel\Pay;

use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class PayStateMachine extends StateMachine
{
    public static array $define = [
        /**
         * 可以直接取消订单, 可能是运营人员需要客户操作订单
         * 本系统为自动内部队列扣款,
         * 一些系统可以直接支付
         * 状态转换会形成竞争
         */
        'applied' => ['canceled', 'debited', 'paid'],
        // 财务可以标识这个单子完成,完后后就不需要对账了, 用户可以修改单子再次申请
        'canceled' => ['applied', 'completed'],
        // 运营人员关注这个状态, 只要收到款就可以标识为处理状态, 或者一些原因发起退款
        'debited' => ['processing', 'applied_refund', 'refunding'],
        // 运营人员关注这个状态, 只要收到款就可以标识为处理状态, 或者一些原因发起退款
        'paid' => ['processing', 'applied_refund', 'refunding'],
        // 系统业务处理在这里面
        'processing' => ['succeeded', 'failed'],
        // 财务可以标识这个单子完成
        'succeeded' => ['completed'],
        // 用户可以申请退款, 运营人员可以直接退款, 资源竞争,
        'failed' => ['applied_refund', 'refunding'],
        /**
         * 本来一个refunding是够了,
         * 但是三方系统的退款可能会异常失败, 例如钱退了, 给我们的通知是失败的,
         * 这样被有心客户利用就白干了, 所以给用户申请退款加一层人工审核,
         * 但是保留主动退款
         */
        // 运营人员可以同意退款,
        'applied_refund' => ['refunding'],
        // 自动程序发起退款, 结果异步通知回来
        'refunding' => ['refunded', 'refunding_failed'],
        // 财务可以标识这个单子完成
        'refunded' => ['completed'],
        // 退款失败可以从新发起退款
        'refunding_failed' => ['applied_refund', 'refunding'],
    ];

    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return static::$define;
    }

    public function defaultState(): ?string
    {
        return "applied";
    }
}
