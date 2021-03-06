<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MomentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rangeStart' => 'required|min:0|max:100',
            'rangeEnd'   => 'required|min:0|max:100',
        ];
    }
}
