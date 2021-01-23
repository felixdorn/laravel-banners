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
    private int $width;
    private int $height;

    final public function __construct(
        string $title = null,
        string $body = null,
        string $image = null,
        string $theme = null,
        int $width = null,
        int $height = null
    )
    {
        $this->title = $title ?? config('banners.title');
        $this->body = $body ?? config('banners.body');
        $this->image = $image ?? config('banners.image');
        $this->theme = $theme ?? config('banners.theme');
        $this->width = $width ?? config('banners.width');
        $this->height = $height ?? config('banners.height');
    }

    public static function make(
        string $title = null,
        string $body = null,
        string $image = null,
        string $theme = null,
        int $width = null,
        int $height = null
    ): StreamedResponse
    {
        return (new static($title, $body, $image, $theme, $width, $height))->downloadResponse();
    }

    public function downloadResponse(): StreamedResponse
    {
        return response()->stream(function () {
            echo $this->takeScreenshot();
        }, 200, [
            'Content-Type' => 'image/png'
        ]);
    }

    private function takeScreenshot(): string
    {
        $payload = json_encode([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'theme' => $this->theme,
            'hash' => sha1_file(__DIR__ . '/../resources/views/render.blade.php') // TODO: Custom views wont get the right hash
        ], JSON_THROW_ON_ERROR);
        $cacheKey = base64_encode($payload);

        if ($cacheKey) {
            return Cache::get($cacheKey);
        }

        $screenshot = $this->configureBrowserShot(
            Browsershot::url(
                route('render-banner') . '?' . http_build_query([
                    'payload' => $payload
                ])
            )->windowSize($this->width, $this->height)
        )->screenshot();

        Cache::put(base64_encode($payload), $screenshot);

        return $screenshot;
    }

    public function configureBrowserShot(Browsershot $browserShot): Browsershot
    {
        return $browserShot->addChromiumArguments(app()->environment('local') ? [
            'ignore-certificate-errors'
        ] : [])
            ->setNodeBinary(config('banners.node'))
            ->setNpmBinary(config('banners.npm'))
            ->setNodeModulePath(config('banners.node_modules'))
            ->disableJavascript()
            ->waitUntilNetworkIdle()
            ->fullPage();
    }
}
