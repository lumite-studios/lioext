<?php

namespace App\Actions;

use DOMDocument;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action as BaseAction;

class Action extends BaseAction
{
    public function lioden_url(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) {
            if (! Str::startsWith($value, 'https://www.lioden.com/lion.php')) {
                $fail('Not a valid Lioden url.');
            }
        };
    }

    public function get_lion(string $url): array
    {
        $html = file_get_contents($url);
        $dom = $this->get_dom_document($html);

        $tables = collect($dom->getElementsByTagName('table'));

        // an empty array to build the lion into
        $lion = [];

        // get the sex of the lion from the currents table, default to Male if no sex provided
        $lionCurrentsTable = $this->getTable($tables, 'Lion Currents');
        $lion['Sex'] = in_array('Sex', $lionCurrentsTable?->toArray() ?? []) ? $lionCurrentsTable[8] : 'Male';

        // now get the lions appearance
        $appearanceTable = $this->getTable($tables, 'Appearance');
        [$base, $skin] = explode(' (', $appearanceTable[3]);
        $lion['Base'] = $base;
        $lion['Skin'] = Str::replace(' Skin)', '', $skin);
        $lion['Eyes'] = $appearanceTable[8];
        $lion['Mane_Type'] = $appearanceTable[10];
        $lion['Mane_Color'] = $appearanceTable[12];
        $lion['Mutation'] = $appearanceTable[14];
        collect(explode('Slot', $appearanceTable[4]))
            ->filter()
            ->each(function ($slot) use (&$lion) {
                $slot_parts = explode(':', $slot);
                $marking = explode(' Tier', $slot_parts[1])[0];
                $lion["Slot{$slot_parts[0]}"] = ltrim($marking);
            });

        return $lion;
    }

    private function getTable(Collection $tables, string $title)
    {
        return $tables->filter(fn ($table) => str_contains($table->textContent, $title))
            ->transform(fn ($table) => collect(preg_split("/\t\n|\n|\t/", $table->textContent))->filter()->values())
            ->first();
    }

    public function get_dom_document(string $html): DOMDocument
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;

        return $dom;
    }
}
