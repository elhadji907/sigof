<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            Alert::success('Succès', 'Votre email a été vérifié avec succès.');
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
            /* return redirect()->intended(RouteServiceProvider::HOME . '?verified=1')->with('status', 'Votre email a été vérifié avec succès.'); */
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        Alert::success('Succès', 'Votre email a été vérifié avec succès.');
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        /* return redirect()->intended(RouteServiceProvider::HOME . '?verified=1')->with('status', 'Votre email a été vérifié avec succès.'); */
    }
}
