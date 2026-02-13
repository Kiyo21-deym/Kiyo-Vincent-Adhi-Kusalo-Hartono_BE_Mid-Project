@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Daftar Peminjaman</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Peminjaman Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jumlah Buku</th>
                        <th width="12%">Status</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $key => $borrowing)
                    <tr>
                        <td>{{ $borrowings->firstItem() + $key }}</td>
                        <td>{{ $borrowing->member->member_code }}</td>
                        <td>{{ $borrowing->member->name }}</td>
                        <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                        <td>{{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $borrowing->total_books }} buku</td>
                        <td>
                            <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                {{ $borrowing->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('borrowings.show', $borrowing->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($borrowing->status == 'borrowed')
                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success" 
                                        onclick="return confirm('Konfirmasi pengembalian?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection