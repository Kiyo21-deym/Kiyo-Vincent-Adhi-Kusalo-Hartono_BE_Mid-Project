@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Detail Peminjaman #{{ $borrowing->id }}</h2>
            <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6 class="text-muted">Status</h6>
                        <h4>
                            <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                {{ $borrowing->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                            </span>
                        </h4>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Tanggal Pinjam</h6>
                        <h5>{{ $borrowing->borrow_date->format('d M Y') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-muted">Tanggal Kembali</h6>
                        <h5>{{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}</h5>
                    </div>
                    <div class="col-md-3">
                        @if($borrowing->status == 'borrowed')
                        <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Konfirmasi pengembalian buku?')">
                                <i class="fas fa-check"></i> Kembalikan Buku
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-user"></i> Data Peminjam</h5>
                    </div>
                    <div class="card-body">
                        <h5>{{ $borrowing->member->name }}</h5>
                        <p class="text-muted">{{ $borrowing->member->member_code }}</p>
                        <hr>
                        <p><i class="fas fa-envelope"></i> {{ $borrowing->member->email }}</p>
                        <p><i class="fas fa-phone"></i> {{ $borrowing->member->phone }}</p>
                        <a href="{{ route('members.show', $borrowing->member->id) }}" class="btn btn-info btn-sm w-100">
                            <i class="fas fa-eye"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-book"></i> Buku yang Dipinjam ({{ $borrowing->total_books }} buku)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">Cover</th>
                                        <th>Judul Buku</th>
                                        <th>Penulis</th>
                                        <th width="15%">Kategori</th>
                                        <th width="10%">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowing->borrowingDetails as $detail)
                                    <tr>
                                        <td>
                                            @if($detail->book->cover_image)
                                                <img src="{{ asset('storage/' . $detail->book->cover_image) }}" 
                                                     alt="{{ $detail->book->title }}"
                                                     class="img-thumbnail"
                                                     style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 70px;">
                                                    <i class="fas fa-book text-white"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $detail->book->title }}</strong><br>
                                            <small class="text-muted">ISBN: {{ $detail->book->isbn }}</small>
                                        </td>
                                        <td>{{ $detail->book->author }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $detail->book->category->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $detail->quantity }}x</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection