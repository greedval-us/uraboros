<?php

interface CallbackActionInterface
{
    public function handle(Handler $handler): void;
}
