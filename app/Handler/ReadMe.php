<?php

namespace App\Handler;

use Illuminate\Http\Request;

class ReadMe implements \ReadMe\Handler
{
    /**
     * This is a grouping callback that's run for every metric sent to ReadMe,
     * and is a way for you to group metrics against a specific user. This
     * function must return an array with at least an `api_key` that represents
     * a unique identifier for the callee (session ID, user ID, etc.).
     *
     * Optionally, you may also return the following:
     *
     *  - `label`: This will be used to identify the user on ReadMe, since it's
     *      much easier to remember a name than a unique identifier.
     *  - `email`: Email of the person that is making the call.
     *
     * @link https://docs.readme.com/docs/sending-api-logs-to-readme
     */
    public static function constructGroup(Request $request): array
    {
        return [
            'api_key' => session()->getId(),
        ];
    }
}
