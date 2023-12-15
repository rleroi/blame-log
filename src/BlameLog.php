<?php

namespace RLeroi\BlameLog;

class BlameLog {
    public static function calculateTotals(string $logFile): array
    {
        $logs = fopen($logFile, 'r');
        $names = [];
        while($log = fgets($logs)) {
            $matches = [];
            preg_match('/at (.+\.php):([0-9]+)\)/i', $log, $matches);
            if (count($matches) < 3) {
                continue;
            }
            [$match, $file, $line] = $matches;
            $dir = dirname($file);
            $resultCode = 0;
            $blame = exec("cd $dir && git blame -L $line,$line $file 2>&1", result_code: $resultCode);
            if ($resultCode) {
                continue;
            }

            preg_match('/[0-9a-fA-F]+ \(([a-z ]+) [0-9]{4}-[0-9\-+ :a-z]+\)/i', $blame, $matches);
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
}
