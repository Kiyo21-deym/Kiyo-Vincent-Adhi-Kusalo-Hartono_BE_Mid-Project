@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <h6>Total Buku</h6>
            <h3>{{ $stats['total_books'] }}</h3>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i> +3.4%
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <h6>Total Anggota</h6>
            <h3>{{ $stats['total_members'] }}</h3>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i> +5.2%
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="icon">
                <i class="fas fa-sync"></i>
            </div>
            <h6>Peminjaman Aktif</h6>
            <h3>{{ $stats['active_borrowings'] }}</h3>
            <div class="trend">Stable</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h6>Buku Dipinjam</h6>
            <h3>{{ $stats['total_borrowed_books'] }}</h3>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i> +12%
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-clock me-2"></i>Transaksi Terbaru</h5>
                <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Anggota</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_borrowings as $borrowing)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 50px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">
                                            {{ $borrowing->borrowingDetails->first()->book->title ?? 'N/A' }}
                                        </div>
                                        @if($borrowing->borrowingDetails->count() > 1)
                                        <small class="text-muted">+{{ $borrowing->borrowingDetails->count() - 1 }} buku lainnya</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div style="font-weight: 500;">{{ $borrowing->member->name }}</div>
                                    <small class="text-muted">{{ $borrowing->member->member_code }}</small>
                                </div>
                            </td>
                            <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                    {{ $borrowing->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="fas fa-exclamation-circle me-2"></i>Stok Menipis</h5>
            </div>
            
            @forelse($low_stock_books as $book)
            <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded" style="background: #fef3c7;">
                <div style="width: 40px; height: 50px; background: white; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book text-warning"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 500; font-size: 0.875rem;">{{ Str::limit($book->title, 30) }}</div>
                    <small class="text-muted">Stok: {{ $book->stock }}</small>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">
                <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                <small>Semua stok aman</small>
            </div>
            @endforelse
            
            @if($low_stock_books->count() > 0)
            <a href="{{ route('books.index') }}" class="btn btn-sm btn-warning w-100 mt-3">
                <i class="fas fa-eye"></i> Lihat Semua Buku
            </a>
            @endif
        </div>
    </div>
</div>
@endsection