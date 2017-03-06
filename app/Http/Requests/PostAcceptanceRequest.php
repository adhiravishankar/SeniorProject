<?php

namespace Caesar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAcceptanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gre_verbal' => 'integer',
            'gre_math' => 'integer',
            'gre_writing' => 'integer',
            'gpa' => 'numeric',
            'college' => 'required|integer',
            'major' => 'required|integer',
            'comment' => 'string',
            'decision' => 'required|integer',
            'method' => 'required|integer',
            'decision_date' => 'required|integer',
            'geo' => 'required|integer',
            'degree_type' => 'required|integer',
            'season' => 'required|integer',
            'year' => 'required|integer'
        ];
    }
}
