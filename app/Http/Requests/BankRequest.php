<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->method() == 'GET'){
            return Gate::allows('banks.view');
        }
        if($this->route('bank') && ($this->method() == 'PUT' || $this->method() == 'GET' )){
            return Gate::allows('banks.edit');
        }
        if($this->method() == 'delete' && $this->route('bank')){
            return Gate::allows('banks.delete');
        }
        return Gate::allows('banks.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
