<?php

namespace App\Http\Requests\Store;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreContact
 * @package App\Http\Requests\Store
 */
class StoreContact extends FormRequest
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
            'type' => 'required|in:'. implode(',', Contact::$TYPES),
            'name' => 'required',
        ];
    }
}
