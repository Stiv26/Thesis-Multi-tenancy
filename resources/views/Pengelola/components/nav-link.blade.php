{{-- PROPOS ADALAH FUNGSI ARRAY UNTUK PROPERTI NAVIGASI KITA, FALSE ADALAH NILAI DEFAULTNYA --}}
@props(['active' => false])
<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
{{-- SLOT DARI X-NAV-LINK PADA NAVBAR COMPONENT --}}
<a {{ $attributes }} 
class="{{ $active ? ' bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>