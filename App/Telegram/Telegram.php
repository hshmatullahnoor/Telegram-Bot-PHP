<?php

namespace App\Telegram;

use App\Telegram\Methods\SendMessage;
use App\Telegram\Methods\ForwardMessage;
use App\Telegram\Methods\ForwardMessages;
use App\Telegram\Methods\CopyMessage;
use App\Telegram\Methods\CopyMessages;
use App\Telegram\Methods\SendPhoto;
use App\Telegram\Methods\SendAudio;
use App\Telegram\Methods\SendDocument;
use App\Telegram\Methods\SendVideo;
use App\Telegram\Methods\SendPaidMedia;
use App\Telegram\Methods\SendLocation;
use App\Telegram\Methods\SendChatAction;
use App\Telegram\Methods\SetMessageReaction;
use App\Telegram\Methods\GetUserProfilePhotos;
use App\Telegram\Methods\SetUserEmojiStatus;
use App\Telegram\Methods\GetFile;
use App\Telegram\Methods\GetChatMemberCount;
use App\Telegram\Methods\GetChatMember;
use App\Telegram\Methods\AnswerCallbackQuery;
use App\Telegram\Methods\GetUserChatBoosts;
use App\Telegram\Methods\BotConfig\SetMyCommands;
use App\Telegram\Methods\BotConfig\DeleteMyCommands;
use App\Telegram\Methods\BotConfig\GetMyCommands;
use App\Telegram\Methods\EditMessage\EditMessageText;
use App\Telegram\Methods\EditMessage\EditMessageCaption;
use App\Telegram\Methods\EditMessage\EditMessageMedia;
use App\Telegram\Methods\DeleteMessage;
use App\Telegram\Methods\DeleteMessages;

class Telegram
{
    public static function sendMessage(): SendMessage
    {
        return new SendMessage();
    }

    public static function forwardMessage(): ForwardMessage
    {
        return new ForwardMessage();
    }

    public static function forwardMessages(): ForwardMessages
    {
        return new ForwardMessages();
    }

    public static function copyMessage(): CopyMessage
    {
        return new CopyMessage();
    }

    public static function copyMessages(): CopyMessages
    {
        return new CopyMessages();
    }

    public static function sendPhoto(): SendPhoto
    {
        return new SendPhoto();
    }

    public static function sendAudio(): SendAudio
    {
        return new SendAudio();
    }

    public static function sendDocument(): SendDocument
    {
        return new SendDocument();
    }

    public static function sendVideo(): SendVideo
    {
        return new SendVideo();
    }

    public static function sendPaidMedia(): SendPaidMedia
    {
        return new SendPaidMedia();
    }

    public static function sendLocation(): SendLocation
    {
        return new SendLocation();
    }

    public static function sendChatAction(): SendChatAction
    {
        return new SendChatAction();
    }

    public static function setMessageReaction(): SetMessageReaction
    {
        return new SetMessageReaction();
    }

    public static function getUserProfilePhotos(): GetUserProfilePhotos
    {
        return new GetUserProfilePhotos();
    }

    public static function setUserEmojiStatus(): SetUserEmojiStatus
    {
        return new SetUserEmojiStatus();
    }

    public static function getFile(): GetFile
    {
        return new GetFile();
    }

    public static function getChatMemberCount(): GetChatMemberCount
    {
        return new GetChatMemberCount();
    }

    public static function getChatMember(): GetChatMember
    {
        return new GetChatMember();
    }

    public static function answerCallbackQuery(): AnswerCallbackQuery
    {
        return new AnswerCallbackQuery();
    }

    public static function getUserChatBoosts(): GetUserChatBoosts
    {
        return new GetUserChatBoosts();
    }

    public static function setMyCommands(): SetMyCommands
    {
        return new SetMyCommands();
    }

    public static function deleteMyCommands(): DeleteMyCommands
    {
        return new DeleteMyCommands();
    }

    public static function getMyCommands(): GetMyCommands
    {
        return new GetMyCommands();
    }

    public static function editMessageText(): EditMessageText
    {
        return new EditMessageText();
    }

    public static function editMessageCaption(): EditMessageCaption
    {
        return new EditMessageCaption();
    }

    public static function editMessageMedia(): EditMessageMedia
    {
        return new EditMessageMedia();
    }

    public static function deleteMessage(): DeleteMessage
    {
        return new DeleteMessage();
    }

    public static function deleteMessages(): DeleteMessages
    {
        return new DeleteMessages();
    }
}
