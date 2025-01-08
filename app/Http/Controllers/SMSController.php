<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Infobip\ApiException;
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsMessage;
use Infobip\Model\SmsRequest;
use Infobip\Model\SmsTextContent;
use RealRashid\SweetAlert\Facades\Alert;

class SMSController extends Controller
{

    public function sendFormationSMS(Request $request)
    {
        $data = request()->validate([
            'titre' => ['required', 'string', 'max:7'],
            'sms' => ['required', 'string', 'max:128'],

        ]);

        $formation = Formation::findOrFail($request->id);

        $configuration = new Configuration(
            host: '1gr529.api.infobip.com',
            apiKey: '34c32d6cfad602ef077241fe3e568dd0-e65adb7c-8209-452a-962a-dfb66979a0c0'
        );

        foreach ($formation->individuelles as $key => $individuelle) {
            $sendSmsApi = new SmsApi(config: $configuration);
            $message = new SmsMessage(
                destinations: [
                    new SmsDestination(
                        to: '221' . $individuelle->user->telephone
                    ),
                ],
                content: new SmsTextContent(
                    text: $request?->titre
                    . ', ' . $individuelle?->user?->civilite
                    . ' ' . $individuelle->user->name
                    . ' ' . $request?->sms
                ),
                sender: 'ONFP'
            );

            $request = new SmsRequest(messages: [$message]);

            try {
                $smsResponse = $sendSmsApi->sendSmsMessages($request);

                Alert::success("Effectué !!!", "SMS envoyé");

                return redirect()->back();
            } catch (ApiException $apiException) {
                // HANDLE THE EXCEPTION

                Alert::warning("Désolez !!!", "Echec de l'envoi");

                return redirect()->back();
            }
        }
    }

    public function sendWelcomeSMS(Request $request)
    {
        $data = request()->validate([
            'titre' => ['required', 'string', 'max:7'],
            'sms' => ['required', 'string', 'max:128'],

        ]);

        $formation = Formation::findOrFail($request->id);

        $configuration = new Configuration(
            host: '1gr529.api.infobip.com',
            apiKey: '34c32d6cfad602ef077241fe3e568dd0-e65adb7c-8209-452a-962a-dfb66979a0c0'
        );

        foreach ($formation->individuelles as $key => $individuelle) {
            $sendSmsApi = new SmsApi(config: $configuration);
            $message = new SmsMessage(
                destinations: [
                    new SmsDestination(
                        to: '221' . $individuelle->user->telephone
                    ),
                ],
                content: new SmsTextContent(
                    text: $request?->titre
                    . ', ' . $individuelle?->user?->civilite
                    . ' ' . $individuelle->user->name
                    . ' ' . $request?->sms
                    . ' ' . $individuelle?->note_obtenue . '/20'
                    . ' avec la mention ' . $individuelle?->appreciation
                ),
                sender: 'ONFP'
            );

            $request = new SmsRequest(messages: [$message]);

            try {
                $smsResponse = $sendSmsApi->sendSmsMessages($request);

                Alert::success("Effectué !!!", "SMS envoyé");

                return redirect()->back();
            } catch (ApiException $apiException) {
                // HANDLE THE EXCEPTION

                Alert::warning("Désolez !!!", "Echec de l'envoi");

                return redirect()->back();
            }
        }
    }
}
