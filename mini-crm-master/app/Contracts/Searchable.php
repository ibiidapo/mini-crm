<?php
declare(strict_types=1);

namespace App\Contracts;


interface Searchable
{
    public function getName(): string;
    
    public function getDescription(): string;
}