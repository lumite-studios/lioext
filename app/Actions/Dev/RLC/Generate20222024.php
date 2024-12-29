<?php

namespace App\Actions\Dev\RLC;

class Generate20222024 extends GenerateYear
{
    public function handle()
    {
        $this->generate(
            'https://www.lioden.wiki/raffle-lioness-directory-4'
        );

        SetUpdate::run(
            'rlc-2022-2024',
            now()->toFormattedDayDateString(),
        );
    }
}
