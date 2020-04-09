<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class TestExtensionTwig extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    /**
     * @param string $content
     * @param int $maxlength
     * @return string
     */
    public function excerpt(string $content, int $maxlength = 250): string
    {
        if (mb_strlen($content) > $maxlength) {
            $excerpt = mb_substr($content, 0, $maxlength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace) . '...';
        }
        return $content;
    }
}