<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/** @Entity **/
class Author implements \JsonSerializable
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @OneToMany(targetEntity="App\Entities\Book", cascade={"persist", "remove"}, mappedBy="author")
    */
    private Collection $books;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->books = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'books' => $this->books->map(fn (Book $item) : array => $item->toArray())->toArray()
        ];
    }

    public function __toString()
    {
        return $this->name;
    }
}
