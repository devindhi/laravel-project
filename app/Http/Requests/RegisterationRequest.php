<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:2'],
            'contact' => ['required'],
            'email' => ['required','email:filter'],
            'password' => 'required|min:6|confirmed',


        ];
    }

    public function getPassword(): string
    {
        return str_replace(' ', '', $this->request->get('password'));
    }
    public function getEmail()
    {
        return trim($this->request->get('email'));
    }
    public function getName()
    {
        return trim($this->request->get('name'));
    }
    public function getContact()
{
    return $this->request->get('contact');
}

}
