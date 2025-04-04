<?php

namespace Classes\Telegram;

use Classes\Telegram\Methods\SendMessage;
use Classes\Telegram\Methods\ForwardMessage;
use Classes\Telegram\Methods\ForwardMessages;
use Classes\Telegram\Methods\CopyMessage;
use Classes\Telegram\Methods\CopyMessages;
use Classes\Telegram\Methods\SendPhoto;
use Classes\Telegram\Methods\SendAudio;
use Classes\Telegram\Methods\SendDocument;
use Classes\Telegram\Methods\SendVideo;
use Classes\Telegram\Methods\SendPaidMedia;
use Classes\Telegram\Methods\SendLocation;
use Classes\Telegram\Methods\SendChatAction;
use Classes\Telegram\Methods\SetMessageReaction;
use Classes\Telegram\Methods\GetUserProfilePhotos;
use Classes\Telegram\Methods\SetUserEmojiStatus;
use Classes\Telegram\Methods\GetFile;
use Classes\Telegram\Methods\GetChatMemberCount;
use Classes\Telegram\Methods\GetChatMember;
use Classes\Telegram\Methods\AnswerCallbackQuery;
use Classes\Telegram\Methods\GetUserChatBoosts;
use Classes\Telegram\Methods\BotConfig\SetMyCommands;
use Classes\Telegram\Methods\BotConfig\DeleteMyCommands;
use Classes\Telegram\Methods\BotConfig\GetMyCommands;
use Classes\Telegram\Methods\EditMessage\EditMessageText;
use Classes\Telegram\Methods\EditMessage\EditMessageCaption;
use Classes\Telegram\Methods\EditMessage\EditMessageMedia;
use Classes\Telegram\Methods\DeleteMessage;
use Classes\Telegram\Methods\DeleteMessages;

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
