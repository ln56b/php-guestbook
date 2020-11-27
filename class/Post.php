<?php

namespace General;

class Post
{

    public $id;
    public $name;
    public $content;
    public $created_at;

    public function __construct()
    {
        if (is_int($this->created_at) || is_string($this->created_at)) {
            $this->created_at = new \DateTime('@' . $this->created_at);
        }
    }

    // Test on parseDown library
    public function getBody(): string
    {
        $parsedown = new \Parsedown();
        $parsedown->setSafeMode(true);
        return $parsedown->text($this->content);
    }

    public function getExcerpt(): string
    {
        return substr($this->content, 0, 150);
    }
}
