@section('title', $data['title'] ?? 'Dashboard' . ' | ' . config('app.name'))
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:px-4">
        <div class="mb-3 py-2">
            <h1 class="text-2xl font-semibold">Dashboard Empty</h1>
        </div>

        <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 lg:gap-4">
            <div class="animate-pulse rounded">
                <p class="bg-foreground/20 h-4 rounded-full" style="width: 40%;"></p>

                <ul class="mt-5 space-y-3">
                    <li class="bg-foreground/20 h-4 w-full rounded-full"></li>
                    <li class="bg-foreground/20 h-4 w-full rounded-full"></li>
                    <li class="bg-foreground/20 h-4 w-full rounded-full"></li>
                    <li class="bg-foreground/20 h-4 w-full rounded-full"></li>
                </ul>
            </div>
            <div class="animate-pulse rounded">
                <p class="bg-foreground/20 h-32 w-full rounded"></p>
            </div>
        </div>
    </section>

    <section class="p-1 md:px-4">
        <div class="animate-pulse rounded">
            <p class="bg-foreground/20 h-32 w-full rounded"></p>
        </div>
    </section>
</x-app-layout>
