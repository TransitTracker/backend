<?php

namespace App\Http\Controllers\Api\V2\Push;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\NotificationUserResource;
use App\Models\Agency;
use App\Models\NotificationUser;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
            'isFrench' => 'required|boolean',
        ]);

        $user = NotificationUser::firstOrCreate(
            ['endpoint' => $request->endpoint],
            ['is_french' => $request->isFrench, 'is_active' => true, 'subscribed_electric_stm' => false, 'subscribed_general_news' => true],
        );

        $user->updatePushSubscription($request->endpoint, $request->keys['p256dh'], $request->keys['auth']);

        return NotificationUserResource::make($user);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid',
            'endpoint' => 'required|url',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
        ]);

        $user = NotificationUser::where('uuid', $request->uuid)->firstOrFail();

        if ($user->endpoint !== $request->endpoint) {
            $user->endpoint = $request->endpoint;
            $user->is_active = true;
            $user->save();

            $user->updatePushSubscription($request->endpoint, $request->keys['p256dh'], $request->keys['auth']);
        }

        return NotificationUserResource::make($user);
    }

    public function show(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid',
        ]);

        return NotificationUserResource::make(NotificationUser::where('uuid', $request->uuid)->firstOrFail());
    }

    public function update(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid',
            'generalNews' => 'present|boolean',
            'agencies' => 'present|array',
            'isFrench' => 'required|boolean',
        ]);

        $user = NotificationUser::where('uuid', $request->uuid)->firstOrFail();

        $agencies = Agency::whereIn('slug', $request->agencies)->get();

        $user->agencies()->sync($agencies);

        $user->subscribed_general_news = $request->generalNews;
        // TODO: Remove electric STM agross the app
        $user->subscribed_electric_stm = false;
        $user->is_french = $request->isFrench;
        $user->save();
        $user->refresh();

        return NotificationUserResource::make($user);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid',
        ]);

        $user = NotificationUser::where('uuid', $request->uuid)->firstOrFail();

        $user->deletePushSubscription($user->endpoint);
        $user->delete();

        return response()->json(['success' => true]);
    }
}
