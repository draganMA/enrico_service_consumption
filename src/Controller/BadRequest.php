<?php

namespace App\Controller;

interface BadRequest
{
    public function handleBadRequest($message, $args);
}