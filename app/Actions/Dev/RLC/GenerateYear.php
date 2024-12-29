<?php

namespace App\Actions\Dev\RLC;

use App\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

abstract class GenerateYear extends Action
{
    /**
     * The prefix to apply to the filenames.
     */
    private string $filenamePrefix = 'dev';

    public function generate(string $url)
    {
        $html = $this->get_html_content($url);

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;

        $output = collect($dom->getElementsByTagName('div'))
            ->filter(function (\DOMElement $element) {
                return $element->getAttribute('class') === 'collapsible-block';
            })
            ->mapWithKeys(function (\DOMElement $year) {
                $children = collect($year->childNodes)
                    ->filter(function ($child) {
                        return $child instanceof \DomElement;
                    });

                $_year = Carbon::parse($children->first()->textContent)->year;

                return [$_year => $children->filter(function ($child) {
                    return $child->nodeName === 'h3' || $child->nodeName === 'div';
                })
                    ->chunk(2)
                    ->mapWithKeys(function (Collection $raffle) {
                        $h3 = $raffle->first();
                        $date = $h3->textContent;
                        $date = Carbon::parse($h3->textContent)->toDateString();

                        $lion = $raffle->last();
                        $image = $lion->childNodes[1]->childNodes[1]->childNodes[1]->getAttribute('src');
                        $output = collect(preg_split('/ \n/', $lion->textContent))
                            ->transform(fn ($option) => trim($option))
                            ->filter()
                            ->transform(function ($option) {
                                $data = collect(preg_split('/\n/', $option))
                                    ->transform(fn ($_option) => str_replace('[Raffle]', '', $_option))
                                    ->transform(fn ($_option) => trim($_option));

                                return [$data->first() => $data->last()];
                            })
                            ->mapWithKeys(fn ($option) => $option);

                        return [$date => array_merge(['image' => $image], $output->toArray())];
                    })];
            });

        $this->store_output($output);
    }

    protected function get_html_content(string $url): string
    {
        $filepath = $this->filenamePrefix.'/html/'.last(explode('/', $url)).'.txt';

        return file_get_contents($url);
    }

    protected function store_output(Collection $output)
    {
        $output->each(function ($options, $year) {
            $filepath = $this->filenamePrefix.'/'.$year.'.json';
            Storage::put($filepath, json_encode($options));
        });
    }
}
