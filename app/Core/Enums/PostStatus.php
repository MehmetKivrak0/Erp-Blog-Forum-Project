<?php

namespace App\Core\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case PENDING = 'pending';
}