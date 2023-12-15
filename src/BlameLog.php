<?php

namespace RLeroi\BlameLog;

class BlameLog
{
    private const LOG_REGEX = '/at (.+\.php):([0-9]+)\)/i';
    private const BLAME_REGEX = '/[0-9a-fA-F]+ \(([a-z ]+) [0-9]{4}-[0-9\-+ :a-z]+\)/i';

    public static function calculateTotals(string $logFile): array
    {
        $logs = fopen($logFile, 'r');
        $names = [];
        while ($log = fgets($logs)) {
            $matches = [];
            preg_match(self::LOG_REGEX, $log, $matches);
            if (count($matches) < 3) {
                continue;
            }
            [$match, $file, $line] = $matches;
            $dir = dirname($file);
            $errorCode = 0;
            $blame = self::runGitBlame($dir, $file, $line, $errorCode);
            if ($errorCode) {
                continue;
            }

            preg_match(self::BLAME_REGEX, $blame, $matches);
            if (count($matches) < 2) {
                continue;
            }

            $name = array_pop($matches);
            if (!isset($names[$name])) {
                $names[$name] = 0;
            }
            $names[$name]++;
        }
        fclose($logs);

        return $names;
    }

    private static function runGitBlame(string $dir, string $file, int $line, int &$errorCode): string
    {
        $command = "cd $dir && git blame -L $line,$line $file 2>&1";
        $output = [];
        exec($command, $output, $errorCode);

        return implode(PHP_EOL, $output);
    }
}
