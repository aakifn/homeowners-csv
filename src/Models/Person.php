<?php

namespace App\Models;

class Person implements \JsonSerializable
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
}