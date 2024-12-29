<?php

namespace App\Actions\RLC;

use App\Actions\Action;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;

class SearchRLC extends Action
{
    const BASE = 'Base';

    const SKIN = 'Skin';

    const EYES = 'Eyes';

    const MANE_TYPE = 'Mane Type';

    const MANE_COLOR = 'Mane Color';

    const SLOT_1 = 'Slot 1';

    const SLOT_2 = 'Slot 2';

    const SLOT_3 = 'Slot 3';

    const SLOT_4 = 'Slot 4';

    const SLOT_5 = 'Slot 5';

    const SLOT_6 = 'Slot 6';

    const SLOT_7 = 'Slot 7';

    const SLOT_8 = 'Slot 8';

    const SLOT_9 = 'Slot 9';

    const SLOT_10 = 'Slot 10';

    const MUTATION = 'Mutation';

    protected array $lion = [];

    protected array $compares = [];

    protected string $percentage;

    public function rules(): array
    {
        return [
            'compares' => ['required', 'array'],
            'percentage' => ['required'],
            'url' => ['required', 'url', $this->lioden_url()],
            'years' => ['required', 'array'],
        ];
    }

    public function handle(array $data = [])
    {
        $this->compares = $data['compares'];
        $this->percentage = ($data['percentage'] / count($data['compares'])) * 100;

        // get the lion
        $this->lion = $this->get_lion($data['url']);

        if (config('app.env') !== 'local') {
            Log::info("Searched rlc for: {$data['url']}");
        }

        // ensure years are sorted newest to oldest
        return collect($data['years'])
            ->sortDesc()
            // now get the json file for that year
            ->mapWithKeys(function ($year) {
                $json = Storage::get("dev/{$year}.json");

                return [$year => json_decode($json, true)];
            })
            ->transform(function ($year) {

                return collect($year)
                    ->transform(function ($raffle, $date) {
                        $matches = [];
                        // base & skin
                        $base_skin = explode('(', $raffle['Base']);
                        $base = $base_skin[0];
                        $skin = $base_skin[1];
                        if (Str::startsWith($this->lion['Base'], $base)) {
                            if (in_array(self::BASE, $this->compares)) {
                                $matches[] = self::BASE;
                            }
                        }
                        if (Str::endsWith($this->lion['Skin'], $skin)) {
                            if (in_array(self::SKIN, $this->compares)) {
                                $matches[] = self::SKIN;
                            }
                        }
                        // eyes
                        if ($raffle['Eyes'] === $this->lion['Eyes']) {
                            if (in_array(self::EYES, $this->compares)) {
                                $matches[] = self::EYES;
                            }
                        }
                        // mane type & mane color
                        $mane = explode(' ', $raffle['Mane'], 2);
                        $mane_type = $mane[0];
                        $mane_color = $mane[1];
                        if (Str::startsWith($this->lion['Mane_Type'], $mane_type)) {
                            if (in_array(self::MANE_TYPE, $this->compares)) {
                                $matches[] = self::MANE_TYPE;
                            }
                        }
                        if (Str::endsWith($this->lion['Mane_Color'], $mane_color)) {
                            if (in_array(self::MANE_COLOR, $this->compares)) {
                                $matches[] = self::MANE_COLOR;
                            }
                        }
                        // mutation
                        if ($this->lion['Mutation'] !== 'None' && $raffle['Mutation'] === $this->lion['Mutation']) {
                            if (in_array(self::MUTATION, $this->compares)) {
                                $matches[] = self::MUTATION;
                            }
                        }
                        // slots
                        for ($i = 1; $i <= 10; $i++) {
                            $slot_name = constant("self::SLOT_{$i}");
                            if (array_key_exists($slot_name, $this->lion)) {
                                $raffle_slot = $raffle[$slot_name];
                                $slot_parts = explode('(', $raffle_slot);
                                $marking = $slot_parts[0];
                                $opacity = $slot_parts[1];
                                if (Str::startsWith($this->lion[$slot_name], $marking)) {
                                    if (in_array($slot_name, $this->compares)) {
                                        $matches[] = $slot_name;
                                    }
                                }
                            }
                        }

                        return array_merge([
                            'date' => $date,
                            'matches' => $matches,
                            'percent' => (count($matches) / count($this->compares)) * 100,
                        ], $raffle);
                    })
                    ->filter(function ($raffle) {
                        return $raffle['percent'] >= $this->percentage;
                    });
            })
            ->flatten(1)
            ->sortByDesc('percent')
            ->values();
    }

    public function asController(ActionRequest $request)
    {
        $matches = $this->handle($request->all());
        session()->flash('matches', $matches);

        return redirect()->back();
    }

    public static function getCompares(): array
    {
        return [
            self::BASE,
            self::SKIN,
            self::EYES,
            self::MANE_TYPE,
            self::MANE_COLOR,
            self::SLOT_1,
            self::SLOT_2,
            self::SLOT_3,
            self::SLOT_4,
            self::SLOT_5,
            self::SLOT_6,
            self::SLOT_7,
            self::SLOT_8,
            self::SLOT_9,
            self::SLOT_10,
            self::MUTATION,
        ];
    }
}
