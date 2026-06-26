<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

class EmbedSanitizer
{
    private HTMLPurifier $purifier;
    private array $allowedDomains;

    public function __construct()
    {
        $this->allowedDomains = config('embed_whitelist.allowed_domains', []);

        $config = HTMLPurifier_Config::createDefault();

        // Allow only iframe + safe attributes
        $config->set('HTML.AllowedElements', 'iframe,div,span');
        $config->set('HTML.AllowedAttributes', implode(',', [
            'iframe.src',
            'iframe.width',
            'iframe.height',
            'iframe.frameborder',
            'iframe.allow',
            'iframe.allowfullscreen',
            'iframe.title',
            'iframe.loading',
            'iframe.style',
            'iframe.class',
            'iframe.id',
            'div.id',
            'div.class',
            'div.style',
            'div.data-panorama',
            'div.data-config',
            'span.class',
        ]));

        $config->set('HTML.SafeIframe', true);

        // Allow data-* attributes for Pannellum
        $config->set('HTML.Trusted', false);
        $config->set('CSS.AllowedProperties', 'width,height,border,overflow');
        $config->set('URI.SafeIframeRegexp', $this->buildSafeIframeRegexp());

        $def = $config->getHTMLDefinition(true);
        if ($def) {
            $def->addElement('iframe', 'Block', 'Flow', 'Common', [
                'src*' => 'URI',
                'width' => 'Length',
                'height' => 'Length',
                'frameborder' => 'Pixels',
                'allow' => 'Text',
                'allowfullscreen' => 'Bool',
                'title' => 'Text',
                'loading' => 'Text',
                'style' => 'Text',
                'class' => 'Text',
                'id' => 'ID',
            ]);
            $def->addAttribute('div', 'data-panorama', 'Text');
            $def->addAttribute('div', 'data-config', 'Text');
        }

        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Sanitize embed code — returns safe HTML or throws if domain not whitelisted.
     */
    public function sanitize(string $rawCode): string
    {
        // Pre-check: validate iframe src domain before purification
        $this->validateIframeDomain($rawCode);

        return $this->purifier->purify($rawCode);
    }

    /**
     * Validate that all iframe src attributes point to whitelisted domains.
     *
     * @throws \InvalidArgumentException
     */
    private function validateIframeDomain(string $code): void
    {
        preg_match_all('/<iframe[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $code, $matches);

        foreach ($matches[1] as $src) {
            $host = parse_url($src, PHP_URL_HOST);
            $allowed = false;

            foreach ($this->allowedDomains as $domain) {
                if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                    $allowed = true;
                    break;
                }
            }

            if (! $allowed) {
                throw new \InvalidArgumentException(
                    "Domain '{$host}' tidak diizinkan. Gunakan domain yang terdaftar di whitelist."
                );
            }
        }
    }

    /**
     * Build regex pattern for HTMLPurifier URI.SafeIframeRegexp from whitelist.
     */
    private function buildSafeIframeRegexp(): string
    {
        $escaped = array_map(fn($d) => preg_quote($d, '%'), $this->allowedDomains);
        $pattern = implode('|', $escaped);

        return "%^https?://(?:[a-z0-9\-]+\.)*(?:{$pattern})/%i";
    }
}
