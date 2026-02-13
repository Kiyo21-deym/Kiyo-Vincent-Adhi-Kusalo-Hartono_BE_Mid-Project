@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Detail Buku</h2>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $book->title }}">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" 
                                 style="height: 400px;">
                                <i class="fas fa-book fa-5x"></i>
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-edit"></i> Edit Buku
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" 
                                        onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <i class="fas fa-trash"></i> Hapus Buku
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <h3>{{ $book->title }}</h3>
                        <p class="text-muted">{{ $book->author }}</p>
                        <hr>

                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Kategori</th>
                                <td>
                                    <span class="badge bg-info">{{ $book->category->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $book->publisher }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>{{ $book->publication_year }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }}">
                                        {{ $book->stock }} buku
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Ditambahkan</th>
                                <td>{{ $book->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Update</th>
                                <td>{{ $book->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>

                        @if($book->description)
                        <hr>
                        <h5>Deskripsi</h5>
                        <p>{{ $book->description }}</p>
                        @endif

                        @if($book->borrowingDetails->count() > 0)
                        <hr>
                        <h5>Riwayat Peminjaman</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pinjam</th>
                                        <th>Peminjam</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book->borrowingDetails->take(5) as $detail)
                                    <tr>
                                        <td>{{ $detail->borrowing->borrow_date->format('d/m/Y') }}</td>
                                        <td>{{ $detail->borrowing->member->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>
                                            <span class="badge bg-{{ $detail->borrowing->status == 'borrowed' ? 'warning' : 'success' }}">
                                                {{ ucfirst($detail->borrowing->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection