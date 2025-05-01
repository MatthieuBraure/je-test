<?php

declare(strict_types=1);

namespace App\Social\Domain\Exception;

class InvalidLikeCreation extends \LogicException
{
    private const EXCEPTION_CODE = 500;

    public static function cannotLikeYourOwnArticle(): self
    {
        return new self(
            message: 'You cannot like your own article',
            code: self::EXCEPTION_CODE,
        );
    }

    public static function cannotLikeTwice(): self
    {
        return new self(
            message: 'You cannot like twice',
            code: self::EXCEPTION_CODE,
        );
    }
}
