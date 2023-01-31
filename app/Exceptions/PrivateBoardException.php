<?php
declare(strict_types=1);

namespace App\Exceptions;

class PrivateBoardException extends \Exception implements \Illuminate\Contracts\Support\Responsable
{
    const CLOSED_BOARD = 'closed_board';

    public function toResponse($request)
    {
        return response()->json([
            'status' => 'error',
            'code'   => self::CLOSED_BOARD
        ])->setStatusCode(403);
    }
}
