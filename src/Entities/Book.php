<?php

declare(strict_types=1);

namespace App\Entities;

/** @Entity */
class Book implements \JsonSerializable
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @var string
     * @Column(type="string")
     */
    private string $name;

    /**
     * @ManyToOne(targetEntity="App\Entities\Author", cascade={"persist", "remove"}, inversedBy="books")
     * @JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private ?Author $author;

    public function __construct(string $name, Author $author)
    {
        $this->name = $name;
        $this->author = $author;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => (string) $this->author
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function toArray()
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}
