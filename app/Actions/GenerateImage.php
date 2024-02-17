<?php
namespace App\Actions;

use Imagick;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\ValidationException;

class GenerateImage
{
    use AsAction;

    public function rules(): array
    {
        return [
            'url' => ['url', 'required', function (string $attribute, mixed $value, \Closure $fail) {
                if(!Str::startsWith($value, 'https://www.lioden.com/lion.php')) {
                    $fail('Not a valid Lioden url.');
                }
            }],
            'decorations' => ['boolean'],
            'background' => ['boolean'],
            'opacity' => ['boolean'],
        ];
    }

    public function handle(array $data = [])
    {
        $decorations = $data['decorations'] ?? false;
        $background = $data['background'] ?? false;
        $opacity = $data['opacity'] ?? false;

        $html = file_get_contents($data['url']);

        // use DOMDocument to load the page
		libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;

        // get the lion images
        $images = collect($dom->getElementsByTagName('img'))
            ->transform(function ($image) use($background, $decorations, $opacity) {
                $src = $image->getAttribute('src');
                $style = $image->getAttribute('style');

                // remove non-lion related images
                if(!Str::contains($src, ['dynamic', 'decors'])) {
                    return null;
                }

                // remove background if needed
                if(!$background && Str::contains($src, 'backgrounds')) {
                    return null;
                }

                // remove decors if needed
                if(!$decorations && Str::contains($src, 'decors')) {
                    return null;
                }

                return [
                    'src' => $src,
                    'opacity' => $opacity
                        ? "1"
                        : (Str::contains($style, 'opacity')
                            ? Str::betweenFirst($style, 'opacity:', ';')
                            : "1"),
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

        $images->each(function ($image) use($output, $width, $height) {
            $image_layer = imagecreatefrompng("https:{$image['src']}");
			imagealphablending($image_layer, false);
			imagesavealpha($image_layer, true);
			imagefilter($image_layer, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * (1 - $image['opacity']));

			imagecopy($output, $image_layer, 0, 0, 0, 0, $width, $height);
        });

		ob_start();
		imagepng($output);
		$output_data = ob_get_contents();
		ob_end_clean();

        return "data:image/png;base64," . base64_encode($output_data);
    }

    public function asController(ActionRequest $request)
    {
        $output = $this->handle($request->all());
        session()->flash('base64', $output);
        return redirect()->back();
    }
}
