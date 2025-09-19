<form class="focus:outline-hidden text-foreground/80 hover:bg-foreground/20 focus:bg-foreground/20 flex w-full items-center gap-x-3 rounded-lg px-3 py-2 text-sm disabled:pointer-events-none disabled:opacity-50" id="logout-form" method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="flex w-full items-center gap-x-3 focus:outline-none" type="submit">
        <i class="ri-logout-box-r-line"></i>
        <span>Log out</span>
    </button>
</form>
