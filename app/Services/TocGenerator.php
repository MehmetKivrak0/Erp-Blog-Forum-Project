<?php

namespace App\Services;

use Illuminate\Support\Str;

class TocGenerator
{
    /**
     * Parses HTML content to add IDs to headings (h2, h3) and generates TOC data.
     * Returns an array with ['content' => $modifiedContent, 'toc' => $tocArray]
     */
    public function generate(string $content): array
    {
        $toc = [];
        // Matches <h2...>...</h2> or <h3...>...</h3>
        $pattern = '/<(h[2-3])(.*?)>(.*?)<\/\1>/is';
        
        $modifiedContent = preg_replace_callback($pattern, function ($matches) use (&$toc) {
            $tag = $matches[1]; // e.g. h2
            $attributes = $matches[2];
            $htmlContent = $matches[3];
            $text = strip_tags($htmlContent);
            $slug = Str::slug($text);
            
            if (empty($slug)) {
                $slug = 'heading-' . uniqid();
            }

            // Handle duplicate slugs
            $id = $slug;
            $counter = 1;
            while(in_array($id, array_column($toc, 'id'))) {
                $id = $slug . '-' . $counter;
                $counter++;
            }

            // Append id if not exists
            if (!preg_match('/id=[\'"]([^\'"]+)[\'"]/i', $attributes, $idMatches)) {
                $attributes .= ' id="' . $id . '"';
            } else {
                $id = $idMatches[1];
            }

            $toc[] = [
                'id' => $id,
                'title' => trim($text),
                'level' => (int) str_replace('h', '', strtolower($tag)),
            ];

            return "<{$tag}{$attributes}>{$htmlContent}</{$tag}>";
        }, $content);

        return [
            'content' => $modifiedContent,
            'toc' => $toc
        ];
    }
}
