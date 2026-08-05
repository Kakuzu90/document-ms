<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviseDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization is handled by policy in the controller
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
