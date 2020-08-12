<?php

declare(strict_types=1);

namespace App\Entity;


class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $currency;


    private $sum;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $patronymic;


    public function handleRequest(array $array)
    {
        $class = new \ReflectionClass(get_class($this));
        $props = $class->getProperties();
        foreach($props as $p) {
            if (isset($array[$p->getName()])){
                $p->setAccessible(true);
                $p->setValue($this, htmlspecialchars($array[$p->getName()],  ENT_QUOTES));
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return (int)$this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = htmlspecialchars($email, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = htmlspecialchars($currency, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getSum(): string
    {
        return $this->sum;
    }

    /**
     * @param string $sum
     */
    public function setSum(string $sum)
    {
        $this->sum = htmlspecialchars($sum, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = htmlspecialchars($firstname, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = htmlspecialchars($lastname, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     */
    public function setPatronymic(string $patronymic)
    {
        $this->patronymic = htmlspecialchars($patronymic, ENT_QUOTES);
    }
}