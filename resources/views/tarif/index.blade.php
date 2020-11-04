<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Edit Data Pedagang | BP3C</title>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
@endsection


@section('js')
<!-- Tambah Content pada Body JS -->
@endsection