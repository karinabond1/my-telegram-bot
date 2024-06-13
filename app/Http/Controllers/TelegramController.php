<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws TelegramSDKException
     */
    public function webhook(Request $request): Response|Application|ResponseFactory
    {
        $telegram = new Telegram();
        $update = $telegram->commandsHandler(true);

        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        if ($text == '/start') {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Welcome to my bot! Use /cheap_flights to find cheap flights.'
            ]);
        } elseif ($text == '/cheap_flights') {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Here are the cheapest flights: ...'
            ]);
        }

        return response('OK', 200);
    }
}

