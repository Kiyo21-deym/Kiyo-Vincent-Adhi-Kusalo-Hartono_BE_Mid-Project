@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Detail Anggota</h2>
            <a href="{{ route('members.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h4>{{ $member->name }}</h4>
                        <p class="text-muted">{{ $member->member_code }}</p>
                        
                        <hr>
                        
                        <div class="text-start">
                            <p><i class="fas fa-envelope"></i> {{ $member->email }}</p>
                            <p><i class="fas fa-phone"></i> {{ $member->phone }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $member->address ?? '-' }}</p>
                            <p><i class="fas fa-calendar"></i> Bergabung: {{ $member->join_date->format('d M Y') }}</p>
                        </div>

                        <hr>

                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                <i class="fas fa-trash"></i> Hapus Anggota
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-history"></i> Riwayat Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        @forelse($member->borrowings as $borrowing)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6>
                                        <span class="badge bg-{{ $borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                            {{ ucfirst($borrowing->status) }}
                                        </span>
                                        #{{ $borrowing->id }}
                                    </h6>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-calendar"></i> Pinjam: {{ $borrowing->borrow_date->format('d/m/Y') }}
                                        @if($borrowing->return_date)
                                            | Kembali: {{ $borrowing->return_date->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('borrowings.show', $borrowing->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                            
                            <strong>Buku yang dipinjam:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($borrowing->borrowingDetails as $detail)
                                <li>{{ $detail->book->title }} ({{ $detail->quantity }}x)</li>
                                @endforeach
                            </ul>
                        </div>
                        @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada riwayat peminjaman
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection