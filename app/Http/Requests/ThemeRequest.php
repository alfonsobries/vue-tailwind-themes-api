<?php

namespace App\Http\Requests;

use App\Models\Theme;
use Illuminate\Foundation\Http\FormRequest;

class ThemeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->theme
            ? $this->user()->can('update', $this->theme)
            : $this->user()->can('store', Theme::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                $this->theme ? 'sometimes' : null,
                $this->theme ? 'unique:themes,name,' . $this->theme->name : 'unique:themes,name',
            ],
            'description' => [
                'required',
                'string',
                $this->theme ? 'sometimes' : null,
            ],
            'settings' => [
                'required',
                'array',
                $this->theme ? 'sometimes' : null,
            ],
        ];
    }
}
