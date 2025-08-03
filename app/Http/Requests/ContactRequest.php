<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('messages.first_name')]),
            'last_name.required' => __('validation.required', ['attribute' => __('messages.last_name')]),
            'email.required' => __('validation.required', ['attribute' => __('messages.email')]),
            'email.email' => __('validation.email', ['attribute' => __('messages.email')]),
            'subject.required' => __('validation.required', ['attribute' => __('messages.subject')]),
            'message.required' => __('validation.required', ['attribute' => __('messages.message')]),
            'message.max' => __('validation.max.string', ['attribute' => __('messages.message'), 'max' => 2000]),
        ];
    }

    /**
     * Get custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'first_name' => __('messages.first_name', ['default' => 'first name']),
            'last_name' => __('messages.last_name', ['default' => 'last name']),
            'email' => __('messages.email', ['default' => 'email']),
            'phone' => __('messages.phone', ['default' => 'phone']),
            'subject' => __('messages.subject', ['default' => 'subject']),
            'message' => __('messages.message', ['default' => 'message']),
        ];
    }
}