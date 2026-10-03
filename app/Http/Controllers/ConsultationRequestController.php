<?php

namespace App\Http\Controllers;

use App\Enums\ConsultationStatus;
use App\Http\Requests\StoreConsultationRequest;
use App\Models\ConsultationRequest;
use App\Models\PracticeArea;
use App\Models\User;
use App\Notifications\NewConsultationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConsultationRequestController extends Controller
{
    public function create(): View
    {
        return view('pages.contact', [
            'practiceAreas' => PracticeArea::published()->get(['id', 'name', 'slug']),
            'formStartedAt' => encrypt(now()->timestamp),
        ]);
    }

    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        $redirect = redirect()->to(route('contact').'#form-konsultasi');

        if ($reason = $request->spamReason()) {
            Log::notice('Kiriman form konsultasi diabaikan sebagai spam.', ['alasan' => $reason]);

            return $redirect->with('consultation_sent', now()->addDays(ConsultationRequest::RETENTION_DAYS));
        }

        $token = $request->cookie(ConsultationRequest::SUBMITTER_COOKIE);

        if (! is_string($token) || strlen($token) !== 40) {
            $token = Str::random(40);
        }

        $consultation = ConsultationRequest::create([
            ...$request->safe()->only(['name', 'email', 'phone', 'practice_area_id', 'message']),
            'status' => ConsultationStatus::Baru,
            'consented_at' => now(),
            'submitter_token_hash' => ConsultationRequest::hashToken($token),
        ]);

        Notification::send(User::all(), new NewConsultationRequest($consultation));

        Cookie::queue(ConsultationRequest::SUBMITTER_COOKIE, $token, 60 * 24 * ConsultationRequest::RETENTION_DAYS, sameSite: 'lax');

        return $redirect->with('consultation_sent', $consultation->deleteAt());
    }
}
