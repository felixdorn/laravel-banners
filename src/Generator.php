<?php

namespace Delights\Banners;

use Illuminate\Support\Facades\Cache;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Generator
{
    private string $title;
    private string $body;
    private string $image;
    private string $theme;

    final public function __construct(
        string $title = null,
        string $body = null,
        string $image = null,
        string $theme = null
    )
    {
        $this->title = $title ?? config('banners.title');
        $this->body = $body ?? config('banners.body');
        $this->image = $image ?? config('banners.image');
        $this->theme = $theme ?? config('banners.theme');
    }

    public static function make(
        string $title = null,
        string $body = null,
        string $image = null,
        string $theme = null
    ): StreamedResponse
    {
        return (new static($title, $body, $image, $theme))->downloadResponse();
    }

    public function downloadResponse(): StreamedResponse
    {
        $payload = json_encode([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'theme' => $this->theme
        ], JSON_THROW_ON_ERROR);

        $inCache = Cache::has(base64_encode($payload));

        if ($inCache) {
            $screenshot = Cache::get(base64_encode($payload));
        }

        if (!isset($screenshot)) {
            $screenshot = Browsershot::url(
                route('render-banner') . '?' . http_build_query([
                    'payload' => $payload
                ])
            )
                ->windowSize(1200, 620)
                ->addChromiumArguments(app()->environment('local') ? [
                    'ignore-certificate-errors'
                ] : [])
                ->setNodeBinary(config('banners.node'))
                ->setNpmBinary(config('banners.npm'))
                ->setNodeModulePath(config('banners.node_modules'))
                ->disableJavascript()
                ->waitUntilNetworkIdle()
                ->fullPage()
                ->screenshot();

            Cache::put(base64_encode($payload), $screenshot);
        }

        abort_unless($screenshot !== '', 404);

        return response()->stream(function () use ($screenshot) {
            echo $screenshot;
        }, 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
