<?php

namespace App\Actions\Dev\RLC;

class Generate20252027 extends GenerateYear
{
    public function handle()
    {
        $this->generate(
            'https://www.lioden.wiki/raffle-lioness-directory-5'
        );

        SetUpdate::run(
            'rlc-2025-2027',
            now()->toFormattedDayDateString(),
        );
    }
}
