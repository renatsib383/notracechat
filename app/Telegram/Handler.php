<?php

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Log;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class Handler extends WebhookHandler
{

    public function __construct()
    {
        $bot = TelegraphBot::find(1);
        $bot->registerCommands([
            'hello' => 'Привет!',
            'help' => 'Помощь',
            'actions' => 'Действия',
        ])->send();
    }

    public function hello(string $name): void{
        $this->reply("Hello, $name!");
    }

    public function help(): void{
        $this->reply('*Помощь*');
    }

    // public function like(): void{
    //     $this->reply('Вы нажали на кнопку "Like"');
    // }

    // public function dislike(): void{
    //     $this->reply('Вы нажали на кнопку "Dislike"');
    // }

    public function actions(): void{
        // Получаем chat_id из входящего сообщения
    $chatId = $this->chat->chat_id;

    Telegraph::chat($chatId) // Добавляем chat_id
        ->message('*Действия*')
        ->keyboard(
            Keyboard::make()->buttons([
                Button::make('Чат 1')->webApp('https://tgchat.atloncrm.ru/chat/1'),
                Button::make('Чат 2')->webApp('https://tgchat.atloncrm.ru/chat/2'),
                Button::make('Чат 3')->webApp('https://tgchat.atloncrm.ru/chat/3'),
            ])
        )
        ->send();
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
         if($text->value() === '/start'){
            $this->reply('Привет!');
         }else{
            $this->reply('Я не знаю этой команды');
         }
    }

    protected function handleChatMessage(Stringable $text): void
    {
        Log::info($this->message);
        $this->reply($text);
    }
}
