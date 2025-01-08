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
                    text: 'Bonjour ' . $individuelle->user->firstname . ' ' . $individuelle->user->name . ', votre formation en ' . $formation?->module?->name . ' va démarrer le ' . $formation?->date_debut?->format('d/m/Y') . ' merci de confirmer votre disponibilité'
                ),
                sender: 'ONFP'
            );

            $request = new SmsRequest(messages: [$message]);

            try {
                $smsResponse = $sendSmsApi->sendSmsMessages($request);

                Alert::success("Felicitations !!!", "SMS envoyé");

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
        $idformation = $request->id;
        dd($idformation);
    }
}
