@php
    $bottomItems = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'patterns' => ['dashboard'],
            'icon' => '<svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z"/></svg>',
        ],
        [
            'label' => 'Purchases',
            'route' => 'ticket_purchases.index',
            'patterns' => ['ticket_purchases.*'],
            'icon' => '<svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>',
        ],
        [
            'label' => 'Sales',
            'route' => 'ticket_sales.index',
            'patterns' => ['ticket_sales.*'],
            'icon' => '<svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>',
        ],
    ];

    $user = auth()->user();
    $bottomItems = array_values(
        array_filter($bottomItems, function (array $item) use ($user) {
            if (!$user) {
                return true;
            }
            return permissionExists($item['route']);
        }),
    );

    $bottomItems = array_slice($bottomItems, 0, 3);
@endphp

   <!-- MOBILE BOTTOM BAR -->
   <nav class="fixed bottom-0 left-0 right-0 z-30 border-t border-slate-200 bg-white/90 backdrop-blur md:hidden">
       <div class="mx-auto grid max-w-3xl grid-cols-5 px-2 py-2">
           <button id="bottomMenuBtn"
               class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                   <path d="M3 7h18M3 12h18M3 17h18" />
               </svg>
               <span class="text-[11px] font-semibold">Menu</span>
           </button>

           @foreach ($bottomItems as $item)
               @php
                   $patterns = $item['patterns'] ?? [];
                   if (!empty($item['route'])) {
                       $patterns[] = $item['route'];
                   }
                   $active = !empty($patterns) ? request()->routeIs($patterns) : false;
               @endphp
               <a href="{{ route($item['route']) }}"
                   class="{{ $active ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-50' }} flex flex-col items-center gap-1 rounded-xl p-2">
                   {!! $item['icon'] !!}
                   <span class="text-[11px] font-semibold">{{ $item['label'] }}</span>
               </a>
           @endforeach

           <button id="bottomProfileBtn"
               class="flex flex-col items-center gap-1 rounded-xl p-2 text-slate-700 hover:bg-slate-50">
               <span
                   class="grid h-6 w-6 place-items-center rounded-full bg-slate-900 text-[10px] font-bold text-white">
                   {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
               </span>
               <span class="text-[11px] font-semibold">Profile</span>
           </button>
       </div>

       <!-- Bottom profile menu -->
       <div id="bottomProfileMenu" class="hidden border-t border-slate-200 bg-white">
           <div class="mx-auto max-w-3xl px-3 py-2">
               <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                   <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                   <div class="h-px bg-slate-200"></div>
                   <form method="POST" action="{{ route('logout') }}">
                       @csrf
                       <button type="submit"
                           class="block w-full px-4 py-3 text-left text-sm font-semibold text-rose-600 hover:bg-rose-50">
                           Logout
                       </button>
                   </form>
               </div>
           </div>
       </div>
   </nav>
