<?php

namespace App\Enums;

enum ArticleStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
    case Scheduled = 'scheduled';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function tone(): string
    {
        return $this->value;
    }
}
