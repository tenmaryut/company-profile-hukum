@extends('errors.layout')

@section('code', '419')
@section('title', 'Sesi sudah kedaluwarsa')
@section('message', 'Halaman form terlalu lama dibiarkan terbuka. Muat ulang halaman, lalu kirim ulang isian Anda.')
@section('actions')
    <a href="{{ url('/kontak') }}" class="btn btn-secondary">Buka form lagi</a>
@endsection
