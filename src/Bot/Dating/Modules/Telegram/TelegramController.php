<?php

namespace App\Bot\Dating\Modules\Telegram;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class TelegramController extends AbstractController
{
    /**
     * @var BotApi
     */
    private $telegramBot;

    public function __construct(BotApi $telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function webhook(Request $request): Response
    {
        $update = json_decode($request->getContent(), true);

        // Process incoming update
        // You can handle different types of updates here, e.g. text messages, commands, inline queries, etc.
        // For simplicity, this example only handles text messages
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $messageText = $update['message']['text'];

            // Do something with the message text
            // For example, send a reply back to the user
            $this->telegramBot->sendMessage($chatId, "You said: $messageText");
        }

        // Always return a 200 OK response to acknowledge receipt of the update
        return new Response('OK', 200);
    }
}
