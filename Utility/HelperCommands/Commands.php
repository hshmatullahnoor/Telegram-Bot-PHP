<?php


namespace Utility\HelperCommands;

class Commands
{
    public static function deleteCommand($command)
    {
        $commandName = $command;
        $commandPath = __DIR__ . '/../../App/Commands/BotCommands/' . $commandName . '.php';

        if (file_exists($commandPath)) {
            unlink($commandPath);
            echo "Command {$commandName} deleted successfully." . PHP_EOL;
        } else {
            echo "Command {$commandName} does not exist." . PHP_EOL;
        }
    }

    public static function makeCommand($command)
    {
        $commandName = $command;
        $commandPath = __DIR__ . '/../../App/Commands/BotCommands/' . $commandName . '.php';

        if (file_exists($commandPath)) {
            echo "Command {$commandName} already exists." . PHP_EOL;
            return;
        }

        $Commandtemplate = "<?php\n\nnamespace App\\Commands\\BotCommands;\n\nuse App\\Commands\\Kernal;\nuse App\\Keyboards\\Keyboards;\nuse App\\Telegram\\Telegram;\n\nclass \$commandName extends Kernal\n{\n    public static function handle()\n    {\n\n    // change the command name to your command name\n    // make your favorite logic here\n\n        if (self::\$text == '$commandName') {\n            Telegram::sendMessage()\n                ->chatId(self::\$chatId)\n                ->text(\"Welcome to the bot! Please choose an option:\")\n                ->replyMarkup(Keyboards::mainKeyboard())\n                ->send();\n        }\n    }\n}";


        $commandContent = str_replace('$commandName', $commandName, $Commandtemplate);
        file_put_contents($commandPath, $commandContent);
        echo "Command {$commandName} created successfully." . PHP_EOL;
        echo "You can find it in {$commandPath}" . PHP_EOL;
    }
}
