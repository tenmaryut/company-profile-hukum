<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConsultationRequest extends FormRequest
{
    /** Kiriman yang lebih cepat dari ini hampir pasti dari bot. */
    public const MIN_FILL_SECONDS = 3;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\s.\-]{6,30}$/'],
            'practice_area_id' => ['nullable', 'integer', Rule::exists('practice_areas', 'id')->where('is_published', true)],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'consent' => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor telepon',
            'practice_area_id' => 'bidang hukum',
            'message' => 'uraian singkat',
            'consent' => 'persetujuan pemberitahuan privasi',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, tanda +, -, titik, atau tanda kurung.',
            'consent.accepted' => 'Centang persetujuan pemberitahuan privasi untuk mengirim permintaan.',
        ];
    }

    /**
     * Honeypot dan jebakan waktu. Hasilnya bukan error validasi: bot diberi
     * respons sukses palsu supaya tidak belajar cara menembusnya.
     */
    public function spamReason(): ?string
    {
        if (filled($this->input('website'))) {
            return 'honeypot';
        }

        try {
            $startedAt = (int) decrypt((string) $this->input('form_started_at'));
        } catch (DecryptException) {
            return 'token-waktu-tidak-valid';
        }

        if (now()->timestamp - $startedAt < self::MIN_FILL_SECONDS) {
            return 'terlalu-cepat';
        }

        return null;
    }
}
