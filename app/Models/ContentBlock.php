<?php
// app/Models/ContentBlock.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ContentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    // Static Helper Methods
    public static function getValue(string $key, string $default = ''): string
    {
        $block = static::active()->where('key', $key)->first();

        if (!$block) {
            return $default;
        }

        // Handle different content types
        return match($block->type) {
            'boolean' => $block->content ? 'true' : 'false',
            'number' => (string) $block->content,
            'json' => $block->content, // Return raw JSON string
            default => $block->content
        };
    }

    public static function getJsonValue(string $key, array $default = []): array
    {
        $block = static::active()->where('key', $key)->where('type', 'json')->first();

        if (!$block) {
            return $default;
        }

        $decoded = json_decode($block->content, true);
        return is_array($decoded) ? $decoded : $default;
    }

    public static function getBooleanValue(string $key, bool $default = false): bool
    {
        $block = static::active()->where('key', $key)->where('type', 'boolean')->first();
        return $block ? (bool) $block->content : $default;
    }

    public static function getNumberValue(string $key, float $default = 0): float
    {
        $block = static::active()->where('key', $key)->where('type', 'number')->first();
        return $block ? (float) $block->content : $default;
    }

    public static function setValue(string $key, string $title, $content, string $type = 'text', string $description = ''): self
    {
        // Convert content based on type
        $processedContent = match($type) {
            'json' => is_string($content) ? $content : json_encode($content),
            'boolean' => $content ? '1' : '0',
            'number' => (string) $content,
            default => (string) $content
        };

        return static::updateOrCreate(
            ['key' => $key],
            [
                'title' => $title,
                'content' => $processedContent,
                'type' => $type,
                'description' => $description,
                'is_active' => true,
            ]
        );
    }

    // Accessors
    public function getFormattedContentAttribute(): string
    {
        return match($this->type) {
            'json' => 'Data JSON (' . str_word_count($this->content) . ' karakter)',
            'boolean' => $this->content ? 'Ya' : 'Tidak',
            'number' => number_format((float) $this->content, 0, ',', '.'),
            'image' => 'Gambar: ' . basename($this->content),
            'url' => 'Link: ' . $this->content,
            default => Str::limit($this->content, 100)
        };
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'text' => 'Teks Pendek',
            'textarea' => 'Teks Panjang',
            'json' => 'Data JSON',
            'image' => 'Gambar',
            'url' => 'URL/Link',
            'number' => 'Angka',
            'boolean' => 'Ya/Tidak',
            default => ucfirst($this->type)
        };
    }
}
