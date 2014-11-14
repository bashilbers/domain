<?php

namespace Domain\Commands\CommandBus;

interface CommandBus
{
    public function handle($command);
}

