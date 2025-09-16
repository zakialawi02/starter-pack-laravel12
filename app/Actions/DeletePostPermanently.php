<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeletePostPermanently
{
    public function execute(Article $post): bool
    {
        if ($post->cover) {
            $coverPath = 'media/img/' . basename($post->cover);

            if (Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            } else {
                Log::warning("Gagal hapus file cover: tidak ditemukan di path {$coverPath}");
            }
        }

        // Hapus data dari database
        $post->forceDelete();
        return true;
    }
}
