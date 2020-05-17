<?php
use function DI\object;
return [
    \Solid\Services\HistoryService::class => object(\Solid\Services\UserHistoryService::class),
];