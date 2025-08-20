@component('mail::message')
# Xin chào {{ $user->name }}

Báo cáo hằng ngày:

- Tên: {{ $user->name }}
- Email: {{ $user->email }}
- Ngày tham gia: {{ $user->created_at->format('d/m/Y') }}



@endcomponent
