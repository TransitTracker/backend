<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class Recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (App::environment('local')) {
            return true;
        }

        $client = new Client();

        $response = $client->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => config('transittracker.recaptcha.secret'),
                    'response' => $value,
                    'remoteIp' => request()->ip(),
                ],
            ],
        );

        if ($response->getStatusCode() === 200) {
            $body = json_decode((string) $response->getBody());

            return $body->success;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The reCAPTCHA validation has failed.';
    }
}
