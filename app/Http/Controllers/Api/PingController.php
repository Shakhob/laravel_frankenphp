<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function ping(Request $request)
    {
        $user = [
            'id' => rand(1, 10000),
            'name' => $request->input('name', 'Shaxobiddinssss'),
            'roles' => $request->input('roles', ['user']),
            'profile' => [
                'age' => $request->input('age', 30),
                'country' => $request->input('country', 'Uzbekistan'),
            ],
        ];

        return response()->json([
            'message' => $request->input('message', 'pongddddd'),
            'status' => true,
            'timestamp' => now()->toIso8601String(),
            'user' => $user,
            'data' => range(1, (int)$request->input('data_count', 100)),
            'settings' => [
                'theme' => $request->input('theme', 'dark'),
                'notifications' => (bool) $request->input('notifications', false),
                'languages' => $request->input('languages', ['php', 'js', 'ru', 'en']),
            ],
            'links' => [
                'github' => $request->input('github', 'https://github.com/'),
                'docs' => $request->input('docs', 'https://laravel.com/docs'),
            ],
            'long_text' => str_repeat(
                $request->input('long_text', 'Lorem ipsum dolor sit amet, '),
                (int)$request->input('long_text_length', 100)
            ),
        ]);
    }
}
