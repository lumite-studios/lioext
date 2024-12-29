<?php

namespace App\Actions\Image;

use App\Actions\Action;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;

class GenerateImage extends Action
{
    public function rules(): array
    {
        return [
            'url' => ['url', 'required', function (string $attribute, mixed $value, \Closure $fail) {
                if (! Str::startsWith($value, 'https://www.lioden.com/lion.php')) {
                    $fail('Not a valid Lioden url.');
                }
            }],
            'background' => ['boolean'],
            'cubs' => ['boolean'],
            'decorations' => ['boolean'],
            'forceAdultMale' => ['boolean'],
            'forceAdultFemale' => ['boolean'],
            'opacity' => ['boolean'],
        ];
    }

    public function handle(array $data = [])
    {
        $background = $data['background'] ?? false;
        $cubs = $data['cubs'] ?? false;
        $decorations = $data['decorations'] ?? false;
        $forceAdultMale = $data['forceAdultMale'] ?? false;
        $forceAdultFemale = $data['forceAdultFemale'] ?? false;
        $opacity = $data['opacity'] ?? false;

        $html = file_get_contents($data['url']);

        // use DOMDocument to load the page
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;

        // get the lion images
        $images = collect($dom->getElementsByTagName('img'))
            ->transform(function ($image) use ($background, $cubs, $decorations, $forceAdultMale, $forceAdultFemale, $opacity) {
                $src = $image->getAttribute('src');
                $style = $image->getAttribute('style');

                // remove non-lion related images
                if (! Str::contains($src, ['dynamic', 'decors'])) {
                    return null;
                }

                // remove background if needed
                if (! $background && Str::contains($src, 'backgrounds')) {
                    return null;
                }

                // remove cubs if needed
                if (! $cubs && Str::contains($src, 'cubkitten')) {
                    return null;
                }

                // remove decors if needed
                if (! $decorations && Str::contains($src, 'decors') && ! Str::contains($src, 'cubkitten')) {
                    return null;
                }

                // force adult if needed
                if ($forceAdultMale) {
                    if (Str::contains($src, 'lioness')) {
                        $src = Str::replaceFirst('lioness', 'lion', $src);
                    }
                    if (Str::contains($src, 'cub')) {
                        $src = Str::replaceFirst('cub', 'lion', $src);
                    }
                    if (Str::contains($src, 'cubyoung')) {
                        $src = Str::replaceFirst('cubyoung', 'lion', $src);
                    }
                    if (Str::contains($src, 'teen/male')) {
                        $src = Str::replaceFirst('teen/male', 'lion', $src);
                    }
                    if (Str::contains($src, 'teen/female')) {
                        $src = Str::replaceFirst('teen/female', 'lion', $src);
                    }
                }
                if ($forceAdultFemale) {
                    if (Str::contains($src, 'lion')) {
                        $src = Str::replaceFirst('lion', 'lioness', $src);
                    }
                    if (Str::contains($src, 'cub')) {
                        $src = Str::replaceFirst('cub', 'lioness', $src);
                    }
                    if (Str::contains($src, 'cubyoung')) {
                        $src = Str::replaceFirst('cubyoung', 'lioness', $src);
                    }
                    if (Str::contains($src, 'teen/male')) {
                        $src = Str::replaceFirst('teen/male', 'lioness', $src);
                    }
                    if (Str::contains($src, 'teen/female')) {
                        $src = Str::replaceFirst('teen/female', 'lioness', $src);
                    }
                }

                return [
                    'src' => $src,
                    'opacity' => $opacity
                        ? '1'
                        : (Str::contains($style, 'opacity')
                            ? Str::betweenFirst($style, 'opacity:', ';')
                            : '1'),
                ];
            })
            ->filter();

        // set image parameters
        $width = 640;
        $height = 500;

        $output = imagecreatetruecolor($width, $height);
        $trans_colour = imagecolorallocatealpha($output, 0, 0, 0, 127);
        imagefill($output, 0, 0, $trans_colour);
        imagesavealpha($output, true);

        $images->each(function ($image) use ($output, $width, $height) {
            $image_layer = @imagecreatefrompng("https:{$image['src']}");
            if ($image_layer) {
                imagealphablending($image_layer, false);
                imagesavealpha($image_layer, true);
                imagefilter($image_layer, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * (1 - $image['opacity']));

                imagecopy($output, $image_layer, 0, 0, 0, 0, $width, $height);
            }
        });

        ob_start();
        imagepng($output);
        $output_data = ob_get_contents();
        ob_end_clean();

        Log::info("Generated image for lion: {$data['url']}");

        return 'data:image/png;base64,'.base64_encode($output_data);
    }

    public function asController(ActionRequest $request)
    {
        $output = $this->handle($request->all());
        session()->flash('base64', $output);

        return redirect()->back();
    }
}
