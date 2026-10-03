@extends('errors.layout')

@section('code', '404')
@section('title', 'Halaman tidak ditemukan')
@section('message', 'Tautan yang Anda buka mungkin sudah berubah atau halamannya sudah dihapus. Coba cari di artikel atau kembali ke beranda.')
@section('actions')
    <a href="{{ url('/artikel') }}" class="btn btn-secondary">Lihat artikel</a>
@endsection
