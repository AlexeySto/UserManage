<?php

namespace Alexey\MyProdject\Domain\Controllers;

class AbstractController extends Controller {

    protected array $actionsPermissions = [];
    
    public function getUserRules(): array{
        $rules[] = 'user';
        return $rules;
    }

    public function getActionsPermissions(string $methodName): array {
        return $this->actionsPermissions[$methodName] ?? [];
    }
}
