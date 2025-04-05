<?php

if (!function_exists('generate_breadcrumbs')) {
    function generate_breadcrumbs($data = [])
    {
        $segments = request()->segments();
        $breadcrumbs = [];
        $url = '';
        foreach ($segments as $key => $segment) {
            $url .= '/' . $segment;
            if (is_numeric($segment)) {
                $text = 'Detail'; // Default untuk ID
            } else {
                $text = ucwords(str_replace(['-', '_'], ' ', $segment));
            }
            $breadcrumbs[] = [
                'text' => $text,
                'link' => $url
            ];
        }
        // Ganti teks terakhir dengan $data['title'] jika ada
        if (!empty($breadcrumbs)) {
            $lastIndex = count($breadcrumbs) - 1;
            if (isset($data['title']) && !empty($data['title'])) {
                // dd($data['title']);
                $breadcrumbs[$lastIndex]['text'] = $data['title'];
            }
            // Hapus link dari item terakhir
            $breadcrumbs[$lastIndex]['link'] = '';
        }
        // dd($breadcrumbs);
        return $breadcrumbs;
    }
}
