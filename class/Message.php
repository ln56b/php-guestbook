<?php
namespace General;
// Means this is from root directory - USED when PHP Classes.
use \DateTime;
use \DateTimeZone;

class Message
{
    const MIN_USERNAME = 3;
    const MIN_COMMENT = 10;
    private $username;
    private $comment;
    private $date;

    public static function fromJSON(string $json): Message
    {
        $data = json_decode($json, true);
        return new self($data['username'], $data['comment'], new DateTime("@" . $data['date']));
    }

    public function __construct(string $username, string $comment, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->comment = $comment;
        $this->date = $date ?: new DateTime();
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

    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $comment = nl2br(htmlentities($this->comment));
        $this->date->setTimezone(new DateTimeZone('Europe/Paris'));
        $date = $this->date->format('d/m/Y at H:i');
        return <<<HTML
        <p>
        <strong>{$username}</strong><em>on {$date}</em><br>{$comment}
</p>
HTML;

    }

    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'comment' => $this->comment,
            'date' => $this->date->getTimestamp()
        ]);
    }
}
