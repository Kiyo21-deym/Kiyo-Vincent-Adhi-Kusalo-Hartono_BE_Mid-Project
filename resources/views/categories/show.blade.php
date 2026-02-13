@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Detail Kategori</h2>
            <div>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $category->name }}</h3>
                <p class="text-muted">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Total Buku:</strong> {{ $category->books->count() }} buku</p>
                        <p><strong>Ditambahkan:</strong> {{ $category->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Terakhir Update:</strong> {{ $category->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Buku dalam Kategori Ini</h5>
            </div>
            <div class="card-body">
                @if($category->books->count() > 0)
                <div class="row">
                    @foreach($category->books as $book)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $book->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-book fa-3x text-white"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($book->title, 30) }}</h6>
                                <p class="card-text text-muted small">{{ $book->author }}</p>
                                <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }}">
                                    Stok: {{ $book->stock }}
                                </span>
                            </div>
                            
                            <div class="card-footer">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info w-100">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada buku dalam kategori ini
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection