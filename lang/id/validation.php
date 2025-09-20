<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut mengandung pesan kesalahan default yang digunakan oleh
    | kelas validator. Beberapa aturan ini memiliki beberapa versi
    | seperti aturan ukuran. Jangan ragu untuk menyesuaikan masing-masing pesan ini di sini.
    |
    */

    'accepted' => 'Bidang :attribute harus diterima.',
    'accepted_if' => 'Bidang :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Bidang :attribute harus URL yang valid.',
    'after' => 'Bidang :attribute harus tanggal setelah :date.',
    'after_or_equal' => 'Bidang :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => 'Bidang :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Bidang :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => 'Bidang :attribute hanya boleh berisi huruf dan angka, tidak boleh ada spasi.',
    'array' => 'Bidang :attribute harus berupa array.',
    'ascii' => 'Bidang :attribute hanya boleh berisi karakter alfanumerik dan simbol single-byte.',
    'before' => 'Bidang :attribute harus tanggal sebelum :date.',
    'before_or_equal' => 'Bidang :attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Bidang :attribute harus memiliki antara :min dan :max item.',
        'file' => 'Bidang :attribute harus antara :min dan :max kilobyte.',
        'numeric' => 'Bidang :attribute harus antara :min dan :max.',
        'string' => 'Bidang :attribute harus antara :min dan :max karakter.',
    ],
    'boolean' => 'Bidang :attribute harus benar atau salah.',
    'can' => 'Bidang :attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => 'Bidang :attribute harus tanggal yang valid.',
    'date_equals' => 'Bidang :attribute harus tanggal yang sama dengan :date.',
    'date_format' => 'Bidang :attribute harus sesuai dengan format :format.',
    'decimal' => 'Bidang :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Bidang :attribute harus ditolak.',
    'declined_if' => 'Bidang :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Bidang :attribute dan :other harus berbeda.',
    'digits' => 'Bidang :attribute harus :digits digit.',
    'digits_between' => 'Bidang :attribute harus antara :min dan :max digit.',
    'dimensions' => 'Bidang :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Bidang :attribute memiliki nilai duplikat.',
    'doesnt_end_with' => 'Bidang :attribute tidak boleh berakhir dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => 'Bidang :attribute tidak boleh dimulai dengan salah satu dari berikut: :values.',
    'email' => 'Bidang :attribute harus alamat email yang valid.',
    'ends_with' => 'Bidang :attribute harus berakhir dengan salah satu dari berikut: :values.',
    'enum' => 'Pilihan :attribute tidak valid.',
    'exists' => 'Pilihan :attribute tidak valid.',
    'extensions' => 'Bidang :attribute harus memiliki ekstensi berikut: :values.',
    'file' => 'Bidang :attribute harus berupa file.',
    'filled' => 'Bidang :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Bidang :attribute harus memiliki lebih dari :value item.',
        'file' => 'Bidang :attribute harus lebih besar dari :value kilobyte.',
        'numeric' => 'Bidang :attribute harus lebih besar dari :value.',
        'string' => 'Bidang :attribute harus lebih besar dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Bidang :attribute harus memiliki :value item atau lebih.',
        'file' => 'Bidang :attribute harus lebih besar atau sama dengan :value kilobyte.',
        'numeric' => 'Bidang :attribute harus lebih besar atau sama dengan :value.',
        'string' => 'Bidang :attribute harus lebih besar atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Bidang :attribute harus warna heksadesimal yang valid.',
    'image' => 'Bidang :attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Bidang :attribute tidak ada di :other.',
    'integer' => 'Bidang :attribute harus bilangan bulat.',
    'ip' => 'Bidang :attribute harus alamat IP yang valid.',
    'ipv4' => 'Bidang :attribute harus alamat IPv4 yang valid.',
    'ipv6' => 'Bidang :attribute harus alamat IPv6 yang valid.',
    'json' => 'Bidang :attribute harus string JSON yang valid.',
    'lowercase' => 'Bidang :attribute harus huruf kecil semua.',
    'lt' => [
        'array' => 'Bidang :attribute harus kurang dari :value item.',
        'file' => 'Bidang :attribute harus kurang dari :value kilobyte.',
        'numeric' => 'Bidang :attribute harus kurang dari :value.',
        'string' => 'Bidang :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Bidang :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Bidang :attribute harus kurang dari atau sama dengan :value kilobyte.',
        'numeric' => 'Bidang :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Bidang :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Bidang :attribute harus alamat MAC yang valid.',
    'max' => [
        'array' => 'Bidang :attribute tidak boleh lebih dari :max item.',
        'file' => 'Bidang :attribute tidak boleh lebih dari :max kilobyte.',
        'numeric' => 'Bidang :attribute tidak boleh lebih dari :max.',
        'string' => 'Bidang :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Bidang :attribute tidak boleh lebih dari :max digit.',
    'mimes' => 'Bidang :attribute harus berkas tipe: :values.',
    'mimetypes' => 'Bidang :attribute harus berkas tipe: :values.',
    'min' => [
        'array' => 'Bidang :attribute harus setidaknya :min item.',
        'file' => 'Bidang :attribute harus setidaknya :min kilobyte.',
        'numeric' => 'Bidang :attribute harus setidaknya :min.',
        'string' => 'Bidang :attribute harus setidaknya :min karakter.',
    ],
    'min_digits' => 'Bidang :attribute harus setidaknya :min digit.',
    'missing' => 'Bidang :attribute harus hilang.',
    'missing_if' => 'Bidang :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Bidang :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Bidang :attribute harus hilang ketika :values ada.',
    'missing_with_all' => 'Bidang :attribute harus hilang ketika semua :values ada.',
    'multiple_of' => 'Bidang :attribute harus kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute tidak valid.',
    'not_regex' => 'Format bidang :attribute tidak valid.',
    'numeric' => 'Bidang :attribute harus angka.',
    'password' => [
        'letters' => 'Bidang :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Bidang :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Bidang :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Bidang :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Data :attribute telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => 'Bidang :attribute harus ada.',
    'present_if' => 'Bidang :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Bidang :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Bidang :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Bidang :attribute harus ada ketika semua :values ada.',
    'prohibited' => 'Bidang :attribute dilarang.',
    'prohibited_if' => 'Bidang :attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => 'Bidang :attribute dilarang kecuali :other ada di :values.',
    'prohibits' => 'Bidang :attribute melarang :other dari keberadaan.',
    'regex' => 'Format bidang :attribute tidak valid.',
    'required' => 'Bidang :attribute diperlukan.',
    'required_array_keys' => 'Bidang :attribute harus mengandung entri untuk: :values.',
    'required_if' => 'Bidang :attribute diperlukan ketika :other adalah :value.',
    'required_if_accepted' => 'Bidang :attribute diperlukan ketika :other diterima.',
    'required_unless' => 'Bidang :attribute diperlukan kecuali :other ada di :values.',
    'required_with' => 'Bidang :attribute diperlukan ketika :values ada.',
    'required_with_all' => 'Bidang :attribute diperlukan ketika semua :values ada.',
    'required_without' => 'Bidang :attribute diperlukan ketika :values tidak ada.',
    'required_without_all' => 'Bidang :attribute diperlukan ketika tidak ada :values.',
    'same' => 'Bidang :attribute dan :other harus cocok.',
    'size' => [
        'array' => 'Bidang :attribute harus mengandung :size item.',
        'file' => 'Bidang :attribute harus :size kilobyte.',
        'numeric' => 'Bidang :attribute harus :size.',
        'string' => 'Bidang :attribute harus :size karakter.',
    ],
    'starts_with' => 'Bidang :attribute harus dimulai dengan salah satu dari berikut: :values.',
    'string' => 'Bidang :attribute harus berupa string.',
    'timezone' => 'Bidang :attribute harus zona waktu yang valid.',
    'unique' => ':attribute sudah diambil.',
    'uploaded' => 'Bidang :attribute gagal diunggah.',
    'uppercase' => 'Bidang :attribute harus huruf besar semua.',
    'url' => 'Bidang :attribute harus URL yang valid.',
    'ulid' => 'Bidang :attribute harus ULID yang valid.',
    'uuid' => 'Bidang :attribute harus UUID yang valid.',
    'indisposable' => 'Alamat email sekali pakai tidak diizinkan.',
    'not_indisposable' => 'Alamat email sekali pakai tidak diizinkan.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Khusus
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi khusus untuk atribut dengan menggunakan
    | konvensi "nama-atribut.aturan" untuk memberi nama baris. Ini memudahkan
    | untuk menentukan pesan bahasa khusus untuk aturan atribut tertentu.
    |
    */

    'custom' => [
        'nama-atribut' => [
            'nama-aturan' => 'pesan-khusus',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Khusus
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar placeholder atribut
    | dengan sesuatu yang lebih ramah pembaca seperti "Alamat E-Mail" daripada
    | "email". Ini hanya membantu kami membuat pesan kami lebih ekspresif.
    |
    */

    'attributes' => [],

];
