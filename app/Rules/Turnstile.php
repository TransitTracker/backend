<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class Turnstile implements Rule
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

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('transittracker.turnstile.secret'),
            'response' => $value,
            'remoteip' => request()->header('CF-Connecting-IP') ?? request()->ip(),
        ]);

        if ($response->ok()) {
            return $response->json('success');
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
        return 'The Captcha validation has failed.';
    }
}
