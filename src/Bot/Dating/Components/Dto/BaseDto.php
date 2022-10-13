<?php

declare(strict_types=1);

namespace App\Bot\Dating\Components\Dto;

use App\Bot\Dating\Components\Request\BaseRequest;

abstract class BaseDto
{
    abstract protected function className(): string;

    public function fillFromBaseRequest(BaseRequest $request): self
    {
        $data = $request->getRequest()->toArray();

        return $this->fillFromArray($data);
    }

    public function fillFromArray(array $array): self
    {
        $class = $this->className();
        $dto = new $class();

        foreach (get_class_vars($class) as $k => $v) {
            $dto->$k = $array[$k] ?? ($v ?? null);
        }

        return $dto;
    }

    public function toArray(): array
    {
        $attributes = [];

        foreach ($this as $k => $v) {
            $attributes[$k] = $v;
        }

        return $attributes;
    }
}
