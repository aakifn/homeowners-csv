<?php

namespace App\Util;

use App\Models\Person;

class Parser
{
	const string COUPLE_SEPARATOR = '&';
	const array ALLOWED_TITLES = [
		'Mr',
		'Mrs',
		'Ms',
		'Mister',
		'Miss',
		'Dr',
		'Prof',
	];

	public function getPeopleFromString(string $nameStr, &$homeowners)
	{
		$nameStr = $this->cleanName($nameStr);
		$nameParts = explode(' ', $nameStr);

		if (strpos($nameStr, self::COUPLE_SEPARATOR))
		{
			$names = explode(self::COUPLE_SEPARATOR, $nameStr, 2);

			$coupleLastName = array_pop($nameParts);

			foreach ($names AS $name)
			{
				$person = $this->getPersonFromName($name, $coupleLastName);
				$homeowners[] = $person;
			}
		}
		else
		{
			$person = $this->getPersonFromName($nameStr);
			$homeowners[] = $person;
		}
	}

	protected function getPersonFromName(string $name, ?string $coupleLastName = null): Person
	{
		$nameParts = explode(' ', $name);
		$person = new Person();

		foreach ($nameParts AS $i => $part)
		{
			$part = trim($part);

			if (in_array($part, self::ALLOWED_TITLES))
			{
				$person->setTitle($part);
				continue;
			}

			if ($i === count($nameParts) - 1)
			{
				$person->setLastName($coupleLastName ?? $part);
				continue;
			}

			if (preg_match('/^[A-Z]\.?$/', $part) || strlen($part) === 1)
			{
				$person->setInitial(rtrim($part, '.'));
				continue;
			}

			if (!$person->getFirstName() && $part)
			{
				$person->setFirstName($part);
			}
		}

		return $person;
	}

	protected function cleanName(string $name): string
	{
		$name = trim($name);
		$name = str_replace(' and ', self::COUPLE_SEPARATOR, $name);

		return $name;
	}
}