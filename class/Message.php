<?php

class Message
{
    const MIN_USERNAME = 3;
    const MIN_COMMENT = 10;
    private $username;
    private $comment;

    public function __construct(string $username, string $comment, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->comment = $comment;
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function getErrors(): array
    {
        $errors = [];
        if (strlen($this->username) < self::MIN_USERNAME) {
            $errors['username'] = 'Your login should be at least 3 characters';
        }
        if (strlen($this->comment) < self::MIN_COMMENT) {
            $errors['comment'] = 'Your comment should be at least 10 characters';
        }
        return $errors;
    }
}
