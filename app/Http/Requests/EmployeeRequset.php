<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class EmployeeRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->method() == 'GET'){
            return Gate::allows('employees.view');
        }
        if($this->route('employee') && ($this->method() == 'PUT' || $this->method() == 'GET' )){
            return Gate::allows('employees.edit');
        }
        if($this->method() == 'delete' && $this->route('employee')){
            return Gate::allows('employees.delete');
        }
        return Gate::allows('employees.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('employee');
        return Employee::rules($id);
    }

    public function messages(): array
    {
        return Employee::messages();
    }
}
