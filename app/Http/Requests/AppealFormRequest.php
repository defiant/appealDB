<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppealFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name'    => 'required',
            'event_session' => 'required',
            'event_level'   => 'required',
            'board_no'      => 'integer',
            'facts'         => 'required',
            'appeal_reason' => 'required',
            'ruling'        => 'required',
            'decision'      => 'required'
        ];
    }
}
