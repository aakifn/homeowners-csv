#!/usr/bin/php
<?php

use App\Util\Parser;

if (PHP_SAPI !== 'cli')
{
	exit();
}

require __DIR__ . '/vendor/autoload.php';

$fileName = $argv[1];

if (!$fileName)
{
	echo 'Please provide a path to the CSV file to be imported.' . PHP_EOL;
	exit(1);
}

$path = __DIR__ . DIRECTORY_SEPARATOR . $fileName;

if (!file_exists($path))
{
	echo 'Provided file path does not exist.' . PHP_EOL;
	exit(1);
}

$handle = fopen($path, 'rb');

if (!$handle)
{
	echo 'Unable to read file.' . PHP_EOL;
	exit(1);
}

$homeowners = [];

try
{
	fgetcsv($handle);

	while (($data = fgetcsv($handle)) !== false)
	{
		$fullNameStr = $data[0];
		$parser = new Parser();
		$person = $parser->getPeopleFromString($fullNameStr, $homeowners);
	}
}
catch (Exception $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(1);
}

try
{
	$output = json_encode($homeowners, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
}
catch (Exception $e)
{
	echo $e->getMessage() . PHP_EOL;
	exit(1);
}

echo $output . PHP_EOL;