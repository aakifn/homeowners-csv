<?php

namespace App\Models;

class Person implements \JsonSerializable, \ArrayAccess
{
	private ?string $title = null;
	private ?string $lastName = null;
	private ?string $firstName = null;
	private ?string $initial = null;

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function setFirstName(?string $firstName): void
	{
		$this->firstName = $firstName;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): void
	{
		$this->lastName = $lastName;
	}

	public function getInitial(): ?string
	{
		return $this->initial;
	}

	public function setInitial(?string $initial): void
	{
		$this->initial = $initial;
	}

	public function jsonSerialize(): array
	{
		return [
			'title' => $this->title,
			'initial' => $this->initial,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName
		];
	}

	public function offsetExists(mixed $offset): bool
	{
		return $this->offsetGet($offset) !== null;
	}

	public function offsetGet(mixed $offset): ?string
	{
		switch ($offset)
		{
			case 'title': return $this->title;
			case 'firstName': return $this->firstName;
			case 'lastName': return $this->lastName;
			case 'initial': return $this->initial;

			default:
				trigger_error("Unknown offset '$offset'");
		}
	}

	public function offsetSet(mixed $offset, mixed $value): void
	{
		throw new \LogicException("Cannot set offsets");
	}

	public function offsetUnset(mixed $offset): void
	{
		throw new \LogicException("Cannot set offsets");
	}
}