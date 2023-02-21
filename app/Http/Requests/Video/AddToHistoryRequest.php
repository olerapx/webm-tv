<?php
declare(strict_types=1);

namespace App\Http\Requests\Video;

class AddToHistoryRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'website' => ['required', 'string'],
            'board'   => ['required', 'string'],
            'videos'  => ['required']
        ];
    }
}
