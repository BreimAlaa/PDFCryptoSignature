<?php

class Test
{
    public static function run(): void
    {
        $methods = get_class_methods(static::class);
        $class = get_called_class();
        $class = preg_replace('/(?<!^)[A-Z]/', ' $0', $class);
        $count = 0;
        foreach ($methods as $key=>$method) {
            $msg = ucfirst(str_replace('_', ' ', $method));
            $msg = substr($msg, 5);
            if (strpos($method, 'test') === 0) {
                $count++;
                try {
                    (new static)->$method();
                    echo "\033[32m";
                    echo "$class $count Succeeded: $msg";
                } catch (Throwable  $e) {
                    echo "\033[31m";
                    echo "$class $count Failed: $msg ".$e->getFile().':'.$e->getLine()
                    . PHP_EOL . $e->getMessage().PHP_EOL.$e->getTraceAsString();
                }
                echo PHP_EOL;
            }
        }
    }

    public function assertNotEquals($expected, $actual): void
    {
        if ($expected === $actual) {
            $expected = var_export($expected, true);
            $actual = var_export($actual, true);
            throw new Exception("Expected $expected to not equal $actual");
        }
    }

    public function assertEquals($expected, $actual): void
    {
        if ($expected !== $actual) {
            $expected = var_export($expected, true);
            $actual = var_export($actual, true);
            throw new Exception("Expected $expected to equal $actual");
        }
    }

    public function assertTrue($actual): void
    {
        if (!$actual) {
            $actual = var_export($actual, true);
            throw new Exception('Expected ' . $actual . ' to be true');
        }
    }

    public function assertFalse($actual): void
    {
        if ($actual) {
            $actual = var_export($actual, true);
            throw new Exception('Expected ' . $actual . ' to be false');
        }
    }
    public function assertArrayHasKey($key, $array): void
    {
        if (!array_key_exists($key, $array)) {
            $array = var_export($array, true);
            throw new Exception('Expected ' . $array . ' to have key ' . $key);
        }
    }
}