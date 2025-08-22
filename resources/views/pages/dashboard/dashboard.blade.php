@section('title', $data['title'] ?? 'Dashboard' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:px-4">
        <div class="py-2">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>

        <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 lg:gap-4">
            <div class="lg:col-span-2">
                <x-card>
                    <div class="mb-3">
                        <h4 class="mb-0 text-xl">Data Masuk | <span class="text-primary">Data Baru</span></h4>
                    </div>
                    <p>Coming Soon new features</p>
                </x-card>
            </div>
            <div class="">
                <x-card>
                    <div class="mb-3">
                        <h4 class="mb-0 text-xl">Penguna | <span class="text-primary">30 hari terakhir</span></h4>
                    </div>
                    <p>Coming Soon new features</p>
                </x-card>
            </div>
        </div>
    </section>
</x-app-layout>
