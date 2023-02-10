<?php

namespace App\Http\Requests\TwoFactor;

use App\Enums\TwoFactorEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnableRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $types = collect(TwoFactorEnum::getValues())->diff([TwoFactorEnum::NONE])->values();

        return [
            'type' => [
                'required',
                'string',
                Rule::in($types->toArray()),
            ],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes(): array
    {
        return [
            'type' => trans('Type'),
        ];
    }
}
