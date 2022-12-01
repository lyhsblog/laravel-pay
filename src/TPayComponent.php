<?php

namespace Ybzc\Laravel\Pay;

trait TPayComponent
{
    protected int $order;
    protected string $name;
    protected string $code;
    protected string $icon;
    protected string $tpl;

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getTpl(): string
    {
        return $this->tpl;
    }
}
